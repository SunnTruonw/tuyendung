<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\Setting;
use App\Models\Post;
use App\Models\Slider;
use App\Models\CategoryPost;
use App\Models\CategoryProduct;
use App\Helper\AddressHelper;
use App\Models\City;
use App\Models\Commune;
use App\Models\District;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
    private $city;
    private $commune;
    private $district;
    private $review;
    private $user;


    private $productSearchLimit  = 6;
    private $postSearchLimit     = 6;

    private $productHotLimit     = 8;
    private $productNewLimit     = 8;
    private $productViewLimit    = 8;
    private $productPayLimit     = 8;
    private $sliderLimit         = 8;
    private $postsHotLimit       = 8;
    private $unit                = 'đ';
    private $priceSearch;
    private $categoryProductOrigin;
    private $donvi;
    private $huongnha;

    public function __construct(
        Product $product,
        Setting $setting,
        Slider $slider,
        Post $post,
        CategoryPost $categoryPost,
        CategoryProduct $categoryProduct,
        City $city,
        District $district,
        Commune $commune,
        Review $review,
        User $user
    ) {
        /*$this->middleware('auth');*/
        $this->product = $product;
        $this->setting = $setting;
        $this->slider = $slider;
        $this->post = $post;
        $this->city = $city;
        $this->commune = $commune;
        $this->district = $district;
        $this->categoryPost = $categoryPost;
        $this->categoryProduct = $categoryProduct;
        $this->review = $review;
        $this->user = $user;

        $this->priceSearch = config('web_default.frontend.priceSearch');
        $this->categoryProductOrigin = 1; // config('web_default.frontend.categoryProductOrigin');
        $this->donvi = config('web_default.donvi');
        $this->huongnha = config('web_default.huongnha');
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
        $contentHome = $this->setting->find(16);

        return view('frontend.pages.home', [
            'contentHome' => $contentHome
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



    public function storeAjax(Request $request)
    {
        //   dd($request->name);
        // dd($request->ajax());
        try {
            DB::beginTransaction();

            $dataContactCreate = [
                'name' => $request->input('name'),
                'phone' => $request->input('phone') ?? "",
                'email' => $request->input('email') ?? "",
                'sex' => $request->input('sex') ?? 1,
                'from' => $request->input('from') ?? "",
                'to' => $request->input('to') ?? "",
                'service' => $request->input('service') ?? "",
                'content' => $request->input('content') ?? null,
            ];
            //  dd($dataContactCreate);
            $contact = $this->contact->create($dataContactCreate);
            //  dd($contact);
            DB::commit();
            return response()->json([
                "code" => 200,
                "html" => 'Gửi thông tin thành công',
                "message" => "success"
            ], 200);
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return response()->json([
                "code" => 500,
                'html' => 'Gửi thông tin không thành công',
                "message" => "fail"
            ], 500);
        }
    }


    public function search(Request $request)
    {

        // $check = $request->check;
        // if (!$check) {
        //     return redirect()->route('home.index');
        // }
        $contentSearch = $this->setting->find(165);
        $data = $this->product->with('attributes', 'city', 'attributeChilds');
        $attributes = Attribute::with('childs', 'translations', 'options')->where('parent_id', 0)->orderBy('order')->get();
        if ($q = $request->input('keyword')) {
            $data = $data->where(function ($query) use ($q) {
                return $query->where('masp', $q)
                    ->orWhere('phone_chunha', $q);
            });
        }

        // dd($data->get());

        if ($data->count() <= 0) {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);

            return false;
        } else {
            $data =  $data->orderBy('id', 'asc')->limit(10)->get();
            $dataFirst =  $data->first();

            return view("frontend.pages.search", [
                'data' => $data,
                'attributes' => $attributes,
                'dataFirst' => $dataFirst,
                'contentSearch' => $contentSearch
            ]);
        }
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
