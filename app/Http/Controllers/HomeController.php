<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Post;
use App\Models\Slider;
use App\Models\CategoryPost;
use App\Models\CategoryProduct;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $product;
    private $setting;
    private $slider;
    private $post;
    private $categoryPost;
    private $categoryProduct;

    private $productSearchLimit     = 6;
    private $postSearchLimit     = 6;

    private $productHotLimit     = 5;
    private $productNewLimit     = 5;
    private $productViewLimit    = 5;
    private $productPayLimit     = 5;
    private $sliderLimit         = 5;
    private $postsHotLimit       = 5;
    private $unit                = 'đ';
    public function __construct(Product $product, Setting $setting, Slider $slider, Post $post, CategoryPost $categoryPost, CategoryProduct $categoryProduct)
    {
        $this->middleware('auth');
        $this->product = $product;
        $this->setting = $setting;
        $this->slider = $slider;
        $this->post = $post;
        $this->categoryPost = $categoryPost;
        $this->categoryProduct = $categoryProduct;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('home');
    // }
    public function index(Request $request)
    {
        // dd(session()->has('cart'));
        //  $cart=[1=>'test 1'];
        //  $request->session()->put('cart',  $cart);
        //   dd($request->session()->get('cart'));

        //  dd($this->categoryPost->setAppends(['slug_full'])->find(15)->slug_full);

        //    dd(menuRecusive($this->categoryPost,13));
      //  dd($this->categoryPost->find(18)->breadcrumb);
        $dataSettings = $this->setting->all();
        // sản phẩm nổi bật
        $productsHot = $this->product->where([
            ['active', 1],
            ['hot', 1],
        ])->orderByDesc('created_at')->limit($this->productHotLimit)->get();
        // sản phẩm mới
        $productsNew = $this->product->where([
            ['active', 1],
        ])->orderByDesc('created_at')->limit($this->productNewLimit)->get();
        // sản phẩm xem nhiều
        $productsView = $this->product->where([
            ['active', 1],
        ])->orderByDesc('view')->limit($this->productViewLimit)->get();
        // sản phẩm mua nhiều
        $productsPay = $this->product->where([
            ['active', 1],
        ])->orderByDesc('pay')->limit($this->productPayLimit)->get();
        // lấy slider
        $sliders = $this->slider->where([
            ['active', 1],
        ])->orderByDesc('created_at')->limit($this->sliderLimit)->get();
        // bài viết nổi bật
        $postsHot = $this->post->where([
            ['active', 1],
            ['hot', 1],
        ])->orderByDesc('created_at')->limit($this->postsHotLimit)->get();

        $bannerHome = $this->setting->find(18);
        // danh mục sản phẩm
        $listIdCategory=$this->categoryProduct->getALlCategoryChildren(67);
        // dd($listIdCategory);
        $listCategory= $this->categoryProduct->whereIn(
            'id',$listIdCategory
        )->orderByDesc('created_at')->limit(12)->get();

        return view('frontend.pages.home', [
            'productHot' => $productsHot,
            'productNew' => $productsNew,
            'productView' => $productsView,
            'productPay' => $productsPay,
            'postsHot'  => $postsHot,
            'dataSettings' => $dataSettings,
            'listCategory'=>$listCategory,
            "slider" => $sliders,
            "unit" => $this->unit,
            "bannerHome" => $bannerHome,
        ]);
    }

    public function aboutUs(Request $request)
    {
        $data = $this->categoryPost->find(14);
        $breadcrumbs = [[
            'id' => $data->id,
            'name' => $data->name,
            'slug' => makeLink('about-us'),
        ]];
        return view("frontend.pages.about-us", [
            "data" => $data,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'about-us',
            'title' => $data ? $data->name : "",
            'category' => $data->category ?? null,
            'seo' => [
                'title' =>  $data->title_seo ?? "",
                'keywords' =>  $data->keywords_seo ?? "",
                'description' =>  $data->description_seo ?? "",
                'image' => $data->avatar_path ?? "",
                'abstract' =>  $data->description_seo ?? "",
            ]
        ]);
    }

    public function search(Request $request){
        $dataProduct = $this->product;
        $dataPost = $this->post;
        $where = [];
        $req=[];
        if ($request->input('keyword')) {
            $where[] = ['name', 'like', '%' . $request->input('keyword') . '%'];
            $req=[
                'keyword'=>$request->input('keyword'),
            ];
        }
        if($where){
            $dataProduct = $dataProduct->where($where)->orderBy("created_at", "DESC");
            $dataPost = $dataPost->where($where)->orderBy("created_at", "DESC");
        }
        $dataProduct = $dataProduct->paginate($this->productSearchLimit);
        $dataPost = $dataPost->paginate($this->postSearchLimit);
        $breadcrumbs = [[
            'id' => null,
            'name' => 'Tìm kiếm',
            'slug' => makeLink('search',null,null,$req),
        ]];
        return view("frontend.pages.search",[
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'search',
            'dataProduct' => $dataProduct,
            'dataPost' => $dataPost,
            'unit' => $this->unit,
            'seo' => [
                'title' =>  "Kết quả tìm kiếm",
                'keywords' =>  "Kết quả tìm kiếm",
                'description' =>  "Kết quả tìm kiếm",
                'image' =>  "Kết quả tìm kiếm",
                'abstract' =>   "Kết quả tìm kiếm",
            ]
        ]);
    }
}
