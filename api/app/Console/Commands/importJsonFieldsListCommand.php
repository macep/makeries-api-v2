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

use Exception;
use Illuminate\Console\Command;



/**
 * Class importOldJsonCommand
 *
 * @category Console_Command
 * @package  App\Console\Commands
 */
class ImportJsonFieldsListCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = "import:json_fields_list";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "List all fields for Import old .net json file";


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sourcePath = __DIR__ . '/../../../storage/import/';
        
        $fields = [];
        try {
            $file = 'jgm.net-source.json';
            $content = file_get_contents($sourcePath . $file);
            $data = json_decode($content);
#print_r($data[0]);

            $old = $data[0];
            foreach ($data as $pos=>$old) {
print "\n".$pos;
                foreach ($old as $key=>$value) {
                    if (!isset($fields[$key])) {
                        $fields[$key] = true;
                    }
                    if (in_array($key, ['region','products','groups','projects','images','businessTypes','serviceTypes'])) {
                        if (!is_array($fields[$key])) {
                            $fields[$key] = [];
                        }
                        if (is_object($value))
                            foreach ($value as $aKey=>$aValue) {
                                if (!isset($fields[$key][$aKey])) {
                                    $fields[$key][$aKey] = true;
                                }
                            }
                        if (is_array($value))
                            foreach ($value as $aKey=>$aValue) {
                                $theKey = implode(',', array_keys((array)$aValue));
                                if (!isset($fields[$key][$theKey])) {
                                    $fields[$key][$theKey] = true;
                                }
                            }

                    }
                }
            }
            foreach ($fields as $key=>$value) {
                print "\n".$key;
                if (is_array($value)) {
                    foreach ($value as $key=>$value2) {
                        print "\n\t".$key;
                    }
                }
            }
print_r($fields);
#var_dump($maker);
        } catch (Exception $e) {
            print $e->getMessage();
        }
        /*
        try {
            $posts = Post::getPosts();
           
            if (!$posts) {
            $this->info("No posts exist");
                return;
            }
            foreach ($posts as $post) {
                $post->delete();
            }
            $this->info("All posts have been deleted");
        } catch (Exception $e) {
            $this->error("An error occurred");
        }
        */
        echo "\nYupiii\n\n";
    }
}
