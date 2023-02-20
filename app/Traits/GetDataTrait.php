<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;
use App\Models\CategoryPost;
use App\Models\CategoryProduct;
use App\Helper\CartHelper;
use App\Models\Slider;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use App\Helper\AddressHelper;
use App\Models\City;
use App\Models\District;
use App\Models\Commune;
use Illuminate\Http\Request;

/**
 *
 */
trait GetDataTrait
{
    /*
     store image upload and return null || array
     @param
     $request type Request, data input
     $fieldName type string, name of field input file
     $folderName type string; name of folder store
     return array
     [
         "file_name","file_path"
     ]
    */
    public function getDataHeaderTrait($setting)
    {
        // $cart = new CartHelper();
        // $totalQuantity =  $cart->getTotalQuantity();


        $header = [];
        //   $header['hotline'] = $setting->find(2);
        //  $header['email'] = $setting->find(3);
        //   $header['address'] = $setting->find(6);
        $header['logo'] = $setting->find(13);
        //$header['bannerHome'] = $setting->find(18);
        // $header['logo_mobile'] = $setting->find(82);
        //   $header['socialParent'] = $setting->find(11);
        //     $header['menuSp'] = $setting->find(127);
        //   $header['totalQuantity'] = $totalQuantity;
        $header['seoHome'] = $setting->find(158);

        $menu = [];
        $menuDeskTop = [];
        $menuPost = [];
        $menuPostGioiThieu = [];
        $menuPostKinhNghiem = [];

        // $categoryProduct = new CategoryProduct();

        // $listCategoryProduct = $categoryProduct->select('id','name','slug','parent_id')->where([
        //     'active' => 1
        // ])->whereIn(
        //     'id',
        //     [1]
        // )->get();

        // foreach ($listCategoryProduct as $category) {
        //     //array_push($menuDeskTop, menuRecusive($categoryProduct, $id));
        //     array_push($menuDeskTop, $categoryProduct->getALlModelCategoryChildrenAndSelf($category));
        // }

        // dd($menuDeskTop);

        // $categoryPost = new CategoryPost();
        // $listCategoryPost = $categoryPost->select('id','name','slug','parent_id')->whereIn(
        //     'id',
        //     [21]
        // )->get();
        // foreach ($listCategoryPost as $category) {
        //     array_push($menuPost, $categoryPost->getALlModelCategoryChildrenAndSelf($category));
        // }

        // $listCategoryPostGioiThieu = $categoryPost->select('id','name','slug','parent_id')->whereIn(
        //     'id',
        //     [37]
        // )->get();
        // array_push($menuPostGioiThieu,...$listCategoryPostGioiThieu);

        // $listCategoryPostKinhNghiem = $categoryPost->select('id','name','slug','parent_id')->whereIn(
        //     'id',
        //     [38]
        // )->get();

        // array_push($menuPostKinhNghiem,...$listCategoryPostKinhNghiem);

        //  dd($menuPost);
        // $header['menu'] =  [
        //     [
        //         'name' => 'Trang chủ',
        //         'slug_full' => makeLink('home'),
        //         'childs' => []
        //     ],
        //     ...$menuPostGioiThieu,
        //     [
        //         'name' => 'Top bán chạy',
        //         'slug_full' => route('product.topBanChay'),
        //         'childs' => []
        //     ],
        //     ...$menuPostKinhNghiem,
        //     [
        //         'name' => 'Liên hệ',
        //         'slug_full' => makeLink('contact'),
        //     ],
        // ];


        // $header['menuDeskTop'] =  $menuDeskTop[0] ?? [];
        // $header['menuPost'] =  [
        //     [
        //         'name' => 'Trang chủ',
        //         'slug_full' => makeLink('home'),
        //         'childs' => []
        //     ],
        //     [
        //         'name' => 'Giới thiệu',
        //         'slug_full' => makeLink('about-us'),
        //         'childs' => []
        //     ],
        //     ...$menuPost[0]['childs'] ?? [],
        //     [
        //         'name' => 'Liên hệ',
        //         'slug_full' => makeLink('contact'),
        //     ],
        // ];

        // $header['menuMobile'] =  [
        //     [
        //         'name' => 'Trang chủ',
        //         'slug_full' => makeLink('home'),
        //         'childs' => []
        //     ],
        //     ...$menuPostGioiThieu,
        //     ...$menuPost,
        //     [
        //         'name' => 'Top bán chạy',
        //         'slug_full' => route('product.topBanChay'),
        //         'childs' => []
        //     ],
        //     ...$menuDeskTop,
        //     [
        //         'name' => 'Liên hệ',
        //         'slug_full' => makeLink('contact'),
        //     ],
        // ];
        // // lấy slider
        // $slider = new Slider();
        // $sliders = $slider->where([
        //     ['active', 1],
        // ])->orderby('order')->latest()->limit(5)->get();
        // $header['sliders'] = $sliders;


        // $productM = new Product();
        // $header['countProduct'] = $productM->where('active', 1)->count();



        // $address = new AddressHelper();
        // $city=new City();
        // $dataCity = $city->orderby('name')->find([1,79]);

        // $cities = $address->cities($dataCity);
        // $header['cities']=$cities;

        // $categoryProduct = new CategoryProduct();
        // $htmlselect = $categoryProduct->getHtmlOptionOriginById(config('web_default.frontend.categoryProductOrigin'));
        // $header['htmlselect']=$htmlselect;

        // $header['priceSearch']=config('web_default.frontend.priceSearch');

        // $header['typeGD']=$categoryProduct->where([
        //     'active'=>1,
        //     'parent_id'=>config('web_default.frontend.categoryProductOrigin'),
        // ])->get();
        return  $header;
    }



