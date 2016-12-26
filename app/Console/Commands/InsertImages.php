<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

//use DB;
use App\Product;
use App\ProductImage;
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
			$table = (new \App\ProductImage)->getTable();
			$count = 0;
		    while (false !== ($entry = readdir($handle))) {

		        if (!in_array($entry, ['.', '..', 'lg', 'sm'])) {

		            $arr = explode('_', $entry);
		            $code = $arr[0];
		            $productImage = ProductImage::where('filename', $entry)->first();
		            if (!$productImage || $force) {
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
						$img->resize(640, null, function ($constraint) {
						    $constraint->aspectRatio();
						});

						/*$watermark = Image::make($publicDir . '/images/logo.png');
						$watermark->opacity(50);
						$img->insert($watermark, 'center');*/

						$img->save($lgImgPath);

						unlink($dir . '/' . $entry);

						if (!$force) {
		            		$product = Product::find($code);
		            		$productImage = new ProductImage;
		            		$productImage->filename = $fixedEntry;
		            		$productImage->product()->associate($product);

			            	if ($productImage->save()) {
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
