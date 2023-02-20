<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Point;

use App\Traits\StorageImageTrait;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Frontend\ValidateAddUser;
use App\Http\Requests\Frontend\ValidateEditUser;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Frontend\ValidateDrawPoint;
use App\Models\Bank;
use App\Models\Transaction;
use App\Traits\PointTrait;
use App\Helper\AddressHelper;
use App\Models\City;
use App\Models\District;
use App\Models\Commune;
use App\Http\Requests\Frontend\ValidateAddPost;
use App\Http\Requests\Frontend\ValidateEditPost;
use App\Http\Requests\Frontend\ValidateAddProduct;
use App\Http\Requests\Frontend\ValidateEditProduct;
use App\Http\Requests\Frontend\ValidateAddReview;
use App\Http\Requests\Frontend\ValidateEditReview;
use App\Http\Requests\Frontend\ValidateAddShop;
use App\Http\Requests\Frontend\ValidateChangePasswordUser;
use App\Models\Post;
use App\Models\CategoryPost;
use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\Tag;
use App\Models\PostTag;
use Illuminate\Support\Facades\Validator;
use App\Traits\DeleteRecordTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\ProductImage;
use App\Models\Setting;
use App\Models\Review;
use App\Models\ReviewImage;

class ProfileController extends Controller
{
    //
    use StorageImageTrait, PointTrait, DeleteRecordTrait;
    private $user;
    private $point;
    private $typePoint;
    private $rose;
    private $typePay;
    private $datePay;
    private $bank;
    private $city;
    private $district;
    private $commune;
    private $post;
    private $categoryPost;
    private $product;
    private $categoryProduct;
    private $tag;
    private $postTag;
    private $categoryProductOrigin;
    private $donvi;
    private $huongnha;
    private $productImage;
    private $setting;
    private $review;
    private $reviewImage;

    private $chiDanTruTienKhiXemTin;
    private $chiDanTruTienKhiDangTin;
    private $chiDanNapTienKhiDangLaiTin;

    private $listStatus;
    public function __construct(
        User $user,
        Point $point,
        Bank $bank,
        Transaction $transaction,
        Product $product,
        City $city,
        District $district,
        Commune $commune,
        Post $post,
        CategoryPost $categoryPost,
        Tag $tag,
        PostTag $postTag,
        CategoryProduct $categoryProduct,
        ProductImage $productImage,
        Setting $setting,
        Review $review,
        ReviewImage $reviewImage
    ) {
        $this->user = $user;
        $this->point = $point;
        $this->bank = $bank;
        $this->typePoint = config('point.typePoint');
        $this->typePay = config('point.typePay');
        $this->rose = config('point.rose');
        $this->datePay = config('point.datePay');
        $this->huongnha = config('web_default.huongnha');
        $this->donvi = config('web_default.donvi');
        $this->transaction = $transaction;
        $this->listStatus = config('web_default.statusTransaction');
        $this->product = $product;
        $this->categoryProduct = $categoryProduct;
        $this->commune = $commune;
        $this->city = $city;
        $this->district = $district;
        $this->productImage = $productImage;

        $this->post = $post;
        $this->categoryPost = $categoryPost;
        $this->tag = $tag;
        $this->postTag = $postTag;
        $this->setting = $setting;
        $this->review = $review;
        $this->reviewImage = $reviewImage;


        $this->categoryProductOrigin = config('web_default.frontend.categoryProductOrigin');

        $this->chiDanNapTienKhiXemTin = optional($this->setting->find(110))->description;
        $this->chiDanNapTienKhiDangTin = optional($this->setting->find(111))->description;
        $this->chiDanNapTienKhiDangLaiTin = optional($this->setting->find(112))->description;
    }
    public function index(Request $request)
    {
        $user = auth()->guard()->user();
        $id=$user->id;
        $transactionGroupByStatusBuy = $user->transactions()->select($this->transaction->raw('count(status) as total'), 'status')->groupBy('status')->get();
        $totalTransactionBuy = $user->transactions()->count();
        //   dd( $transactionGroupByStatus);
        $dataTransactionGroupByStatusBuy = $this->listStatus;
        foreach ($transactionGroupByStatusBuy as $item) {
            $dataTransactionGroupByStatusBuy[$item->status]['total'] = $item->total;
        }

        $transactionGroupByStatus = $this->transaction->select($this->transaction->raw('count(status) as total'), 'status')->where('origin_id',$id)->groupBy('status')->get();
        $totalTransaction = $this->transaction->where('origin_id',$id)->get()->count();

        $dataTransactionGroupByStatus = $this->listStatus;
        foreach ($transactionGroupByStatus as $item) {
            $dataTransactionGroupByStatus[$item->status]['total'] = $item->total;
        }


        $data = $this->product->where('user_id', auth()->id());
        $totalProduct=$data->count();
        $where = [];
        $orWhere = null;
        if ($request->input('keyword')) {
            $data=$data->where(function($query) use($request){
                return $query->where('rollid', 'like', '%' . $request->input('keyword') . '%')
                    ->orWhere('masp', 'like', '%' . $request->input('keyword') . '%')
                    ->orWhere('bienkiemsoat', 'like', '%' . $request->input('keyword') . '%');
            });
        }
        if ($request->has('start') && $request->input('start')) {
            $data=$data->where('time_buy','>=',$request->input('start'));
        }
        if ($request->has('end') && $request->input('end')) {
            $data=$data->where('time_buy','<=',$request->input('end'));
        }
        if ($request->has('city_id') && $request->input('city_id')) {
            $data=$data->where('city_id',$request->input('city_id'));
        }

        if ($request->input('order_with')) {
            $key = $request->input('order_with');
            switch ($key) {
                case 'dateASC':
                    $orderby = ['time_buy'];
                    break;
                case 'dateDESC':
                    $orderby = [
                        'time_buy',
                        'DESC'
                    ];
                    break;
                default:
                    $orderby =  $orderby = [
                        'time_buy',
                        'DESC'
                    ];
                    break;
            }
            $data = $data->orderBy(...$orderby);
        } else {
            $data = $data->orderBy("time_buy", "DESC");
        }
        //  dd($this->product->select('*', \App\Models\Store::raw('Sum(quantity) as total')->whereRaw('products.id','stores.product_id'))->orderBy('total')->paginate(15));
        $data = $data->paginate(15);
        $cities = $this->city->orderby('name')->get();

        return view('frontend.pages.profile.profile', [
            'dataTransactionGroupByStatusBuy' => $dataTransactionGroupByStatusBuy,
            'totalTransactionBuy' => $totalTransactionBuy,
            'user'=>$user,
            'cities'=>$cities,
            'dataTransactionGroupByStatus' => $dataTransactionGroupByStatus,
            'totalProduct' => $totalProduct,

            'data' => $data,
            //  'option' => $htmlselect,
              'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
              'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
              'start' => $request->input('start') ? $request->input('start') : "",
              'end' => $request->input('end') ? $request->input('end') : "",
              'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
        ]);
    }