    public function getDataFooterTrait($setting)
    {
        $footer = [];
        // $footer['dataAddress'] = $setting->find(20);
        // $footer['linkFooter'] = $setting->find([37, 123, 125]);
        // //  $footer['registerSale'] = $setting->find(45);
        // $footer['logo'] = $setting->find(120);
        // $footer['coppy_right'] = $setting->find(46);
        // $footer['socialParent'] = $setting->find(47);
        // $footer['doitac'] = $setting->find(118);
        // $footer['magg'] = $setting->find(121);


        return  $footer;
    }
    public function getDataSidebarTrait($categoryPost, $categoryProduct)
    {
        $sidebar = [];

        // $sidebar['categoryPost'] = $categoryPost->whereIn(
        //     'parent_id',
        //     [21]
        // )->whereNotIn(
        //     'id',
        //     [14]
        // )->get();
        // $userM = new User();

        // $sidebar['userHot2']  = $userM->addSelect(['review_sum_id' => Review::select('name,id')
        // ->where('active', 1)
        // ->whereColumn('reviews.user_id','users.id')
        // ->limit(1)
        // ])->get();
        // dd($sidebar['userHot2'] );
        // $sidebar['userHot']  = $userM->withCount('reviews')->orderByDesc('reviews_count')->limit(5)->get();
        // dd($sidebar['userHot']->reviews_count);



        // Quiz::with(['quiz_results' => function ($query) {
        //     $query->count();
        // }])->get()->take(10)->sortBy('quiz_results')->all();
        // lấy review top tuần
        // $reviewM = new Review();
        // $sidebar['listViewWeek']  = $reviewM->with('comments')->where('active', 1)
        //     ->where('created_at', '>=', \Carbon\Carbon::now()->subDays(7)->format('Y-m-d'))
        //     ->orderByDesc('view')->latest()->limit(3)->get();
        // $sidebar['listViewMonth'] = $reviewM->with('comments')->where('active', 1)
        //     ->where('created_at', '>=', \Carbon\Carbon::now()->subDays(30)->format('Y-m-d'))
        //     ->orderByDesc('view')->latest()->limit(3)->get();


        return  $sidebar;
    }
}
