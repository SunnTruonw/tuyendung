<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use App\Traits\GetDataTrait;
use App\Models\CategoryProduct;
use App\Models\CategoryPost;
class ViewServiceProvider extends ServiceProvider
{
    use GetDataTrait;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view)
        {
            $shareFrontend=[];
            $shareFrontend['noImage']=config('web_default.frontend.noImage');
            $shareFrontend['userNoImage']=config('web_default.frontend.userNoImage');
            $view->with('shareFrontend', $shareFrontend);
        });
        view()->composer(
            [
                'frontend.pages.home',
                'frontend.pages.product',
                'frontend.pages.product-detail',
                'frontend.pages.post',
                'frontend.pages.post-detail',
                'frontend.pages.cart',
                'frontend.pages.order-sucess',
                'frontend.pages.contact',
                'frontend.pages.about-us',
                'frontend.pages.search',

            ], function ($view) {
                $setting= new Setting();
                $header=$this->getDataHeaderTrait($setting);
                $footer=$this->getDataFooterTrait($setting);
                $view->with('header',$header)->with('footer',$footer);
            }
        );
        view()->composer(
            [
                'frontend.pages.product',
                'frontend.pages.product-detail',
                'frontend.pages.post',
                'frontend.pages.post-detail',
            ], function ($view) {
                $categoryPost= new CategoryPost();
                $categoryProduct= new CategoryProduct();
                $sidebar=$this->getDataSidebarTrait($categoryPost, $categoryProduct);
                $view->with('sidebar',$sidebar);
            }
        );

    }
}
