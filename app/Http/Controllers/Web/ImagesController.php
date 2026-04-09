<?php

namespace App\Http\Controllers\Web;

use App\GlideServerFactory;
use App\Http\Controllers\Controller;

use Illuminate\{
    Contracts\Filesystem\Filesystem,
    Support\Facades\File
};

use League\Glide\Responses\LaravelResponseFactory;

use League\{
    Flysystem\Filesystem as FlyFileSystem,
    Flysystem\Adapter\Local
};

/**
 * Class ImageController
 * @package App\Http\Controllers
 */
class ImagesController extends Controller
{
    /**
     * @param Filesystem $filesystem
     * @param $path
     */
    public function index(Filesystem $filesystem, $path)
    {
        $filePath = base_path(config('glide.images_directory')) . '/' . $path;

        if (!File::exists($filePath)) {
            abort(404);
        }

        // Glide can not work with svg
        if (File::extension($filePath) == 'svg') {
            header('Content-type: image/svg+xml');
            readfile($filePath);
            die;
        }

        $server = (new GlideServerFactory([
            'response' => new LaravelResponseFactory(app('request')),
            'source' => new FlyFileSystem(
                new Local(base_path(config('glide.images_directory')))
            ),
            'cache' => $filesystem->getDriver(),
            'cache_path_prefix' => config('glide.cache_prefix'),
            'base_url' => 'image',
            'driver' => env('IMAGE_EXT', 'gd'),
        ]))->getServer();

        $server->outputImage($path, request()->all());
    }
}
