<?php

use Illuminate\Database\Seeder;

use App\Models\{
	MapCategory,
	MapSubcategory,
	MapMarker,
	Block,
	Floor,
	Scheme,
	Decoration,
    GalleryPhoto,
    ConstructionStage
};

/**
 * Class InitDbSeeder
 */
class InitDbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedMapData();
        $this->seedBlocks();
        $this->seedSchemes();
        $this->seedDecorations();
//        $this->seedFloors();
        $this->seedGalleryPhotos();
        $this->seedConstructionStages();
    }

	/**
	 * Seeding the DB with map init data
	 */
    protected function seedMapData()
	{
		foreach (get_mock('map_data') as $categoryArr) {
			$mapCategory= MapCategory::create([
				'active' => true,
				'name' => $categoryArr['name'],
			]);

			if (isset($categoryArr['markers']) && is_array($categoryArr['markers'])) {
				foreach ($categoryArr['markers'] as $categoryMarkerArr) {
					MapMarker::create(array_merge(
						[
							'active' => true,
							'map_category_id' => $mapCategory->id,
						],
						$categoryMarkerArr
					));
				}
			}

			if (isset($categoryArr['subcategories']) && is_array($categoryArr['subcategories'])) {
				foreach ($categoryArr['subcategories'] as $subcategoryArr) {
					$subcategory = MapSubcategory::create([
						'active' => true,
						'map_category_id' => $mapCategory->id,
						'name' => $subcategoryArr['name'],
					]);

					if (isset($subcategoryArr['markers']) && is_array($subcategoryArr['markers'])) {
						foreach ($subcategoryArr['markers'] as $subcategoryMarkerArr) {
							MapMarker::create(array_merge(
								[
									'active' => true,
									'map_category_id' => $mapCategory->id,
									'map_subcategory_id' => $subcategory->id,
								],
								$subcategoryMarkerArr
							));
						}
					}
				}
			}
		}
	}

	/**
	 * Building blocks init seeding
	 */
	public function seedBlocks()
	{
		foreach (get_mock('blocks') as $blockArr) {
			$block = new Block();
			$block->number = $blockArr['number'];
			$block->active = true;
			$block->save();
		}
	}

	/**
	 * Schemes init seeding
	 */
	public function seedSchemes()
	{
		foreach (get_mock('schemes') as $arScheme) {
			$scheme = new Scheme();
            $scheme->active = true;
            $scheme->code = $arScheme['code'];
            $scheme->name = $arScheme['name'];
            $scheme->scheme_svg = $arScheme['scheme_svg'];
            $scheme->scheme_img = $arScheme['scheme_img'];
			$scheme->save();
		}
	}

	/**
	 * Decorations init seeding
	 */
	public function seedDecorations()
	{
		foreach (get_mock('decorations') as $arDecor) {
			$decoration = new Decoration();
            $decoration->active = true;
            $decoration->order = $arDecor['order'];
            $decoration->code = $arDecor['code'];
            $decoration->name = $arDecor['name'];
            $decoration->description = $arDecor['description'];
			$decoration->save();
		}
	}

    /**
     * Floors init seeding
     */
    public function seedFloors()
    {
        foreach (get_mock('floors') as $block_id => $floorsArr) {
            foreach ($floorsArr as $floorNum){
                $floor = new Floor();
                $floor->number = $floorNum;
                $floor->active = true;
                $floor->block_id = $block_id;
                $floor->scheme_id = 1;
                $floor->save();
            }
        }
    }

    /**
     * Construction Stages init seeding
     */
    public function seedConstructionStages()
    {
        foreach (get_mock('construction_stages') as $arStage) {
            $stage = new ConstructionStage();
            $stage->active = true;
            $stage->name = $arStage['name'];
            $stage->image = $arStage['image'];
            $stage->save();
        }
    }

    /**
     * Gallery photos init seeding
     */
    public function seedGalleryPhotos()
    {
        foreach (get_mock('gallery_photos') as $key => $arBlock) {
            foreach ($arBlock as $arPhoto){
                $photo = new GalleryPhoto();
                $photo->active = true;
                $photo->block_id = $key+1;
                $photo->name = $arPhoto['name'];
                $photo->image = $arPhoto['image'];
                $photo->save();
            }
        }
    }
}
