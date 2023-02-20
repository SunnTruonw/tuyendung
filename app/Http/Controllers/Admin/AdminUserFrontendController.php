<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Point;
use App\Traits\DeleteRecordTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Admin\ValidateAddAdminUserFrontend;
use App\Http\Requests\Admin\ValidateEditAdminUserFrontend;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\Admin\ValidateTranferPointBetweenXY;
use App\Http\Requests\Admin\ValidateTranferPointRandom;
use App\Traits\PointTrait;
use App\Models\Bank;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\Transaction;
use App\Traits\StorageImageTrait;
use Illuminate\Support\Facades\Auth;
use App\Helper\AddressHelper;
use App\Models\City;
use App\Models\District;
use App\Models\Commune;

use App\Models\Review;

use App\Exports\ExcelExportsDatabaseUser;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImportsDatabase;

use App\Mail\BookEmail;
use Illuminate\Support\Facades\Mail;

class AdminUserFrontendController extends Controller
{
    //
    // các trạng thái tài khoản active
    // 0 vừa tạo chưa kích hoạt
    // 1 đã kích hoat
    // 2 khóa tài khoản
    use DeleteRecordTrait, PointTrait, StorageImageTrait;

    private $user;

    private $numberChild = 3;
    private $typePoint;
    private $rose;
    private $tranferPointDefault;
    private $bank;
    private $product;
    private $categoryProduct;
    private $transaction;
    private $city;
    private $district;
    private $commune;
    private $categoryProductOrigin;
    private $review;
    public function __construct(
        Point $point,
        User $user,
        Bank $bank,
        Product $product,
        CategoryProduct $categoryProduct,
        Transaction $transaction,
        City $city,
        District $district,
        Commune $commune,
        Review $review
    ) {
        $this->typePoint = config('point.typePoint');

        $this->rose = config('point.rose');
        $this->tranferPointDefault = config('point.transferPointDefault');
        $this->user = $user;
        $this->point = $point;
        $this->bank = $bank;
        $this->product = $product;
        $this->transaction = $transaction;
        $this->categoryProduct = $categoryProduct;
        $this->commune = $commune;
        $this->city = $city;
        $this->district = $district;
        $this->review = $review;
        $this->categoryProductOrigin = config('web_default.frontend.categoryProductOrigin');
    }
    public function index(Request $request)
    {
        //  dd($this->product->setAppends(['number_pay'])->find(1));
        //   $a=  $this->product->setAppends(['pay'])->get()->toArray();
        //   asort($a);
        //  dd($a);

        $address = new AddressHelper();
        $dataCity = $this->city->orderby('name')->find([1, 79]);
        //  $cities = $address->cities($dataCity);

        $totalUser = $this->user->count();
        $data = $this->user;
        $where = [];
        $orWhere = null;
        if ($request->input('keyword')) {
            $data = $data->where(function ($query) {
                $keyword = request()->keyword;
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('username', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('id', '=', $keyword);
            });
        }

        if ($request->has('fill_action') && $request->input('fill_action')) {
            $key = $request->input('fill_action');
            switch ($key) {
                case 'userNoActive':
                    $where[] = ['active', '=', 0];
                    break;
                case 'userActive':
                    $where[] = ['active', '=', 1];
                    break;
                case 'userActiveKey':
                    $where[] = ['active', '=', 2];
                    break;
                default:
                    break;
            }
        }
        if ($request->has('type_user') && $request->input('type_user')) {
            $key = $request->input('type_user');
            switch ($key) {
                case 1:
                    $where[] = ['type', '=', 1];
                    break;
                case 2:
                    $where[] = ['type', '=', 2];
                    break;
                case 3:
                    $where[] = ['type', '=', 3];
                    break;
                case 4:
                    $where[] = ['type', '=', 4];
                    break;
                default:
                    break;
            }
        }
        if ($request->has('city_id') && $request->input('city_id')) {
            $where[] = ['city_id', '=', $request->input('city_id')];
            if ($request->has('district_id') && $request->input('district_id')) {
                $where[] = ['district_id', '=',  $request->input('district_id')];
            }
        }

        if ($where) {
            $data = $data->where($where);
        }
        //  dd($orWhere);
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
                case 'usernameASC':
                    $orderby = [
                        'username',
                        'ASC'
                    ];
                    break;
                case 'usernameDESC':
                    $orderby = [
                        'username',
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

        if ($request->has('btnExcel') && $request->input('btnExcel') == 1) {
            return Excel::download(new ExcelExportsDatabaseUser($data->get()), 'thanhvien.xlsx');
        }

        $data = $data->paginate(15);

        //  $data = $this->user->whereIn('active', [1,2])->orderBy("order", "desc")->orderBy("created_at", "desc")->paginate(15);
        return view("admin.pages.user_frontend.list",
            [
                'data' => $data,
                'dataCity' => $dataCity,
                'totalUser' => $totalUser,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
                'type_user' => $request->input('type_user') ? $request->input('type_user') : "",
            ]
        );
    }

    // public function listNoActive()
    // {
    //     $data = $this->user->where('active', 0)->orderBy("created_at", "desc")->paginate(15);
    //     return view(
    //         "admin.pages.user_frontend.list",
    //         [
    //             'data' => $data
    //         ]
    //     );
    // }

    public function detail($id, Request $request)
    {
        $user = $this->user->find($id);
        $data = $this->product->where('user_id', $id);
        // if ($request->input('category')) {
        //     $categoryProductId = $request->input('category');
        //     $idCategorySearch = $this->categoryProduct->getALlCategoryChildren($categoryProductId);
        //     $idCategorySearch[] = (int)($categoryProductId);
        //     $data = $data->whereIn('category_id', $idCategorySearch);
        //     $htmlselect = $this->categoryProduct->getHtmlOptionOriginById($this->categoryProductOrigin, $categoryProductId);
        // } else {
        //     $htmlselect = $this->categoryProduct->getHtmlOptionOriginById($this->categoryProductOrigin);
        // }
        // $data = $this->product->where('user_id', auth()->id());
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
        $totalProduct  = $data->count();
        //  dd($this->product->select('*', \App\Models\Store::raw('Sum(quantity) as total')->whereRaw('products.id','stores.product_id'))->orderBy('total')->paginate(15));
        $data = $data->paginate(15);
        //  dd($this->product->select('*', \App\Models\Store::raw('Sum(quantity) as total')->whereRaw('products.id','stores.product_id'))->orderBy('total')->paginate(15));

        $cities = $this->city->orderby('name')->get();


        return view("admin.pages.user_frontend.detail",
            [
                'user' => $user,
                'data' => $data,
                'cities' => $cities,
             //   'option' => $htmlselect,
                'totalProduct' => $totalProduct,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'start' => $request->input('start') ? $request->input('start') : "",
                'end' => $request->input('end') ? $request->input('end') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
            ]
        );
    }
    public function countBuy($id, Request $request)
    {
        //  dd($request->all());
        $user = $this->user->find($id);
        $dataProduct = $this->product->where('user_id', $id)->pluck('id');
        // dd($dataProduct);
        $where = [
            ['type', 3],
        ];
        if ($request->has('start') && $request->input('start')) {
            $where[] = ['created_at', '>=',  $request->input('start')];
        }
        if ($request->has('end') && $request->input('end')) {
            $where[] = ['created_at', '<=',  $request->input('end')];
        }

        $totalPoint = $this->point->where($where)->whereIn('userorigin_id', $dataProduct)->select(\App\Models\Point::raw('COUNT(id) as total'))->first()->total;

        $data = $this->point->where($where)->whereIn('userorigin_id', $dataProduct)->latest()->paginate(15);
        return view(
            "admin.pages.user_frontend.count-buy",
            [
                'user' => $user,
                'data' => $data,
                'totalPoint' => $totalPoint,
                'start' => $request->input('start') ? $request->input('start') : "",
                'end' => $request->input('end') ? $request->input('end') : "",
            ]
        );
    }
    public function create(Request $request = null)
    {
        return view(
            "admin.pages.user_frontend.add",
            [
                'request' => $request,
            ]
        );
    }

    public function store(ValidateAddAdminUserFrontend $request)
    {
        try {
            DB::beginTransaction();

            //  $parent_id2 = $this->getParentIdOfNewUser();
            //  $parent_id2 = $this->user->getParentIdOfNewUser();
            //   dd( $parent_id2);
            $dataAdminUserFrontendCreate = [
                'name' => $request->name,
                //   'email' => $request->email,
                'phone' => $request->phone,
                // 'tai_chinh' => $data['tai_chinh']??null,
                //  'city_id' => $data['city_id']??null,
                //  'district_id' => $data['district_id']??null,
                //  'commune_id' => $data['commune_id']??null,
                // 'address_detail' => $data['address_detail']??null,
                //  'sex' => $data['sex']??null,
                'username' => $request->username,
                // 'date_birth' => $data['date_birth']??null,
                'password' => Hash::make($request->password),
                'active' => 1,
                'admin_id' => auth()->guard('admin')->user()->id,
                'is_verified' => 1,
                'type' => 4,
            ];
            // dd($dataAdminUserFrontendCreate);
            // insert database in user table
            $user = $this->user->create($dataAdminUserFrontendCreate);
            // insert database to product_tags table

            DB::commit();
            return redirect()->route('admin.user_frontend.create')->with("alert", "Thêm thành viên  thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.user_frontend.create')->with("error", "Thêm thành viên không thành công");
        }
    }

    public function edit($id)
    {
        $data = $this->user->find($id);
        $banks = $this->bank->get();

        $address = new AddressHelper();
        $dataCity = $this->city->orderby('name')->get();
        $cities = $address->cities($dataCity, $id);

        return view("admin.pages.user_frontend.edit", [
            'data' => $data,
            'banks' => $banks,
            'cities' => $cities,

        ]);
    }

    public function update($id, ValidateEditAdminUserFrontend $request)
    {
        // dd($request->input('bank_id'));
        try {
            DB::beginTransaction();
            $user = $this->user->find($id);
            $dataUserUpdate = [
                // 'name' => $request->input('name'),
                // 'email' => $request->input('email'),
                // 'city_id'=>$request->input('city_id'),
                // 'district_id'=>$request->input('district_id'),
                // 'commune_id'=>$request->input('commune_id'),
                // 'address_detail'=>$request->input('address_detail'),
                // 'sex'=>$request->input('sex'),
                // 'username'=>$request->input('username'),
                // "phone" => $request->input('phone'),
                // 'date_birth'=>$request->input('date_birth'),

                //    "hktt" => $request->input('hktt'),
                //    "cmt" => $request->input('cmt'),
                //    "stk" => $request->input('stk'),
                //  "ctk" => $request->input('ctk'),
                //  "bank_id" => $request->input('bank_id'),
                // "bank_branch" => $request->input('bank_branch'),
                // "active" => $request->input('active'),
            ];

            // $dataUploadAvatar = $this->storageTraitUpload($request, "avatar_path", "product");
            // if (!empty($dataUploadAvatar)) {
            //     $dataUserUpdate["avatar_path"] = $dataUploadAvatar["file_path"];
            // }

            if (request()->has('password')) {
                if (request()->input('password')) {
                    $dataUserUpdate['password'] = Hash::make($request->input('password'));
                    // insert database in product table
                    $this->user->find($id)->update($dataUserUpdate);
                    $user = $this->user->find($id);
                }
            }


            DB::commit();
            return redirect()->route('admin.user_frontend.index')->with("alert", "Thay đổi thông tin thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.user_frontend.index')->with("error", "Thay đổi thông tin không thành công");
        }
    }

    public function destroy($id)
    {
        return $this->deleteTrait($this->user, $id);
    }

    public function loadActive($id)
    {
        try {
            DB::beginTransaction();
            $user   =  $this->user->find($id);
            $active = $user->active;
            $activeUpdate = 0;

            if ($active) {
                // $activeUpdate = 0;
            } else {
                $adminId = auth()->guard('admin')->user()->id;
                $activeUpdate = 1;
                $dataUserUpdate = [
                    'active' => $activeUpdate,
                    'admin_id' => $adminId,
                ];
                // dd( $dataUserUpdate);
                $updateResult =  $user->update($dataUserUpdate);
                $user   =  $this->user->find($id);
            }

            DB::commit();

            return response()->json([
                "code" => 200,
                "html" => view('admin.components.load-change-active-user', ['data' => $user, 'type' => 'user'])->render(),
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
    }
    // khóa tài khoản
    public function loadActiveKey($id)
    {
        $user   =  $this->user->find($id);
        $active = $user->active;

        if ($active) {
            try {
                DB::beginTransaction();
                $adminId = auth()->guard('admin')->user()->id;
                //   dd($adminId);
                if ($active == 1) {
                    $activeUpdate = 2;
                } elseif ($active == 2) {
                    $activeUpdate = 1;
                }
                $dataUserUpdate = [
                    'active' => $activeUpdate,
                    'admin_id' => $adminId,
                ];

                $updateResult =  $user->update($dataUserUpdate);
                DB::commit();
                if ($updateResult) {
                    return response()->json([
                        "code" => 200,
                        "html" => view('admin.components.load-change-active-user', ['data' => $user, 'type' => 'user'])->render(),
                        "message" => "success"
                    ], 200);
                } else {
                    return response()->json([
                        "code" => 500,
                        "message" => "fail"
                    ], 500);
                }
            } catch (\Exception $exception) {
                DB::rollBack();
                Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
                return response()->json([
                    "code" => 500,
                    "message" => "fail",
                    'title' => "Khóa tài khoản không thành công",
                ], 500);
            }
        } else {
            return response()->json([
                "code" => 500,
                "message" => "fail",
                'title' => "Khóa tài khoản không thành công do tài khoản chưa được kích hoạt",
            ], 200);
        }
    }





    // load chi tiết user
    public function loadUserDetail($id)
    {
        $user = $this->user->find($id);
        $sumEachType = $this->point->sumEachType($id);
        $sumPointCurrent = $this->point->sumPointCurrent($id);
        //  dd($user);
        return response()->json([
            'code' => 200,
            'html' => view('admin.components.user_frontend-detail', [
                'user' => $user,
            ])->render(),
            'messange' => 'success'
        ], 200);
    }

    public function history($id, Request $request)
    {
        $user = $this->user->find($id);
        $sumEachType = $this->point->sumEachTypeFrontend($user->id);
        //   dd($sumEachType);
        $sumPointCurrent = $this->point->sumPointCurrent($user->id);
        // dd($sumEachType);
        $point = $user->points()->latest()->paginate(15);

        return view(
            "admin.pages.user_frontend.history",
            [
                'user' => $user,
                'data' => $point,
                'sumPointCurrent' => $sumPointCurrent,
                'sumEachType' => $sumEachType,

            ]
        );
    }


    public function listPoint(Request $request)
    {
        $point = $this->point->where('type', '<>', 4)->latest()->paginate(15);

        return view(
            "admin.pages.user_frontend.point-list",
            [
                'data' => $point,
            ]
        );
    }


    public function listPointUp(Request $request)
    {
        $point = $this->point->where('type', 4)->latest()->paginate(15);

        return view(
            "admin.pages.user_frontend.point-list",
            [
                'data' => $point,
            ]
        );
    }
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    // danh sách toàn bộ review
    public function listReview(Request $request)
    {
        $data = $this->review;
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
        if ($request->has('status') && $request->input('status')) {
            $key = $request->input('status');
            switch ($key) {
                case 'status':
                    $data=$data->whereIn('status',[1,2]);
                    break;
                case 'no_status':
                    $data=$data->whereIn('status',[0,3]);
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

        return view("admin.pages.review.index",
            [
                'user' => auth()->user(),
                'data' => $data,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
                'status' => $request->input('status') ? $request->input('status') : "",
            ]
        );
    }
    // danh sách review theo id
    public function listReviewId($id, Request $request)
    {
        $data = $this->review->where('user_id', $id);
        $user = $this->user->find($id);
        if (!$user) {
            return;
        }
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
        if ($request->has('status') && $request->input('status')) {
            $key = $request->input('status');
            switch ($key) {
                case 'status':
                    $data=$data->whereIn('status',[1,2]);
                    break;
                case 'no_status':
                    $data=$data->whereIn('status',[0,3]);
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

        return view("admin.pages.review.indexId",
            [
                'user' => $user,
                'data' => $data,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
                'status' => $request->input('status') ? $request->input('status') : "",
            ]
        );
    }
    public function destroyReview($id)
    {
        return $this->deleteTrait($this->review, $id);
    }

    public function loadActiveReview($id)
    {

        $review   =  $this->review->find($id);
        $user=$review->user;
        $active = $review->active;

        if ($active||!$user) {
            return;
        } else {
            if ($active) {
                $activeUpdate = 0;
            } else {
                $activeUpdate = 1;
            }
            try {
                DB::beginTransaction();
                $updateResult =  $review->update([
                    'active' => $activeUpdate,
                    'admin_id' => auth()->guard('admin')->id()
                ]);
                $point = $user->points()->create([
                    'type'  => config('point.typePoint')[1]['type'],
                    'point' => config('point.typePoint')[1]['point'],
                    'userorigin_id' => $review->id,
                    'active' => 1,
                ]);

                $review   =  $this->review->find($id);

                if($user->email){
                    Mail::to($user->email)->send(new BookEmail($review));
                }
                DB::commit();
                return response()->json([
                    "code" => 200,
                    "html" => view('admin.components.load-change-review-active', ['data' => $review, 'type' => 'Review'])->render(),
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
        }
    }
    public function loadStatusReview($id)
    {

        $review   =  $this->review->find($id);
        $user=$review->user;
        $status = $review->status;

        if (!$status==1||!$user) {
            return;
        } else {

            $statusUpdate = 2;
            try {
                DB::beginTransaction();
                $updateResult =  $review->update([
                    'status' => $statusUpdate,
                    'admin_id' => auth()->guard('admin')->id()
                ]);
                // $point = $user->points()->create([
                //     'type'  => config('point.typePoint')[1]['type'],
                //     'point' => config('point.typePoint')[1]['point'],
                //     'userorigin_id' => $review->id,
                //     'active' => 1,
                // ]);

                $review   =  $this->review->find($id);

                DB::commit();
                return response()->json([
                    "code" => 200,
                    "html" => view('admin.components.load-change-review-status', ['data' => $review, 'type' => 'Review'])->render(),
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
        }
    }

    public function listBook(Request $request)
    {
        $data = $this->review->whereIn('status',[1,2]);
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
                case 'no_status':
                    $where[] = ['status', '=', 1];
                    break;
                case 'status':
                    $where[] = ['status', '=', 2];
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

        return view("admin.pages.review.list-book",
            [
                'user' => auth()->user(),
                'data' => $data,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
            ]
        );
    }
    public function listBookId(Request $request)
    {
        $data = $this->review;
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
                case 'point':
                    // $where[] = ['status', '=', 1];
                    $data=$data->whereIn('status',[0,3]);
                    break;
                case 'book':
                    $data=$data->whereIn('status',[1,2]);
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

        return view("admin.pages.review.list-book",
            [
                'user' => auth()->user(),
                'data' => $data,
                'keyword' => $request->input('keyword') ? $request->input('keyword') : "",
                'order_with' => $request->input('order_with') ? $request->input('order_with') : "",
                'fill_action' => $request->input('fill_action') ? $request->input('fill_action') : "",
            ]
        );
    }
}
