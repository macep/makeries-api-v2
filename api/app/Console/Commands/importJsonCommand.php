<?php
/**
 *
 * PHP version >= 7.0
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */

namespace App\Console\Commands;


use App\Maker;
use App\ImageThumb;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;



/**
 * Class importOldJsonCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class ImportJsonCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "import:json";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Import old .net from json file";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sourcePath = __DIR__ . '/../../../storage/import/';
        
        try {
            $mapFields = [
                'id'=>'old_id',
                'name'=>'name',
                'address'=>'address1',
                'email'=>'email',
                'telephone'=>'telephone',
                'website'=>'website',
                'twitter'=>'social1',
                'instagram'=>'social2',
                'facebook'=>'social3',
                'mapURL'=>'map_url',
                'adminEmail'=>'admin_email',
                'briefDescription'=>'brief_description',
                'longDescription'=>'what_we_do',
                'featured'=>'featured',
            ];
/*
imageUrl
shopWebsite
adminContact
openingHours
notes
created
lastModifed
experience
recommendations
createdBy
lastModifedBy
tags

products
regions
businessTypes
serviceTypes
images

groups
projects
*/
print_r($mapFields);
            $file = 'jgm.net-source.json';
            $content = file_get_contents($sourcePath . $file);
            $data = json_decode($content);

            foreach ($data as $old) {
$this->info("Import id:".$old->id);
                $maker = \App\Maker::where('old_id', $old->id)
                   ->first();
                if (!$maker) {
                    $maker = new \App\Maker();
                }
                foreach ($mapFields as $key=>$mapTo) {
                    if (isset($old->$key)) {
                        $maker->$mapTo = $old->$key;
                    }
                }
                $maker->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $maker->name), '-'));
                $maker->save();

                DB::table('maker_region')->where('maker_id', $maker->id)->delete();
                DB::table('maker_product')->where('maker_id', $maker->id)->delete();
                DB::table('maker_material')->where('maker_id', $maker->id)->delete();
                DB::table('maker_service')->where('maker_id', $maker->id)->delete();
                
                $this->setRegions($maker, $old);
                $this->setProducts($maker, $old);
                $this->setMaterials($maker, $old);
                $this->setServices($maker, $old);
                $this->setImages($maker, $old);
            }
            
#var_dump($maker);
        } catch (Exception $e) {
            print $e->getMessage();
        }
        $this->info("Json import done");
    }

    private function setRegions($maker, $old) {
        if (isset($old->region)) {
            if (is_object($old->region)) {
                $region = \App\Region::where('name', $old->region->name)
                   ->first();
                if (!$region) {
                    $region = new \App\Region;
                    $region->name = $old->region->name;
                    $region->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $region->name), '-'));
                    $region->save();
                }
                $maker->regions()->attach($region->id, ['created_by' => -1]);
            } else {
print "\nWHAT YOU DO WITH THIS REGION";
var_dump($old->region);exit;
            }
        }
    }

    private function setProducts($maker, $old) {
        if (isset($old->products)) {
            foreach ($old->products as $oldProduct) {
                $product = \App\Product::where('name', $oldProduct->name)
                   ->first();
                if (!$product) {
                    $product = new \App\Product;
                    $product->name = $oldProduct->name;
                    $product->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $product->name), '-'));
                    $product->save();
                }
                $maker->products()->attach($product->id, ['created_by' => -1]);
            }
        }
    }

    //In prrevious version was named : business type
    private function setMaterials($maker, $old) {
        if (isset($old->businessTypes)) {
            foreach ($old->businessTypes as $oldBusinessTypes) {
                $material = \App\Material::where('name', $oldBusinessTypes->name)
                   ->first();
                if (!$material) {
                    $material = new \App\Material;
                    $material->name = $oldBusinessTypes->name;
                    $material->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $material->name), '-'));
                    $material->save();
                }
                $maker->materials()->attach($material->id, ['created_by' => -1]);
            }
        }
    }

    //In prrevious version was named : service type
    private function setServices($maker, $old) {
        if (isset($old->serviceTypes)) {
            foreach ($old->serviceTypes as $oldServiceTypes) {
                $service = \App\Service::where('name', $oldServiceTypes->name)
                   ->first();
                if (!$service) {
                    $service = new \App\Service;
                    $service->name = $oldServiceTypes->name;
                    $service->slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $service->name), '-'));
                    $service->save();
                }
                $maker->services()->attach($service->id, ['created_by' => -1]);
            }
        }
    }

    private function setImages($maker, $old) {
        if (isset($old->images)) {
            //Will delete Images for maker and alsofor projects
            $images = \App\Image::where('maker_id', $maker->id)
                   ->get();
            foreach ($images as $image) {
                $image->removeImageFile();
                $image->delete();
            }

            foreach ($old->images as $oldImages) {
                DB::beginTransaction();
                $image = new \App\Image;
                $image->maker_id = $maker->id;
                $image->created_by = -1;
                $image->name = $oldImages->imageName;
                $image->save();

                file_put_contents($image->getImageFilePath(), file_get_contents($oldImages->url));

                //Create also the thumb for the image
                $imageThumb = new ImageThumb();
                $imageThumb->create($image->getImageFilePath());

                DB::commit();
            }
        }
    }

}
