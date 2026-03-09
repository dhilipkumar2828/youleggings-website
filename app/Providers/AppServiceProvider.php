<?php

namespace App\Providers;

use App\Models\Product;

use App\Models\Banner;

use App\Models\Category;

use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\Schema;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;

require_once app_path('helpers.php');

class AppServiceProvider extends ServiceProvider

{

    /**

     * Register any application services.

     *

     * @return void

     */

    public function register()

    {

        //

    }

    /**

     * Bootstrap any application services.

     *

     * @return void

     */

    public function boot()

    {

        Paginator::useBootstrap();

        View::composer('*', function($view)

        {

            @$date=array();

            @$menu_cate = Category::where('is_parent', 1)

            ->get();

            $i=1;

            if(!empty($menu_cate)){

            foreach(@$menu_cate as $value){

                $data[$i]['title']=$value['title'];

                $data[$i]['id']=$value['id'];

                //$data[$i]['data_id']="cat_id";

                //$data[$i]['param']="cat_id=".$value['id'];

                $sub_cate = Category::where('parent_id',$value['id'])->get();

                 if(count($sub_cate) > 0){

                     $k=0;

                     foreach($sub_cate as $svalue){

                        $data[$i][$k]['sub_title']=$svalue['title'];

                        $data[$i][$k]['sub_id']=$svalue['id'];

                       // $data[$i][$k]['data_id']="cat_id";

                        //$data[$i][$k]['param']="sub_id=".$svalue['id'];

                        $j=0;

                        //$data[$i][$k][$j]['pro_title']="Product";

                        /* $product = Product::where('child_cat_id',$svalue['id'])->get();

                        if(count($product) > 0){

                            foreach($product as $pvalue){

                                $data[$i][$k][$j]['pro_title']=$pvalue['title'];

                                $data[$i][$k][$j]['pro_id']=$pvalue['id'];

                                //$data[$i][$k][$j]['param']="pro_id=".$pvalue['id'];

                                $j++;

                            }

                        } */

                        $k++;

                     }

                 }

                 /* else{

                        $k=0;

                        $product = Product::where('category',$value['id'])->get();

                        if(count($product) > 0){

                            foreach($product as $pvalue){

                                $data[$i][$k]['sub_title']=$pvalue['title'];

                                $data[$i][$k]['sub_id']=$pvalue['id'];

                                //$data[$i][$k]['param']="pro_id=".$pvalue['id'];

                                $k++;

                            }

                        }

                 } */

                $i++;

            }

            $settings = \App\Models\Setting::first();
            $view->with(['menu_cate' => @$data, 'settings' => $settings]);
        }
        else {
            $settings = \App\Models\Setting::first();
            $view->with('settings', $settings);
        }

        });

    }

}


