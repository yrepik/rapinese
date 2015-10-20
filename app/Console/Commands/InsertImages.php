<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use DB;
use App;
use Intervention\Image\ImageManagerStatic as Image;

class InsertImages extends Command {

	protected $signature = 'ii';

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
		$publicDir = App::environment('local') ? 'public' : 'public_html';
		$dir = $publicDir . '/images/products';
		if ($handle = opendir($dir)) {
			$count = 0;
		    while (false !== ($entry = readdir($handle))) {
		        if ($entry != "." && $entry != ".." && $entry != "noImage.jpg") {
		            $arr = explode('_', $entry);
		            $code = $arr[0];
		            $record = DB::table('product_image')->where('filename', $entry)->first();
		            if (!$record) {

						$img = Image::make($dir . '/' . $entry);
						$img->resize(1280, null, function($constraint) {
						    $constraint->aspectRatio();
						});
						/*$watermark = Image::make($publicDir . '/images/logo.png');
						$watermark->opacity(50);
						$img->insert($watermark, 'center');*/
						$img->save($dir . '/' . str_replace('JPG', 'jpg', $entry));

		            	DB::table('product_image')->insert(['product_code' => $code, 'filename' => $entry]);
		            	$this->info($entry . ' INSERTED');
		            	$count++;
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