    public function editInfo()
    {
        $user = auth()->guard('web')->user();
        // $banks = $this->bank->get();

        // $address = new AddressHelper();
        // $data = $this->city->orderby('name')->get();
        // $cities = $address->cities($data, $user->city_id);
        //   dd($cities);
        return view('frontend.pages.profile.profile-edit-info', [
            'data' => $user,
          //  'cities' => $cities,
            'user' => $user
        ]);
    }
    public function updateInfo(ValidateEditUser $request)
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();
            $dataUserUpdate = [
                'date_birth' => $request->input('date_birth'),
                'info_more' =>  $request->input('info_more'),
                'you_become' =>  $request->input('you_become'),
            ];
            if(!$user->provider){
                $dataUserUpdate['name'] = $request->input('name');
                $dataUserUpdate['email'] = $request->input('email');
                // 'city_id' => $request->input('city_id'),
                //  'district_id' => $request->input('district_id'),
                //  'commune_id' => $request->input('commune_id'),
                // 'address_detail' => $request->input('address_detail'),
                // 'sex' => $request->input('sex'),
                 $dataUserUpdate['username'] = $request->input('username');
                 $dataUserUpdate["phone"] = $request->input('phone');
                 $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "product");
                 //  dd($dataUploadAvatar);
                 if (!empty($dataUploadAvatar)) {
                     $dataUserUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
                 }
                //  if (request()->has('password') && request()->input('password')) {
                //      $dataUserUpdate['password'] = Hash::make($request->input('password'));
                //  }
            }
            // insert database in product table
            $user->update($dataUserUpdate);
            DB::commit();
            return redirect()->route('profile.index')->with("alert", "Thay đổi thông tin thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('profile.editIindexnfo', ['user' => $user])->with("error", "Thay đổi thông tin không thành công");
        }
    }
    public function changePassword()
    {
        $user = auth()->guard('web')->user();
        $banks = $this->bank->get();
        $address = new AddressHelper();

        //   dd($cities);
        return view('frontend.pages.profile.profile-change-password', [
            'data' => $user,
            'user' => $user
        ]);
    }
    public function updatePassword(ValidateChangePasswordUser $request)
    {
        try {
            DB::beginTransaction();
            $user = auth()->user();

            if($user->isCreateToWeb()){
                $dataUserUpdate = [
                    'password' => Hash::make($request->input('password')),
                ];
                $user->update($dataUserUpdate);
            }else{
                abort(404);
            }
            // insert database in product table
            DB::commit();
            return redirect()->route('profile.index')->with("alert", "Thay đổi mật khẩu thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('profile.index', ['user' => $user])->with("error", "Thay đổi mật khẩu không thành công");
        }
    }
    // tạo shop
    public function createShop(Request $request)
    {
        // dd($this->categoryProduct->find($this->categoryProductOrigin));
        return view("frontend.pages.profile.create-shop",
        );
    }
    public function storeShop(ValidateAddShop $request)
    {
        $user=Auth::user();
        if ($user->isCreateShop()) {
            abort(404);
        }
        try {
            DB::beginTransaction();
            $user->update([
                'name_store'=>$request->name_store,
                'address_store'=>$request->address_store,
                'status_store'=>1,
            ]);

            $dataUploadLogo = $this->storageTraitUpload($request, "logo_store", "user");
            if (!empty($dataUploadLogo)) {
                $user->update([
                    'logo_store'=>$dataUploadLogo["file_path"],
                ]);
            }
            DB::commit();
            return redirect()->route('profile.index')->with("alert", "Tạo gian hàng thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('profile.index')->with("error", "Tạo gian hàng không thành công");
        }
    }
    public function editShop(Request $request)
    {
        // dd($this->categoryProduct->find($this->categoryProductOrigin));
        $data=auth()->user();
        return view("frontend.pages.profile.edit-shop",[
            'data'=>$data
        ]);
    }
    public function updateShop(ValidateAddShop $request)
    {
        $user=Auth::user();
        if (!$user->isCreateShop()) {
            abort(404);
        }
        try {
            DB::beginTransaction();
            $user->update([
                'name_store'=>$request->name_store,
                'address_store'=>$request->address_store,
                'status_store'=>1,
            ]);
            $dataUploadLogo = $this->storageTraitUpload($request, "logo_store", "user");
            if (!empty($dataUploadLogo)) {
                $user->update([
                    'logo_store'=>$dataUploadLogo["file_path"],
                ]);
            }
            DB::commit();
            return redirect()->route('profile.index')->with("alert", "Sửa gian hàng thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('profile.index')->with("error", "Sửa gian hàng không thành công");
        }
    }

    public function historyBuy(Request $request)
    {
        $user = auth()->guard()->user();
        $data = $user->transactions()->latest()->paginate(15);

        $transactionGroupByStatus = $user->transactions()->select($this->transaction->raw('count(status) as total'), 'status')->groupBy('status')->get();
        $totalTransaction = $user->transactions()->count();
        //   dd( $transactionGroupByStatus);
        $dataTransactionGroupByStatus = $this->listStatus;
        foreach ($transactionGroupByStatus as $item) {
            $dataTransactionGroupByStatus[$item->status]['total'] = $item->total;
        }

        return view('frontend.pages.profile.profile-history', [
            'dataTransactionGroupByStatus' => $dataTransactionGroupByStatus,
            'totalTransaction' => $totalTransaction,
            'user' => $user,
            'data' => $data,
            'listStatus' => $this->listStatus,
        ]);
    }

    public function loadTransactionDetail($id)
    {
        $user = auth()->guard()->user();
        $transaction=$this->transaction->find($id);
        if(!$transaction){
            abort(404);
        }
        if($transaction->user_id!=$user->id&&$transaction->origin_id!=$user->id){
            abort(404);
        }
        $orders = $transaction->orders()->get();
        return response()->json([
            'code' => 200,
            'html' => view('frontend.pages.profile.transaction-detail', [
                'orders' => $orders,
                'transaction'=>$transaction
            ])->render(),
            'messange' => 'success'
        ], 200);
    }

    /**
     * start quản lý gian hàng
     */
    // Danh sách , thêm sửa xóa sản phẩm

    public function listProduct(Request $request)
    {
        $data = $this->product->where('user_id', auth()->id());
        // if ($request->input('category')) {
        //     $categoryProductId = $request->input('category');
        //     $idCategorySearch = $this->categoryProduct->getALlCategoryChildren($categoryProductId);
        //     $idCategorySearch[] = (int)($categoryProductId);
        //     $data = $data->whereIn('category_id', $idCategorySearch);
        //     $htmlselect = $this->categoryProduct->getHtmlOptionOriginById($this->categoryProductOrigin, $categoryProductId);
        // } else {
        //     $htmlselect = $this->categoryProduct->getHtmlOptionOriginById($this->categoryProductOrigin);
        // }
        $where = [];
        $orWhere = null;
        if ($request->input('keyword')) {
            $data=$data->where(function($query) use($request){
                return $query->where('rollid', 'like', '%' . $request->input('keyword') . '%')
                    ->orWhere('masp', 'like', '%' . $request->input('keyword') . '%')
                    ->orWhere('bienkiemsoat', 'like', '%' . $request->input('keyword') . '%');
            });
        }
        if ($request->has('start') && $request->input('start')) {
            $data=$data->where('time_buy','>=',$request->input('start'));
        }
        if ($request->has('end') && $request->input('end')) {
            $data=$data->where('time_buy','<=',$request->input('end'));
        }
        if ($request->has('city_id') && $request->input('city_id')) {
            $data=$data->where('city_id',$request->input('city_id'));
        }
        if ($request->input('order_with')) {
            $key = $request->input('order_with');
            switch ($key) {
                case 'dateASC':
                    $orderby = ['time_buy'];
                    break;
                case 'dateDESC':
                    $orderby = [
                        'time_buy',
                        'DESC'
                    ];
                    break;
                default:
                    $orderby =  $orderby = [
                        'time_buy',
                        'DESC'
                    ];
                    break;
            }
            $data = $data->orderBy(...$orderby);
        } else {
            $data = $data->orderBy("time_buy", "DESC");
        }
        //  dd($this->product->select('*', \App\Models\Store::raw('Sum(quantity) as total')->whereRaw('products.id','stores.product_id'))->orderBy('total')->paginate(15));
        $data = $data->paginate(15);

        $cities = $this->city->orderby('name')->get();
       // dd($data);
        return view("frontend.pages.profile.product-list",
            [
                'user' => auth()->user(),
                'data' => $data,
                'cities' => $cities,
              //  'option' => $htmlselect,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'start' => $request->input('start') ? $request->input('start') : "",
                'end' => $request->input('end') ? $request->input('end') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
            ]
        );
    }

    public function createProduct(Request $request = null)
    {
         $address = new AddressHelper();
         $data = $this->city->orderby('name')->get();
         $cities = $address->cities($data);
        // $donvi = $this->donvi;
        // $huongnha = $this->huongnha;
        // $typeGD = $this->categoryProduct->where([
        //     'active' => 1,
        //     'parent_id' => $this->categoryProductOrigin,
        // ])->get();
        //  dd($typeGD);
        // $htmlselect = $this->categoryProduct->getHtmlOptionOriginById($this->categoryProductOrigin);
        // dd($this->categoryProduct->find($this->categoryProductOrigin));
        return view("frontend.pages.profile.product-add",
            [
                'user' => auth()->user(),
               // 'option' => $htmlselect,
                'request' => $request,
                 'cities' => $cities,
                //  'donvi' => $donvi,
                //  'huongnha' => $huongnha,
                //  'typeGD' => $typeGD,
            ]
        );
    }

    public function storeProduct(ValidateAddProduct $request)
    {
        try {
            DB::beginTransaction();
            $dataProductCreate = [
                "masp" => $request->input('masp'),
                "name_chunha" => $request->input('name_chunha'),
                "phone_chunha" => $request->input('phone_chunha'),
                "address_chunha" => $request->input('address_chunha') ,
                "type_car" => $request->input('type_car') ,
                "bienkiemsoat" => $request->input('bienkiemsoat') ,
                "rollid" => $request->input('rollid') ,
                "time_buy" => $request->input('time_buy') ,
                "time_expires" => $request->input('time_expires') ,
                "content" => $request->input('content'),
                "user_id" => auth()->guard('web')->id(),
                "city_id" =>  $request->input('city_id') ,
            ];
            $this->product->create($dataProductCreate);
            DB::commit();

            return redirect()->route('profile.listProduct')->with("alert", "Đăng sản phẩm thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('profile.listProduct')->with("error", "Đăng sản phẩm không thành công");
        }
    }
    public function editProduct($id)
    {

        $data = $this->product->find($id);
        $category_id = $data->category_id;
        $htmlselect = $this->categoryProduct->getHtmlOptionOriginById($this->categoryProductOrigin, $category_id);
        $cities = $this->city->orderby('name')->get();
        // $address = new AddressHelper();
        //  $dataCity = $this->city->orderby('name')->find([1, 79]);
        //  $cities = $address->cities($dataCity, $data->city_id);
        // $typeGD = $this->categoryProduct->where([
        //     'active' => 1,
        //     'parent_id' => $this->categoryProductOrigin,
        // ])->get();
        return view("frontend.pages.profile.product-edit", [
            'user' => auth()->user(),
            'option' => $htmlselect,
            'data' => $data,
             'cities' => $cities,
            // 'donvi' => $this->donvi,
            // 'huongnha' => $this->huongnha,
            // 'typeGD' => $typeGD,
        ]);
    }
    public function updateProduct(ValidateEditProduct $request, $id)
    {
        try {
            DB::beginTransaction();
            $dataProductUpdate = [
                "masp" => $request->input('masp'),
                "name_chunha" => $request->input('name_chunha'),
                "phone_chunha" => $request->input('phone_chunha'),
                "address_chunha" => $request->input('address_chunha') ,
                "type_car" => $request->input('type_car') ,
                "bienkiemsoat" => $request->input('bienkiemsoat') ,
                "rollid" => $request->input('rollid') ,
                "time_buy" => $request->input('time_buy') ,
                "time_expires" => $request->input('time_expires') ,
                "content" => $request->input('content'),
                "city_id" => $request->input('city_id'),
            ];

            // //  dd($dataProductUpdate);
            // if ($request->input('price') && $request->has('price')) {
            //     $dataProductUpdate['price'] = transMoneyToStore($request->input('price'), $request->input('donvi'));
            //     $dataProductUpdate['donvi'] = $request->input('donvi');
            //     //    dd($dataProductCreate['price']);
            // } else {
            //     $dataProductUpdate['price'] = 0;
            //     $dataProductUpdate['donvi'] = 1;
            // }

            // // dd( $dataProductUpdate);
            // $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "product");
            // if (!empty($dataUploadAvatar)) {
            //     $dataProductUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
            // }
            // // insert database in product table
             $this->product->find($id)->update($dataProductUpdate);
            // $product = $this->product->find($id);
            // // insert database to product_images table


            // // insert database to product_images table
            // if ($request->hasFile("image")) {
            //     //
            //     //   $product->images()->where("product_id", $id)->delete();
            //     $dataProductImageUpdate = [];
            //     foreach ($request->file('image') as $fileItem) {
            //         $dataProductImageDetail = $this->storageTraitUploadMutiple($fileItem, "product");
            //         $itemImage = [
            //             "name" => $dataProductImageDetail["file_name"],
            //             "image_path" => $dataProductImageDetail["file_path"]
            //         ];
            //         $dataProductImageUpdate[] = $itemImage;
            //     }
            //     // insert database in product_images table by createMany
            //     // dd($dataProductImageUpdate);
            //     $product->images()->createMany($dataProductImageUpdate);
            //     //  dd($product->images);
            // }



            // // insert database to product_tags table
            // if ($request->has("tags")) {
            //     foreach ($request->tags as $tagItem) {
            //         $tagInstance = $this->tag->firstOrCreate(["name" => $tagItem]);
            //         $tag_ids[] = $tagInstance->id;
            //         // $this->productTag->create([
            //         //   "product_id"=> $product->id,
            //         //   "tag_id"=>$tagInstance->id,
            //         // ]);
            //     }
            //     // Các syncphương pháp chấp nhận một loạt các ID để ra trên bảng trung gian. Bất kỳ ID nào không nằm trong mảng đã cho sẽ bị xóa khỏi bảng trung gian.
            //     $product->tags()->sync($tag_ids);
            // }
            DB::commit();
            return redirect()->route('profile.listProduct')->with("alert", "Sửa sản phẩm thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('profile.listProduct')->with("error", "Sửa sản phẩm không thành công");
        }
    }
    public function updateToTop(Request $request, $id)
    {
        //   dd(Carbon::now()->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d h:i:m'));
        //  dd($id);
        // check điểm
        $product = $this->product->find($id);
        if (!$product) {
            return;
        }
        $userId = auth()->user()->id;
        $pointM = new Point();
        $sumPointCurrent = $pointM->sumPointCurrent($userId);
        //  dd($sumPointCurrent < config('point.typePoint')[2]['point']);
        if (auth()->user()->type == 4) {
            try {
                DB::beginTransaction();
                $dataProductUpdate = [
                    "created_at" => Carbon::now(),
                ];
                $product->update($dataProductUpdate);
                // insert database to product_images table
                DB::commit();
                return redirect()->route('profile.listProduct')->with("alert", "Đưa  sản phẩm lên trên thành công");
            } catch (\Exception $exception) {
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return redirect()->route('profile.listProduct')->with("error", "Đưa sản phẩm lên trên không thành công");
            }
        } else if ($sumPointCurrent < config('point.typePoint')[4]['point']) {
            $index = 0;
            if (session()->has('dataProductWaitUpToTop')) {
                $dataProductWaitUpToTop = session()->get('dataProductWaitUpToTop');
                $index = time();
                $dataProductWaitUpToTop[$index] = $product;

                session()->put('dataProductWaitUpToTop', $dataProductWaitUpToTop);
                // array_push($dataProductWait,$request);
            } else {
                $index = time();
                $dataProductWaitUpToTop = [];
                $dataProductWaitUpToTop[$index] =  $product;
                //  dd($dataProductWait);
                session()->put('dataProductWaitUpToTop', $dataProductWaitUpToTop);
                //  dd(session()->get('dataProductWait'));
            }
            // session()->put('urlProductPay',route('profile.createProduct'));
            return redirect()->route('profile.createPaymentCartUp', [
                'money' => config('point.typePoint')[4]['point'],
                'product_up' => $index
            ])
                ->with('mes', $this->chiDanNapTienKhiDangLaiTin);
            //->with('mes', 'Tài khoản của bạn phải lớn hơn <strong>' . number_format(config('point.typePoint')[2]['point']) . ' VNĐ </strong>  để đăng lại tin. Vui lòng nạp tiền vào tài khoản để tiếp tục');
        } else {
            try {
                DB::beginTransaction();
                $user = auth()->user();
                $point = $user->points()->create([
                    'type'  => config('point.typePoint')[4]['type'],
                    'point' => -config('point.typePoint')[4]['point'],
                    'userorigin_id' => $product->id,
                    'active' => 1,
                ]);
                $dataProductUpdate = [
                    "created_at" => Carbon::now(),
                    "time_expires" => Carbon::now()->addDay(30),
                ];
                $product->update($dataProductUpdate);
                // insert database to product_images table
                DB::commit();
                return redirect()->route('profile.listProduct')->with("alert", "Đưa  sản phẩm lên trên thành công");
            } catch (\Exception $exception) {
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return redirect()->route('profile.listProduct')->with("error", "Đưa sản phẩm lên trên không thành công");
            }
        }
    }
    public function destroyProductImage($id, $idImage)
    {
        return $this->deleteImageTrait($this->productImage, $idImage);
    }

    public function destroyProduct($id)
    {
        return $this->deleteTrait($this->product, $id);
    }

    public function loadActive($id)
    {
        $product   =  $this->product->find($id);
        $active = $product->active;
        if ($active) {
            $activeUpdate = 0;
        } else {
            $activeUpdate = 1;
        }
        $updateResult =  $product->update([
            'active' => $activeUpdate,
        ]);
        $product   =  $this->product->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-active', ['data' => $product, 'type' => 'Sản phẩm'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
    public function loadHot($id)
    {
        $post   =  $this->post->find($id);
        $hot = $post->hot;

        if ($hot) {
            $hotUpdate = 0;
        } else {
            $hotUpdate = 1;
        }
        $updateResult =  $post->update([
            'hot' => $hotUpdate,
        ]);

        $post   =  $this->post->find($id);
        if ($updateResult) {
            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-hot', ['data' => $post, 'type' => 'bài viết'])->render(),
                "message" => "success"
            ], 200);
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }

    public function loadCategoryChildProduct(Request $request)
    {
        $id = $request->id;
        $listChild = $this->categoryProduct->find($id)->childs()->where('active', 1)->get();
        // dd($listChild);
        $htmlOption = "";
        foreach ($listChild as $child) {
            $htmlOption .= "<option value='" . $child->id . "'>" . $child->name . "</option>";
        }
        // dd($htmlOption);
        return response()->json([
            "code" => 200,
            "html" => $htmlOption,
            "message" => "success"
        ], 200);
    }

    // Quản lý các đơn hàng
    public function transaction(Request $request)
    {
        //thống kê giao dịch
        $id=auth()->id();
        $transactionGroupByStatus = $this->transaction->select($this->transaction->raw('count(status) as total'), 'status')->where('origin_id',$id)->groupBy('status')->get();
        $totalTransaction = $this->transaction->where('origin_id',$id)->get()->count();

        $dataTransactionGroupByStatus = $this->listStatus;
        foreach ($transactionGroupByStatus as $item) {
            $dataTransactionGroupByStatus[$item->status]['total'] = $item->total;
        }
        //    dd($dataTransactionGroupByStatus);

        $transactions = $this->transaction->where('origin_id',$id);
        $where = [];
        $orWhere = null;
        if ($request->has('keyword') && $request->input('keyword')) {

            $transactions = $transactions->where(function ($query) {
                $query->where([
                    ['name', 'like', '%' . request()->input('keyword') . '%']
                ])->orWhere([
                    ['code', 'like', '%' . request()->input('keyword') . '%']
                ])->orWhere([
                    ['phone', 'like', '%' . request()->input('keyword') . '%']
                ])->orWhere([
                    ['email', 'like', '%' . request()->input('keyword') . '%']
                ]);
            });
            // $where[] = ['name', 'like', '%' . $request->input('keyword') . '%'];
            // $orWhere = ['code', 'like', '%' . $request->input('keyword') . '%'];
        }
        if ($request->has('status') && $request->input('status')) {
            $where[] = ['status', $request->input('status')];
        }
        if ($where) {
            $transactions = $transactions->where($where);
        }
        if ($orWhere) {
            $transactions = $transactions->orWhere(...$orWhere);
        }
        $orderby = [];
        if ($request->has('order_with') && $request->input('order_with')) {
            $key = $request->input('order_with');
            switch ($key) {
                case 'dateASC':
                    $orderby[] = ['created_at'];
                    break;
                case 'dateDESC':
                    $orderby[] = [
                        'created_at',
                        'DESC'
                    ];
                    break;
                case 'statusASC':
                    $orderby[] = ['status', 'ASC'];
                    $orderby[] = ['created_at', 'DESC'];
                    break;
                case 'statusDESC':
                    $orderby[] = ['status', 'DESC'];
                    $orderby[] = [
                        'created_at',
                        'DESC'
                    ];
                    break;
                default:
                    $orderby[]  = [
                        'created_at',
                        'DESC'
                    ];
                    break;
            }
            foreach ($orderby as $or) {
                $transactions = $transactions->orderBy(...$or);
            }
        } else {
            $transactions = $transactions->latest();
        }

        $transactions =  $transactions->paginate(15);
        return view('frontend.pages.profile.transaction-list', [
            'data' => $transactions,
            'dataTransactionGroupByStatus' => $dataTransactionGroupByStatus,
            'totalTransaction' => $totalTransaction,
            'listStatus' => $this->listStatus,
            'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
            'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
            'statusCurrent' => $request->input('status') ? $request->input('status') : "",
        ]);
    }
    // chuyển trạng thái đơn hàng
    public function loadNextStepStatus($id,Request $request)
    {
        $transaction = $this->transaction->where('origin_id',auth()->id())->find($id);
        if(!$transaction){
            return;
        }
        $status = $transaction->status;

        $dataUpdate = [];
        switch ($status) {
            case -1:
                break;
            case 1:
                $status += 1;
                break;
            case 2:
                $status += 1;
                break;
            case 3:
                $status += 1;
                break;
            case 4:
                break;
            default:
                break;
        }
        $dataUpdate['status']=$status;
        $transaction->update($dataUpdate);
        return response()->json([
            'code' => 200,
            'htmlStatus' => view('admin.components.status', [
                'dataStatus' => $transaction,
                'listStatus' => $this->listStatus,
            ])->render(),
            'messange' => 'success'
        ], 200);
    }

    public function editStatus($id)
    {
        $transaction=$this->transaction->find($id);
        if(!$transaction||$transaction->origin_id!=auth()->id()){
            abort(404);
        }

        return response()->json([
            'code' => 200,
            'html' => view('frontend.pages.profile.loadStatusTransaction', [
                'data'=>$transaction
            ])->render(),
            'messange' => 'success'
        ], 200);
    }
    public function updateStatus($id,Request $request){
        $transaction=$this->transaction->find($id);
        //  dd($transaction);
        if(!$transaction||$transaction->origin_id!=auth()->id()){
            abort(404);
        }

        $transaction->update([
            'status'=>$request->status,
            'note_shop'=>$request->note_shop,
            'thanhtoan'=>$request->thanhtoan??0,
        ]);

        return response()->json([
            'code' => 200,
            'html' => view('admin.components.status', [
                'dataStatus' => $transaction,
                'listStatus' => $this->listStatus,
            ])->render(),
            'messange' => 'success'
        ], 200);

        // $rule = [
        //     'email' => 'required|email|string|max:191',
        //     'name' => 'required|string|max:191',
        // ];
        // $validator = Validator::make($request->all(), $rule);
        // // dd($validator->errors()->all());
        // if (!$validator->passes()) {
        //     return response()->json([
        //         'code' => 200,
        //         'htmlErrorValidate' => view('admin.components.load-error-ajax', [
        //             "errors" => $validator->errors()
        //         ])->render(),
        //         'messange' => 'success',
        //         'validate' => true
        //     ], 200);
        // }
    }


    //pay ment
    public function createPayment()
    {
        $user = auth()->guard('web')->user();
        return view('frontend.pages.vnpay.index', [
            'user' => $user
        ]);
    }
    public function storePayment(Request $request)
    {

        $vnp_BankCode = $request->bank_code;
        //  $vnp_TmnCode = env('VNP_TMN_CODE'); //Mã website tại VNPAY
        //  $vnp_HashSecret = env('VNP_HASH_SECRET'); //Chuỗi bí mật
        //  $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = route('profile.returnPayment');
        $vnp_TxnRef = date("YmdHis"); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = "Thanh toán hóa đơn nạp tiền vào website";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->input('amount') * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        // $inputData = array(
        //     "vnp_Version" => "2.1.0",
        //    // "vnp_TmnCode" => $vnp_TmnCode,
        //     "vnp_Amount" => $vnp_Amount,
        //     "vnp_Command" => "pay",
        //     "vnp_CreateDate" => date('YmdHis'),
        //     "vnp_CurrCode" => "VND",
        //     "vnp_IpAddr" => $vnp_IpAddr,
        //     "vnp_Locale" => $vnp_Locale,
        //     "vnp_OrderInfo" => $vnp_OrderInfo,
        //     "vnp_OrderType" => $vnp_OrderType,
        //     "vnp_ReturnUrl" => $vnp_Returnurl,
        //     "vnp_TxnRef" => $vnp_TxnRef,
        // );

        // if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        //     $inputData['vnp_BankCode'] = $vnp_BankCode;
        // }

        //    ksort($inputData);

        //     $query = "";
        //     $i = 0;
        //     $hashdata = "";
        //     foreach ($inputData as $key => $value) {
        //         if ($i == 1) {
        //             $hashdata .= '&' . $key . "=" . $value;
        //         } else {
        //             $hashdata .= $key . "=" . $value;
        //             $i = 1;
        //         }
        //         $query .= urlencode($key) . "=" . urlencode($value) . '&';
        //     }

        //     $vnp_Url = $vnp_Url . "?" . $query;
        //     if (isset($vnp_HashSecret)) {
        //         $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
        //         $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        //     }
        //   return redirect($vnp_Url);
        $response = \VNPay::purchase([
            'vnp_TxnRef' => time(),
            'vnp_OrderInfo' => time(),
            'vnp_IpAddr' => request()->ip(),
            'vnp_Amount' =>  $request->input('amount') * 100,
            'vnp_Locale' => 'vn',
            'vnp_ReturnUrl' => route('profile.returnPayment'),
            'vnp_BankCode' => $vnp_BankCode,
            'vnp_OrderType' => $vnp_OrderType,
            'vnp_OrderInfo' => $vnp_OrderInfo,
            "vnp_CurrCode" => "VND",
            "vnp_Command" => "pay",
            "vnp_CardType" => "ATM",
            //  "vnp_Version" => "2.0.1",
        ])->send();

        if ($response->isRedirect()) {
            $redirectUrl = $response->getRedirectUrl();
            // TODO: chuyển khách sang trang VNPay để thanh toán
        }
        //  dd($redirectUrl);
        return redirect($redirectUrl);
    }
    public function returnPayment(Request $request)
    {
        $response = \VNPay::completePurchase()->send();
        $user = Auth::guard('web')->user();
        if ($response->isSuccessful()) {
            // TODO: xử lý kết quả và hiển thị.
            // dd(\Carbon::parse($response->getData()['vnp_PayDate']));
            // print $response->getTransactionId();
            //   echo "<br>";
            //  print $response->getTransactionReference();  echo "<br>";
            //   print $response->vnp_Amount;  echo "<br>";
            //    print $response->vnp_TxnRef;
            //dd($response->getData()); // toàn bộ data do VNPay gửi sang.


            try {
                DB::beginTransaction();
                $dataR = $response->getData();
                $dataR['vnp_Amount'] = $dataR['vnp_Amount'] / 100;
                $point = $user->points()->create([
                    'type' => $this->typePoint[1]['type'],
                    'point' => transMoneyToPoint($dataR['vnp_Amount']),
                    'active' => 1,
                ]);

                $dataPaymentCreate = [
                    'vnp_Amount' => $dataR['vnp_Amount'],
                    'vnp_BankCode' => $dataR['vnp_BankCode'],
                    'vnp_BankTranNo' => $dataR['vnp_BankTranNo'],
                    'vnp_OrderInfo' => $dataR['vnp_OrderInfo'],
                    'vnp_PayDate' => $dataR['vnp_PayDate'],
                    'vnp_ResponseCode' => $dataR['vnp_ResponseCode'],
                    'vnp_TransactionNo' => $dataR['vnp_TransactionNo'],
                    'vnp_TxnRef' => $dataR['vnp_TxnRef'],
                    'user_id' => $user->id,
                ];

                $payment = $point->payment()->create($dataPaymentCreate);
                // dd($payment);
                DB::commit();
                if (session()->has('urlProductPay')) {

                    $url = $request->session()->pull('urlProductPay');
                    return redirect($url)->with("alert", "Nạp thành công");
                }
                return redirect()->route('profile.createPayment', ['user' => $user])->with("alert", "Nạp thành công");
            } catch (\Exception $exception) {
                //throw $th;
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return redirect()->route('admin.setting.create', ['parent_id' => $request->parentId])->with("error", "Nạp không thành công");
            }
        } else {
            return ($response->getMessage());
        }
    }

    /**
     * quản lý review
     * thêm review
     */
    public function createReview(Request $request = null)
    {
        // $htmlselect = $this->categoryProduct->getHtmlOptionOriginById($this->categoryProductOrigin);
        // dd($this->categoryProduct->find($this->categoryProductOrigin));
        return view("frontend.pages.review.review-add",
            [
                'user' => auth()->user(),
            ]
        );
    }
    // lưu review
    public function storeReview(ValidateAddReview $request)
    {
        try {
            DB::beginTransaction();
            $dataReviewCreate = [
                "name" => $request->input('name'),
                // "slug" => Str::slug($request->input('name')),
                "slug" => $request->input('slug'),
                "link" => $request->input('link'),

                "view" => $request->input('view') ?? 0,
                "description" => $request->input('description') ?? "",
                "description_seo" => $request->input('description_seo') ?? "",
                "title_seo" => $request->input('title_seo') ?? "",
                "keyword_seo" => $request->input('keyword_seo') ?? "",
                "content" => $request->input('content'),
                "active" => 0,
                // "category_id" => $request->input('category_id'),
                "user_id" => auth()->guard('web')->id(),
                'code'=>makeCodeReview($this->review)
            ];

            $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "product");
            if (!empty($dataUploadAvatar)) {
                $dataReviewCreate["avatar_path"] = $dataUploadAvatar["file_path"];
            }

            // insert database in product table
            $review = $this->review->create($dataReviewCreate);

            //  dd($product);
            // insert database to product_images table
            if ($request->hasFile("image")) {
                //
                $dataReviewImageCreate = [];
                foreach ($request->file('image') as $fileItem) {
                    $dataReviewImageDetail = $this->storageTraitUploadMutiple($fileItem, "review");
                    $dataReviewImageCreate[] = [
                        "name" => $dataReviewImageDetail["file_name"],
                        "image_path" => $dataReviewImageDetail["file_path"]
                    ];
                }
                // insert database in product_images table by createMany
                $review->images()->createMany($dataReviewImageCreate);
            }

            DB::commit();
            return redirect()->route('profile.listReview')->with("alert", "Đăng review thành công. Đang đợi admin duyệt bài");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('profile.listReview')->with("error", "Đăng review không thành công");
        }
    }
    public function listReview(Request $request){
        $data = $this->review->where('user_id', auth()->id());
        $where = [];
        $orWhere = null;
        if ($request->input('keyword')) {
            $where[] = ['name', 'like', '%' . $request->input('keyword') . '%'];
        }
        if ($request->has('fill_action') && $request->input('fill_action')) {
            $key = $request->input('fill_action');
            switch ($key) {
                case 'active':
                    $where[] = ['active', '=', 1];
                    break;
                case 'no_active':
                    $where[] = ['active', '=', 0];
                    break;
                default:
                    break;
            }
        }
        if ($where) {
            $data = $data->where($where);
        }
        if ($orWhere) {
            $data = $data->orWhere(...$orWhere);
        }
        if ($request->input('order_with')) {
            $key = $request->input('order_with');
            switch ($key) {
                case 'dateASC':
                    $orderby = ['created_at'];
                    break;
                case 'dateDESC':
                    $orderby = [
                        'created_at',
                        'DESC'
                    ];
                    break;
                case 'viewASC':
                    $orderby = [
                        'view',
                        'ASC'
                    ];
                    break;
                case 'viewDESC':
                    $orderby = [
                        'view',
                        'DESC'
                    ];
                    break;
                default:
                    $orderby =  $orderby = [
                        'created_at',
                        'DESC'
                    ];
                    break;
            }
            $data = $data->orderBy(...$orderby);
        } else {
            $data = $data->orderBy("created_at", "DESC");
        }
        //  dd($this->product->select('*', \App\Models\Store::raw('Sum(quantity) as total')->whereRaw('products.id','stores.product_id'))->orderBy('total')->paginate(15));
        $data = $data->paginate(15);

        return view("frontend.pages.review.index",
            [
                'user' => auth()->user(),
                'data' => $data,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
            ]
        );
    }
    public function bookAgree($code)
    {
        $user=auth()->user();
        $review=$this->review->where([
            ['code',$code],
            ['status',0],
            ['user_id',$user->id]
        ])->first();
        if($review){
            return view('frontend.pages.review.book-agree-add',[
                'user'=>auth()->user(),
                'review'=>$review
            ]);
        }
    }
    public function storeBookAgree($code,Request $request)
    {
        $request->validate([
            'name_nhan' => 'required|max:191',
            'phone_nhan' => 'required|max:191',
            'address_nhan' => 'required|max:191',
        ]);
        $user=auth()->user();
        $review=$this->review->where([
            ['code',$code],
            ['status',0],
            ['user_id',$user->id]
        ])->first();
        if($review){
            $review->update([
                'code'=>null,
                'status'=>1,
                'name_nhan'=>$request->name_nhan,
                'phone_nhan'=>$request->phone_nhan,
                'address_nhan'=>$request->address_nhan,
                'info_nhan'=>$request->info_nhan,
            ]);
            $review->points()->delete();
            return redirect()->route('profile.index')->with("alert", "Xác nhận nhận sách thành công");
        }else{
            return redirect()->route('profile.index')->with("error", "Xác nhận nhận sách không thành công");
        }
    }
    public function bookCancel($code)
    {
        $user=auth()->user();
        $review=$this->review->where([
            ['code',$code],
            ['status',0],
            ['user_id',$user->id]
        ])->first();
        if($review){
            $review->update([
                'code'=>null,
                'status'=>3
            ]);
            return redirect()->route('profile.index')->with("alert", "Xác nhận nhận điểm thành công");
        }else{
            return redirect()->route('profile.index')->with("error", "Xác nhận nhận điểm không thành công");
        }
    }

    public function infoProduct($username,$id,Request $request)
    {
        $data=$this->user->where([
            ['username',$username],
            ['id',$id],
        ])->first();
        if(!$data||!$data->isCreateShop()){
            abort(404);
        }

        $dataProduct = $data->products()->latest()->paginate(12);
        $dataView = [
            'data'=>$data,
            'dataProduct' => $dataProduct,
            // 'dataReview' => $dataReview,
        ];

        return view("frontend.pages.profile.info-product",$dataView);
    }
    public function infoReview($username,$id,Request $request)
    {
        $data=$this->user->where([
            ['username',$username],
            ['id',$id],
        ])->first();
        if(!$data){
            abort(404);
        }


        $dataReview = $data->reviews()->latest()->paginate(12);

        $dataView = [
            'data'=>$data,
            'dataReview' => $dataReview,
            // 'dataReview' => $dataReview,
        ];

        return view("frontend.pages.profile.info-review",$dataView);
    }
}
