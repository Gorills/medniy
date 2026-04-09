<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.02.19
 * Time: 15:56
 */

namespace App\Http\Controllers\Web;

use App\Models\Apartment;
use App\Models\Block;
use App\Models\Floor;
use Sitemap;
use App\Http\Controllers\Controller;

class SitemapController extends Controller
{
    public function index()
    {
        Sitemap::addTag(route('home'), null, null, 1);
        Sitemap::addTag(route('gallery'), null, null, 0.9);
/* disabled
        Sitemap::addTag(route('construction-stages'));
        // loop
        Sitemap::addTag(route('construction-stage-detail'));
*/

        Sitemap::addTag(route('mortgage-calc'), null, null, 0.9);
        Sitemap::addTag(route('contacts'), null, null, 0.9);

        Sitemap::addTag(route('apartment-selection'), null, null, 0.9);
        Sitemap::addTag(route('blocks-list'), null, null, 0.9);

        // loop blocks
        $blocks = Block::query()->where('active', true)->get();
        foreach ($blocks as $block) {
            Sitemap::addTag(
                route('building-block', ['block' => $block->number]),
                $block->updated_at,
                null,
                0.8
            );
        }

        // loop floors
        $floors = Floor::query()->where('active', true)->with('block')->get();
        foreach ($floors as $floor) {
            Sitemap::addTag(
                route('block-floor', ['block' => $floor->block->number, 'floor' => $floor->number]),
                $floor->updated_at,
                null,
                0.7
            );
        }

        // loop apartments
        $aparts = Apartment::query()
            ->where('active', true)
            ->get();
        foreach ($aparts as $apart) {
            Sitemap::addTag(
                route('apartment-detail', ['apartment' => $apart->code]),
                $apart->updated_at,
                null,
                0.6
            );
            Sitemap::addTag(
                route('apartment-detail-pdf', ['apartment' => $apart->code]),
                $apart->updated_at,
                null,
                0.6
            );
        }

        Sitemap::addTag(route('documents'), null, null, 0.9);
        Sitemap::addTag(route('politics'), null, null, 0.9);

        return Sitemap::render();
    }
}
