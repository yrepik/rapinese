<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use DB;
use App;
use Intervention\Image\ImageManagerStatic as Image;

class FlipImages extends Command {

	protected $signature = 'fi {codesFrom} {codesTo}';

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

		$codesFrom = explode(',', $this->argument('codesFrom'));
		$codesTo = explode(',', $this->argument('codesTo'));

		foreach ($codesFrom as $key => $codeFrom) {
			$img = Image::make($dir . '/' . $entry);
			$img->resize(158, null, function($constraint) {
			    $constraint->aspectRatio();
			});
		}

						$img = Image::make($dir . '/' . $entry);
						$img->resize(158, null, function($constraint) {
						    $constraint->aspectRatio();
						});
						$img->save($dir . '/sm/' . $fixedEntry);		            	

						$img = Image::make($dir . '/' . $entry);
						$img->resize(640, null, function($constraint) {
						    $constraint->aspectRatio();
						});
						/*$watermark = Image::make($publicDir . '/images/logo.png');
						$watermark->opacity(50);
						$img->insert($watermark, 'center');*/
						$img->save($dir . '/lg/' . $fixedEntry);

						unlink($entry);

		            	DB::table('product_image')->insert(['product_code' => $code, 'filename' => $fixedEntry]);
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
