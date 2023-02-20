<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\CategoryPost;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use App\Models\Point;
use App\Models\Supplier;
use App\Models\Option;
use App\Models\Post;
class ProductController extends Controller
{
    //

    private $product;
    private $header;
    private $unit = 'đ';
    private $categoryProduct;
    private $categoryPost;
    private $limitProduct = 20;
    private $limitProductRelate = 20;
    private $idCategoryProductRoot = 1;
    private $donvi;
    private $chiDanTruTienKhiXemTin;
    private $chiDanTruTienKhiDangTin;
    private $supplier;
    private $option;
    private $priceSearch;
    private $post;
    private $breadcrumbFirst = [
        // 'name'=>'Sản phẩm',
        //  'slug'=>'san-pham',
    ];
    public function __construct(
        Product $product,
        CategoryProduct $categoryProduct,
        CategoryPost $categoryPost,
        Setting $setting,
        Supplier $supplier,
        Option $option,
        Post $post
    ) {
        $this->product = $product;
        $this->supplier = $supplier;
        $this->option = $option;
        $this->categoryProduct = $categoryProduct;
        $this->categoryPost = $categoryPost;
        $this->setting = $setting;
        $this->post = $post;
        $this->donvi = config('web_default.donvi');
        $this->chiDanNapTienKhiXemTin = optional($this->setting->find(110))->description;
        $this->chiDanNapTienKhiDangTin = optional($this->setting->find(111))->description;
        $this->priceSearch = config('web_default.priceSearch');
    }
    // danh sách toàn bộ product
    public function index(Request $request)
    {
        $breadcrumbs = [];
        $data = [];
        // get category
        $category = $this->categoryProduct->where([
            ['id', $this->idCategoryProductRoot],
        ])->first();

        if ($category) {
            if ($category->count()) {
                $categoryId = $category->id;
                $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);
                $data =  $this->product->whereIn('category_id', $listIdChildren)->whereNotIn('type', [2])->latest()->paginate($this->limitProduct);
                $breadcrumbs[] = $this->categoryProduct->select('id', 'name', 'slug')->find($this->idCategoryProductRoot)->toArray();
            }
        }

