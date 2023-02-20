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
        view()->composer('*', function ($view) {
            $priceSearch = config('web_default.priceSearch');
            $statusTransaction = config('web_default.statusTransaction');
            $langConfig = config('languages.supported');
            $langDefault = config('languages.default');
            //  $contactContent=Setting::find(103);
            // $contactContentForm=Setting::find(104);
            //   $thongBaoTruTienXem=optional(Setting::find(108))->value;
            //  $thongBaoTruTienDangTin=optional(Setting::find(109))->value;
            $shareFrontend = [];
            $shareFrontend['noImage'] = config('web_default.frontend.noImage');
            $shareFrontend['userNoImage'] = config('web_default.frontend.userNoImage');
            $typePoint = config('point.typePoint');
            $view->with('shareFrontend', $shareFrontend)
                //  ->with('contactContent',$contactContent)
                //   ->with('contactContentForm',$contactContentForm)
                ->with('typePoint', $typePoint)
                ->with('langConfig', $langConfig)
                ->with('langDefault', $langDefault)
                ->with('typeUser', config('web_default.typeUser'))
                // ->with('thongBaoTruTienXem',$thongBaoTruTienXem)
                // ->with('thongBaoTruTienDangTin',$thongBaoTruTienDangTin)
                ->with('priceSearch', $priceSearch)
                ->with('statusTransaction', $statusTransaction);
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
                'frontend.pages.*',
                'frontend.pages.profile*',
                'auth.*',
                'admin.components.product-detail'
                // 'frontend.pages.profile-create-member',
                // 'frontend.pages.profile-edit-info',
                // 'frontend.pages.profile-history',
                // 'frontend.pages.profile-list-member',
                // 'frontend.pages.profile-list-rose',
            ],
            function ($view) {
                $setting = new Setting();
                $header = $this->getDataHeaderTrait($setting);
                $footer = $this->getDataFooterTrait($setting);
                $categoryPost = new CategoryPost();
                $categoryProduct = new CategoryProduct();
                $sidebar = $this->getDataSidebarTrait($categoryPost, $categoryProduct);
                $view->with('header', $header)->with('footer', $footer)->with('sidebar', $sidebar);
            }
        );
        // view()->composer(
        //     [
        //         'frontend.pages.product',
        //         'frontend.pages.product-detail',
        //         'frontend.pages.post',
        //         'frontend.pages.post-detail',
        //     ], function ($view) {
        //         $categoryPost= new CategoryPost();
        //         $categoryProduct= new CategoryProduct();
        //         $sidebar=$this->getDataSidebarTrait($categoryPost, $categoryProduct);
        //         $view->with('sidebar',$sidebar);
        //     }
        // );

    }
}
