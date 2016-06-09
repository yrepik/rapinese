<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use DB;
use App;
use Intervention\Image\ImageManagerStatic as Image;

class InsertImages extends Command {

	protected $signature = 'ii {--f : force}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		ini_set('memory_limit', '-1');
		$force = $this->option('f');
		$publicDir = env('PUBLIC_DIR');
		$dir = $publicDir . '/images/products';
		if ($handle = opendir($dir)) {
			$count = 0;
		    while (false !== ($entry = readdir($handle))) {

		        if (!in_array($entry, ['.', '..', 'lg', 'sm', 'City-No-Camera-icon.png'])) {

		            $arr = explode('_', $entry);
		            $code = $arr[0];
		            $record = DB::table('product_image')->where('filename', $entry)->first();
		            if (!$record || $force) {
		            	$fixedEntry = str_replace('JPG', 'jpg', $entry);

		            	$smImgPath = $dir . '/sm/' . $fixedEntry;
		            	$lgImgPath = $dir . '/lg/' . $fixedEntry;

						$img = Image::make($dir . '/' . $entry);
						$this->info($img);
						$img->resize(158, null, function($constraint) {
						    $constraint->aspectRatio();
						});
						$img->save($smImgPath);		            	

						$img = Image::make($dir . '/' . $entry);
						$img->resize(640, null, function($constraint) {
						    $constraint->aspectRatio();
						});
						
						/*$watermark = Image::make($publicDir . '/images/logo.png');
						$watermark->opacity(50);
						$img->insert($watermark, 'center');*/

						$img->save($lgImgPath);

						unlink($dir . '/' . $entry);

						if (!$force) {
			            	$insert = DB::table('product_image')->insert([
			            		'product_code' => $code, 
			            		'filename' => $fixedEntry
		            		]);
			            	if ($insert) {
			            		$this->info($entry . ' INSERTED');
			            		$count++;
		            		} else {
		            			unlink($smImgPath);
		            			unlink($lgImgPath);
		            		}
	            		}
		            }  
		        }
		    }
		    closedir($handle);
		    if ($count == 0) {
		    	$this->info('No images pending.');
		    }
		}
    }

}
