<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeImage;
use App\Models\Contact;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Post;
use App\Models\User;
use App\Models\CategoryPost;
use App\Models\CategoryProduct;
use App\Models\Slider;
use App\Models\Setting;
use App\Models\Menu;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminHomeController extends Controller
{
    //
    private $transaction;
    private $attribute;
    private $attributeImage;
    private $user;
    private $product;
    private $post;
    private $listStatus;
    private $contact;
    private $categoryPost;
    private $categoryProduct;
    private $slider;
    private $setting;
    private $menu;
    private $review;

    public function __construct(
        Transaction $transaction,
        User $user,
        Post $post,
        Product $product,
        Contact $contact,
        CategoryPost $categoryPost,
        CategoryProduct $categoryProduct,
        Slider $slider,
        Setting $setting,
        Menu $menu,
        Review $review,
        Attribute $attribute,
        AttributeImage $attributeImage
    ) {
        $this->middleware('auth:admin');
        $this->transaction = $transaction;
        $this->listStatus = $this->transaction->listStatus;
        $this->user = $user;
        $this->post = $post;
        $this->product = $product;
        $this->contact = $contact;
        $this->categoryPost = $categoryPost;
        $this->categoryProduct = $categoryProduct;
        $this->slider = $slider;
        $this->setting = $setting;
        $this->menu = $menu;
        $this->review = $review;
        $this->attribute = $attribute;
        $this->attributeImage = $attributeImage;
    }
    public function index()
    {
        //  $totalTransaction = $this->transaction->count();
        //  $totalMember = $this->user->count();
        $totalProduct = $this->product->count();
        $totalPost = $this->post->count();
        $totalReview = $this->review->count();
        $countTransaction = [];
        // // l???y s??? giao d???ch ???? b??? h???y b???
        // $countTransaction['-1'] = $this->transaction->where([
        //     ['status', '=', '-1'],
        // ])->count();
        // // l???y s??? l?????ng ????n h??ng ???? ?????t h??ng th??nh c??ng
        // $countTransaction['1'] = $this->transaction->where([
        //     ['status', '=', '1'],
        // ])->count();
        // // l???y s??? giao d???ch ???? ti???p nh???n
        // $countTransaction['2'] = $this->transaction->where([
        //     ['status', '=', '2'],
        // ])->count();
        // // l???y s??? giao d???ch ??ang v???n chuy???n
        // $countTransaction['3'] = $this->transaction->where([
        //     ['status', '=', '3'],
        // ])->count();
        // // l???y s??? giao d???ch ???? ho??n th??nh
        // $countTransaction['4'] = $this->transaction->where([
        //     ['status', '=', '4'],
        // ])->count();

        // l???y 20 giao d???ch m???i nh???t ch??a ???????c x??? l??
        // tr???ng th??i l?? 1 2 3
        // $newTransaction = $this->transaction->whereIn('status', [1, 2, 3])->orderByDesc('created_at')->limit(20)->get();
        //  $topPayProduct = $this->product->orderByDesc('pay')->get();

        // l???y s??? contact
        $countContact = $this->contact->count();


        // l???y b??i vi???t m???i nh???t
        //    $listCategoryPost = $this->categoryPost->getALlCategoryChildrenAndSelf(21);
        //  dd($listCategoryPost);
        //  $postNews = $this->post->whereIn('category_id', $listCategoryPost)->orderBy('created_at')->limit(10)->get();

        // $listCategoryProduct = $this->categoryProduct->getALlCategoryChildrenAndSelf(1);
        // dd($listCategoryProduct);
        $productNews = $this->product->where('active', 1)->latest()->limit(10)->get();
        $reviewNews = $this->review->where('active', 1)->latest()->limit(10)->get();

        // dd($postNews);
        //  dd($countContact);
        return view("admin/pages/index", [
            //  'totalTransaction' => $totalTransaction,
            // 'totalMember' => $totalMember,
            'totalProduct' => $totalProduct,
            'totalPost' => $totalPost,
            'totalReview' => $totalReview,
            'countTransaction' => $countTransaction,
            // 'newTransaction' => $newTransaction,
            //  'topPayProduct' => $topPayProduct,
            //  'listStatus' => $this->listStatus,
            'countContact' => $countContact,
            //  'postNews' => $postNews,
            'productNews' => $productNews,
            'reviewNews' => $reviewNews,
        ]);
    }
    public function loadOrderVeryModel($table, $id, Request $request)
    {
        switch ($table) {
            case 'sliders':
                $model = $this->slider;
                break;
            case 'settings':
                $model = $this->setting;
                break;
            case 'category_products':
                $model = $this->categoryProduct;
                break;
            case 'category_posts':
                $model = $this->categoryPost;
                break;
            case 'posts':
                $model = $this->post;
                break;
            case 'products':
                $model = $this->product;
                break;
            case 'attributes':
                $model = $this->attribute;
                break;
            case 'attribute_images':
                $model = $this->attributeImage;
                break;
            case 'menus':
                $model = $this->menu;
                break;
            default:
                $model = null;
                break;
        }
        //   dd($model);
        if ($model) {
            try {
                DB::beginTransaction();

                $dataUpdate = [
                    "order" => $request->input('order'),
                    "admin_id" => auth()->guard('admin')->id()
                ];
                $model->find($id)->update($dataUpdate);
                DB::commit();
                return response()->json([
                    "code" => 200,
                    "html" => 'S???a s??? th??? t??? th??nh c??ng',
                    "message" => "success"
                ], 200);
            } catch (\Exception $exception) {
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return response()->json([
                    "code" => 500,
                    "message" => "fail"
                ], 500);
            }
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail"
            ], 500);
        }
    }
}