        //  dd($category);
        return view('frontend.pages.product', [
            'data' => $data,
            'unit' => $this->unit,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'product_all',

            'category' => $category,

            'seo' => [
                'title' =>  $category->title_seo ?? "",
                'keywords' =>  $category->keywords_seo ?? "",
                'description' =>  $category->description_seo ?? "",
                'image' => $category->avatar_path ?? "",
                'abstract' =>  $category->description_seo ?? "",
            ]
        ]);
    }
    public function detail($slug, $id, Request $request)
    {
        // $data= $this->categoryProduct->setAppends(['breadcrumb'])->where('parent_id',0)->orderBy("created_at", "desc")->paginate(15);

        $breadcrumbs = [];
        $data = [];
        $data = $this->product->where([
            ['id', $id],
            ["slug", $slug],
        ])->first();

        if(!$data){
           return;
        }
        $listOption=$this->option->where('product_id',$id)->latest()->get();
        $categoryId = $data->category_id;
        $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);

        $dataRelate =  $this->product
            ->whereIn('category_id', $listIdChildren)->where([
                ["id", "<>", $data->id],
            ])->latest()->limit(8)->get();




        //  dd($dataRelate);
        $listIdParent = $this->categoryProduct->getALlCategoryParentAndSelf($categoryId);

        foreach ($listIdParent as $parent) {
            $breadcrumbs[] = $this->categoryProduct->select('id', 'name', 'slug')->find($parent)->toArray();
        }



        $dataProductHot=$this->product->where([
            ['active',1],
            ['hot',1]
        ])->latest()->limit(5)->get();
        $dataNewHot=$this->post->where([
            ['active',1],
            ['hot',1]
        ])->latest()->limit(5)->get();

        $dataComment=$data->comments()->where('active',1)->with('user')->latest()->paginate(20);
        $countComment=$data->comments()->where('active',1)->count();

        return view('frontend.pages.product-detail', [

            'data' => $data,
            'dataComment'=>$dataComment,
            'countComment'=>$countComment,
            'listOption' => $listOption,
            'dataProductHot' => $dataProductHot,
            'dataNewHot' => $dataNewHot,
            'unit' => $this->unit,
            'donvi' => $this->donvi,
            "dataRelate" => $dataRelate,
            'breadcrumbs' => $breadcrumbs,
            'typeBreadcrumb' => 'category_products',
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

    public function detailFull($slug, $id, Request $request)
    {
        $breadcrumbs = [];
        $data = [];
        $data = $product = $this->product
            ->where(function ($query) {
                $query->where('time_expires', '>=', \Carbon\Carbon::now()->format('Y-m-d h:i:s'))
                    ->orWhereNull('time_expires');
            })
            ->where([
                ['id', $id],
                ["slug", $slug],
            ])->first();



        $checknap = false;
        if (!Auth::check()) {
            session()->put('urlBack', url()->current());
            return redirect()->route('login');
        }
        $user = auth()->user();
        $userId = $user->id;
        $pointM = new Point();
        $sumPointCurrent = $pointM->sumPointCurrent($userId);
        if ($user->type == 4 && optional($data->user)->id == $user->id) {
        } else {
            $pT  = $user->points()->where([
                'userorigin_id' => $id
            ])->get()->count();
            if ($pT > 0) {
            } else {
                if ($sumPointCurrent < config('point.typePoint')[3]['point']) {
                    $index = 0;
                    if (session()->has('dataProductWaitView')) {
                        $dataProductWait = session()->get('dataProductWaitView');
                        $index = time();
                        $dataProductWaitView[$index] = $product;

                        session()->put('dataProductWaitView', $dataProductWaitView);
                        // array_push($dataProductWait,$request);
                    } else {
                        $index = time();
                        $dataProductWaitView = [];
                        $dataProductWaitView[$index] =  $product;
                        //  dd($dataProductWait);
                        session()->put('dataProductWaitView', $dataProductWaitView);
                        //  dd(session()->get('dataProductWait'));
                    }
                    session()->put('urlProductPay', route('product.detail', ['slug' => $slug, 'id' => $id]));
                    return redirect()->route('profile.createPaymentCartView', [
                        'money' => config('point.typePoint')[3]['point'],
                        'product_view' => $index
                    ])
                        ->with('mes', $this->chiDanNapTienKhiXemTin);
                    //   ->with('mes', 'Tài khoản của bạn phải lớn hơn <strong>' . number_format(config('point.typePoint')[3]['point']) . ' VNĐ </strong>  để xem tin. Vui lòng nạp tiền vào tài khoản để tiếp tục');
                } else {
                    $user = auth()->user();
                    $point = $user->points()->create([
                        'type'  => config('point.typePoint')[3]['type'],
                        'point' => -config('point.typePoint')[3]['point'],
                        'userorigin_id' => $product->id,
                        'active' => 1,
                    ]);
                }
            }
        }
    }
    public function checkLogin()
    {
        $url =  url()->previous();

        $urlNoQuery = explode('?', $url)[0] . '?step=1';
        if (!Auth::check()) {
            session()->put('urlBack', $urlNoQuery);
            return redirect()->route('login');
        } else {
            return redirect($urlNoQuery);
        }
    }
    // danh sách product theo category
    public function productByCategory($slug, Request $request)
    {
        // dd(route('product.index',['category'=>$request->category]));
        $breadcrumbs = [];
        // get category
        $category = $this->categoryProduct->where([
            ['slug', $slug],
        ])->first();
        if ($category) {
            if ($category->count()) {

                $categoryId = $category->id;
                if ($request->ajax()) {
                    return $this->filter($category, $request);
                }
                $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);

                $data =  $this->product
                    ->whereIn('category_id', $listIdChildren)->latest()->paginate($this->limitProduct);
                $listIdParent = $this->categoryProduct->getALlCategoryParentAndSelf($categoryId);
                foreach ($listIdParent as $parent) {
                    $breadcrumbs[] = $this->categoryProduct->select('id', 'name', 'slug')->find($parent)->toArray();
                }
                $supplier = $this->supplier->where('active', 1)->get();
                return view('frontend.pages.product', [
                    'donvi' => $this->donvi,
                    'data' => $data,
                    'unit' => $this->unit,
                    'breadcrumbs' => $breadcrumbs,
                    'typeBreadcrumb' => 'category_products',
                    'category' => $category,
                    'supplier' => $supplier,
                    'seo' => [
                        'title' =>  $category->title_seo ?? "",
                        'keywords' =>  $category->keywords_seo ?? "",
                        'description' =>  $category->description_seo ?? "",
                        'image' => $category->avatar_path ?? "",
                        'abstract' =>  $category->description_seo ?? "",
                    ]
                ]);
            }
        }

        //   if($this->breadcrumbFirst){
        //       array_unshift($breadcrumbs,$this->breadcrumbFirst);
        //   }


    }

    public function topBanChay(Request $request)
    {
        // dd(route('product.index',['category'=>$request->category]));
        $breadcrumbs = [];
        // get category
        $category = $this->categoryProduct->where([
            ['id', $this->idCategoryProductRoot],
        ])->first();
        if ($category) {
            if ($category->count()) {

                $categoryId = $category->id;
                if ($request->ajax()) {
                    return $this->filter($category, $request,[['ban_chay',1]]);
                }
                $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);

                $data =  $this->product
                    ->whereIn('category_id', $listIdChildren)->where([['ban_chay',1]])->latest()->paginate($this->limitProduct);
                $listIdParent = $this->categoryProduct->getALlCategoryParentAndSelf($categoryId);
                // $breadcrumbs[]=[
                //     ''
                // ];
                foreach ($listIdParent as $parent) {
                    $breadcrumbs[] = $this->categoryProduct->select('id', 'name', 'slug')->find($parent)->toArray();
                }
                $supplier = $this->supplier->where('active', 1)->get();

                return view('frontend.pages.product', [
                    'donvi' => $this->donvi,
                    'data' => $data,
                    'unit' => $this->unit,
                    'breadcrumbs' => $breadcrumbs,
                    'typeBreadcrumb' => 'category_products',
                    'category' => $category,
                    'supplier' => $supplier,
                    'seo' => [
                        'title' =>  $category->title_seo ?? "",
                        'keywords' =>  $category->keywords_seo ?? "",
                        'description' =>  $category->description_seo ?? "",
                        'image' => $category->avatar_path ?? "",
                        'abstract' =>  $category->description_seo ?? "",
                    ]
                ]);
            }
        }

        //   if($this->breadcrumbFirst){
        //       array_unshift($breadcrumbs,$this->breadcrumbFirst);
        //   }


    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    public function filter($category, $request,$whereStart=null)
    {
        $categoryId = $category->id;
        $listIdChildren = $this->categoryProduct->getALlCategoryChildrenAndSelf($categoryId);
        if ($whereStart) {
            $data =  $this->product->where($whereStart);
        }else{
            $data =  $this->product;
        }

        // dd($request->input('supplier_id'));
        if ($request->has('supplier_id') && $request->input('supplier_id')) {
            // dd($request->all());
            $productId= $this->product->where('active',1)->whereIn('category_id', $listIdChildren)->pluck('id');
            $data = $this->option->with('product')->whereIn('product_id',$productId)->where('supplier_id', $request->input('supplier_id'));

            if ($request->has('price') && $request->input('price')) {
                $key = $request->input('price');
                //  dd($this->priceSearch[$key]);
                $start = $this->priceSearch[$key]['start'];
                $end = $this->priceSearch[$key]['end'];
                //   dd($start);

                if ($start == 0 && $end) {
                    $data = $data->where('price', '<=', $end);
                } elseif ($start && $end) {

                    $data = $data->whereBetween('price', [$start, $end]);
                } elseif ($start && $end == null) {
                    // dd($end);
                    $data = $data->where('price', '>=', $start);
                }
                //  dd($end);
                // dd($data->get());
            }

            if ($request->has('orderby') && $request->input('orderby')) {
                if ($request->input('orderby') == 1) {
                    $data =  $data->orderby('price');
                } elseif ($request->input('orderby') == 2) {
                    $data =  $data->orderByDesc('price');
                } elseif ($request->input('orderby') == 3) {
                    $data =  $data->orderby('sale');
                } elseif ($request->input('orderby') == 4) {
                    $data =  $data->orderByDesc('price');
                } else {
                    $data =  $data->orderByDesc('price');
                }
            } else {
                $data =  $data->orderby('price');
            }

            $countProduct = $data->count();

            $data = $data->latest()->paginate($this->limitProduct);
            $supplier=$this->supplier->find($request->input('supplier_id'));
            // dd($data);
            return response()->json([
                "code" => 200,
                "html" => view('frontend.components.load-product-search-option', [
                    'data' => $data,
                    'supplier'=>$supplier,
                    'unit' => $this->unit,
                    'countProduct' => $countProduct
                ])->render(),
                "message" => "success"
            ], 200);
        }

        if ($request->has('price') && $request->input('price')) {
            $key = $request->input('price');
            //  dd($this->priceSearch[$key]);
            $start = $this->priceSearch[$key]['start'];
            $end = $this->priceSearch[$key]['end'];
            //   dd($start);

            if ($start == 0 && $end) {
                $data = $data->where('price', '<=', $end);
            } elseif ($start && $end) {

                $data = $data->whereBetween('price', [$start, $end]);
            } elseif ($start && $end == null) {
                // dd($end);
                $data = $data->where('price', '>=', $start);
            }
            //  dd($end);
            // dd($data->get());
        }
        // dd($request->input('attribute_id'));
        // if ($request->has('attribute_id') && $request->input('attribute_id')) {
        //     $productAttr =  $this->productAttribute;
        //     foreach ($request->input('attribute_id') as $key => $value) {
        //         // dd($request->input('attribute_id')[$key]);
        //         if ($value) {

        //             $value = collect($value)->filter(function ($value, $key) {
        //                 return $value > 0;
        //             });
        //             if ($value->count()) {
        //                 $listIdPro = $productAttr->whereIn('attribute_id', $request->input('attribute_id')[$key])->pluck('product_id');
        //                 // dd($productAttr->get());
        //                 // dd($listIdPro);
        //                 $data = $data->whereIn('id', $listIdPro);
        //             }
        //         }
        //     }
        //     // dd($listIdPro);
        //     // dd($data->get());
        // }
        // dd($data->whereIn('category_id', $listIdChildren)->get());


        if ($request->has('orderby') && $request->input('orderby')) {
            if ($request->input('orderby') == 1) {
                $data =  $data->whereIn('category_id', $listIdChildren)->orderby('price');
            } elseif ($request->input('orderby') == 2) {
                $data =  $data->whereIn('category_id', $listIdChildren)->orderByDesc('price');
            } elseif ($request->input('orderby') == 3) {
                $data =  $data->whereIn('category_id', $listIdChildren)->orderby('sale');
            } elseif ($request->input('orderby') == 4) {
                $data =  $data->whereIn('category_id', $listIdChildren)->orderByDesc('price');
            } else {
                $data =  $data->whereIn('category_id', $listIdChildren)->orderByDesc('price');
            }
        } else {
            $data =  $data->whereIn('category_id', $listIdChildren)->orderby('price');
        }

        $countProduct = $data->count();

        $data = $data->latest()->paginate($this->limitProduct);

        // dd($data);
        return response()->json([
            "code" => 200,
            "html" => view('frontend.components.load-product-search', [
                'data' => $data,
                'unit' => $this->unit,
                'countProduct' => $countProduct
            ])->render(),
            "message" => "success"
        ], 200);
    }
}
