<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use App\Brand;
use App\ProductCategory;
use App\Product;
use App;

class Sitemap extends Command {

    protected $signature = 'sitemap';

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
        $links = [];
        $brands = Brand::pluck('id', 'alias');
        $categories = ProductCategory::where('status', 1)->pluck('id', 'alias_es');

        $brands->each(function ($brandId, $brandAlias) use ($categories, &$links) {
            $categories->each(function ($categoryId, $categoryAlias) use ($brandId, $brandAlias, &$links) {
                $count = Product::forBrandAndCategory($brandId, $categoryId)->count();
                if ($count > 0) {
                    $link = route(
                        'product-search-results',
                        ['brand_alias' => $brandAlias, 'category_alias' => $categoryAlias]
                    );
                    $links[] = $link;
                    $this->info($link);
                }
            });
        });
        file_put_contents(env('PUBLIC_DIR') . '/sitemap.txt', implode(PHP_EOL, $links));
        $this->info(count($links) . ' links created.');
    }

}
