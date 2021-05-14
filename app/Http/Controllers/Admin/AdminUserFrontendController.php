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
use App\Http\Requests\Admin\ValidateEditAdminUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\Admin\ValidateTranferPointBetweenXY;
class AdminUserFrontendController extends Controller
{
    //
    use DeleteRecordTrait;

    private $user;

    private $numberChild = 3;
    private $typePoint;
    private $rose;
    private $tranferPointDefault;

    public function __construct(Point $point, User $user)
    {
        $this->typePoint = config('point.typePoint');

        $this->rose = config('point.rose');
        $this->tranferPointDefault = config('point.transferPointDefault');
        $this->user = $user;
        $this->point = $point;
    }
    public function index()
    {
        $data = $this->user->where('active', 1)->orderBy("order", "desc")->orderBy("created_at", "desc")->paginate(15);
        return view(
            "admin.pages.user_frontend.list",
            [
                'data' => $data
            ]
        );
    }
    public function listNoActive()
    {
        $data = $this->user->where('active', 0)->orderBy("created_at", "desc")->paginate(15);
        return view(
            "admin.pages.user_frontend.list",
            [
                'data' => $data
            ]
        );
    }
    public function detail($id, Request $request)
    {

        $user = $this->user->find($id);

        $rose = $this->point->where([
            'user_id' => $user->id,
        ])->whereIn(
            'type',
            [2, 3]
        )->orderby('created_at', 'DESC')->paginate(15);
        //  dd($rose);
        $htmlRoseUserFrontend = view('admin.components.load-rose-user-front-end', [
            'user' => $user,
            'rose' => $rose,
            'typePoint' => $this->typePoint
        ])->render();



        $dataUserTotal = $this->user->listUser20($user);
        $dataUser = $this->paginate($dataUserTotal, 15);
        $dataUser->withPath(route('admin.user_frontend.detail', [
            'id' => $id
        ]));
        $htmlUserFrontend = view('admin.components.load-user-front-end', [
            'user' => $user,
            'dataUser' => $dataUser,
            'typePoint' => $this->typePoint
        ])->render();

        $sumEachType = $this->point->sumEachType($user->id);
        $sumPointCurrent = $this->point->sumPointCurrent($user->id);
        if ($request->ajax()) {
            if ($request->type == 'user_frontend') {
                return response()->json([
                    'code' => 200,
                    'html' => $htmlUserFrontend,
                    'type' => 'user_frontend',
                    'messange' => 'success'
                ], 200);
            } else if ($request->type == 'rose-user_frontend') {
                return response()->json([
                    'code' => 200,
                    'html' => $htmlRoseUserFrontend,
                    'type' => 'rose-user_frontend',
                    'messange' => 'success'
                ], 200);
            }
        }
        return view(
            "admin.pages.user_frontend.detail",
            [
                'rose' => $rose,
                'htmlRoseUserFrontend' => $htmlRoseUserFrontend,
                'htmlUserFrontend' => $htmlUserFrontend,
                'typePoint' => $this->typePoint,
                'sumEachType' => $sumEachType,
                'sumPointCurrent' => $sumPointCurrent
            ]
        );
    }
    public function create(Request $request = null)
    {
        //    $parent_id2 = $this->user->getParentIdOfNewUser();
        //   dd(   $parent_id2 );
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

         //   for ($k = 1; $k <= 100; $k++) {

                // $k = "";
                //  $parent_id2 = $this->getParentIdOfNewUser();
                $parent_id2 = $this->user->getParentIdOfNewUser();
                //   dd( $parent_id2);
                $dataAdminUserFrontendCreate = [
                    "name" => $request->input('name') ,
                    "username" => $request->input('username'),
                    "email" => $request->input('email'),
                    'order' => $this->user->getOrderOfNewUser(),
                    "parent_id" => 0,
                    "parent_id2" => $parent_id2,
                    "password" => Hash::make('A123456'),
                    "active" => 1,
                ];
                //  dd($dataAdminUserFrontendCreate);
                // insert database in user table
                $user = $this->user->create($dataAdminUserFrontendCreate);
                // insert database to product_tags table
                // thêm số điểm nạp lúc đầu
                if ($request->has('startpoint')) {
                    $user->points()->create([
                        'type' => $this->typePoint[4]['type'],
                        'point' => $request->input('startpoint'),
                        'active' => 1,

                    ]);
                }
                $user->points()->create([
                    'type' => $this->typePoint[1]['type'],
                    'point' => $this->typePoint['defaultPoint'],
                    'active' => 1,
                ]);
                // thêm điểm thưởng cây 7 lớp
                // dd('a');
                $j = 1;
                $userLoop2 = $user;
                while ($j <= 7) {
                    if ($userLoop2->parent_id2 != 0) {
                        $userLoop2->parent2()->first()->points()->create([
                            'type' => $this->typePoint[3]['type'],
                            'point' => $this->typePoint['pointReward'],
                            'active' => 1,
                            'userorigin_id' => $user->id,
                        ]);
                        $userLoop2 = $userLoop2->parent2()->first();
                    } else {
                        break;
                    }
                    $j++;
                }
           // }

            // thêm số điểm cây 20 lớp
            // $i = 1;
            // $userLoop = $user;
            // while ($i <= 20) {
            //     dd($userLoop->parent2()->first());

            //     if ($userLoop->parent_id != 0) {

            //         $userLoop->parent()->first()->points()->create([
            //             'type' => $this->typePoint[2]['type'],
            //             'point' => $this->rose[$i]['percent'],
            //             'active' => 1,
            //             'userorigin_id' => $user->id,
            //         ]);
            //         $userLoop = $userLoop->parent()->first();
            //     } else {

            //         break;
            //     }
            //     $i++;
            // }

            DB::commit();
            return redirect()->route('admin.user_frontend.create')->with("alert", "Thêm thành viên thành công thành công");
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.user_frontend.create')->with("error", "Thêm thành viên không thành công");
        }
    }
    public function edit($id)
    {
        // $data = $this->admin->find($id);

        // return view("admin.pages.user.edit", [
        //     'data' => $data,
        // ]);
    }

    public function update(ValidateEditAdminUser $request, $id)
    {
        try {
            DB::beginTransaction();
            // $dataAdminUserUpdate = [
            //     "name" => $request->input('name'),
            //     "email" => $request->input('email'),
            //     "active" => $request->input('active'),
            // ];
            // if (request()->has('password')) {
            //     $dataAdminUserUpdate['password'] = Hash::make($request->input('password'));
            // }
            // insert database in product table
            //   $this->admin->find($id)->update($dataAdminUserUpdate);
            //   $admin = $this->admin->find($id);


            DB::commit();
            return redirect()->route('admin.user.index')->with("alert", "Sửa admin user thành công");
        } catch (\Exception $exception) {
            //throw $th;
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route('admin.user.index')->with("error", "Sửa admin user không thành công");
        }
    }

    public function destroy($id)
    {
        return $this->deleteTrait($this->user, $id);
    }
    public function getParentIdOfNewUser()
    {
        $numberChild = $this->numberChild;
        // công thức tính tổng số phần tử ở vòng thứ n là x*0 + (x^(n+1)-x)/(x-1);
        // công thức tính số phần tử của vòng thứ n = x^n;
        $numberUserDatabase = $this->user->where([
            'active' => 1,
        ])->get()->count();
        if ($numberUserDatabase > 0) {
            $numberUser = $numberUserDatabase + 1;
            $totalCicle = log((($numberUser - 1) * ($numberChild - 1) + $numberChild), $numberChild) - 1;
            // vòng hoàn thiện cuối cùng
            $n = floor($totalCicle);
            // dd($n);
            // tổng số user đến vòng thứ n là
            $numberUserN = 1 + (pow($numberChild, $n + 1) - $numberChild) / ($numberChild - 1);
            // dd($numberUserN);
            // số user đã có ở vòng tiếp theo
            $numberUserNNext = $numberUser - $numberUserN;
            // dd($numberUserNNext);
            // số user tối đa ở vòng tiếp theo là
            $numberUserMaxNNext = pow($numberChild, $n + 1);
            //  dd($numberUserMaxNNext);
            // số lượt rải chu kì ở vòng tiếp theo
            $nchuki = $numberUserMaxNNext / $numberChild;
            // user sẽ được làm cha của user mới là user thứ
            if ($numberUserNNext < $nchuki) {

                $nUserParent = $numberUserNNext;
            } else {
                if ($numberUserNNext % $nchuki == 0) {
                    $nUserParent = $nchuki;
                } else {
                    $nUserParent = $numberUserNNext % $nchuki;
                }
            }
            // if ($numberUserNNext % $nchuki == 0) {
            //     $nUserParent = $nchuki;
            // } else {
            //     $numberUserNNext = $numberUserNNext % $nchuki;
            //     $x = $numberUserNNext % $numberChild;
            //     while ($x>=$numberChild) {

            //     }

            // }
            // vị trị của thằng cha là
            $stt = $numberUserN - pow($numberChild, $n) + $nUserParent;
            // dd($nchuki);
            //  dd($nUserParent);
            // dd($stt);
            $userParent = $this->user->where([
                'active' => 1
            ])->orderBy('order', 'asc')->offset($stt - 1)->limit(1)->first();
            //   dd($nchuki);
            //  dd($n);
            //   dd($userParent);
            $parent_id2 = $userParent->id;
        } else {
            $parent_id2 = 0;
        }
        return $parent_id2;
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

                $parent_id2 = $this->user->getParentIdOfNewUser();
                $activeUpdate = 1;
                $orderUpdate = $this->user->getOrderOfNewUser();
                $updateResult =  $user->update([
                    'active' => $activeUpdate,
                    'order' => $orderUpdate,
                    'parent_id2'=>$parent_id2,
                ]);
                $user   =  $this->user->find($id);

                $j = 1;
                $userLoop2 = $user;
                while ($j <= 7) {
                    if ($userLoop2->parent_id2 != 0) {
                        $userLoop2->parent2()->first()->points()->create([
                            'type' => $this->typePoint[3]['type'],
                            'point' => $this->typePoint['pointReward'],
                            'active' => 1,
                            'userorigin_id' => $user->id,
                        ]);
                        $userLoop2 = $userLoop2->parent2()->first();
                    } else {
                        break;
                    }
                    $j++;
                }
            }

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
                "message" => "fail"
            ], 500);
        }
    }

    public function loadUserDetail($id)
    {
        $user = $this->user->find($id);
        $sumEachType = $this->point->sumEachType($id);
        $sumPointCurrent = $this->point->sumPointCurrent($id);
        //  dd($user);
        return response()->json([
            'code' => 200,
            'htmlTransactionDetail' => view('admin.components.user_frontend-detail', [
                'user' => $user,
                'sumEachType' => $sumEachType,
                'sumPointCurrent' => $sumPointCurrent,
                'typePoint' => $this->typePoint
            ])->render(),
            'messange' => 'success'
        ], 200);
    }

    public function transferPoint($id)
    {
        try {
            DB::beginTransaction();


            $user   =  $this->user->find($id);
            $user->points()->create([
                'type' => $this->typePoint[8]['type'],
                'point' => $this->tranferPointDefault,
                'active' => 1,
                'userorigin_id'=>0
            ]);
              DB::commit();
            return response()->json([
                "code" => 200,
                "html" => '',
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
    public function transferPointBetweenXY(ValidateTranferPointBetweenXY $request)
    {

        try {
            DB::beginTransaction();
            $users   =  $this->user->whereBetween('order', [$request->input('start'), $request->input('end')])->get();
          //  dd($users);
            $numberUser=$users->count();
            // dd($numberUser);
            foreach ($users as $user) {
                $user->points()->create([
                    'type' => $this->typePoint[8]['type'],
                    'point' => $this->tranferPointDefault,
                    'active' => 1,
                    'userorigin_id'=>0
                ]);
            }
              DB::commit();
              return redirect()->route("admin.user_frontend.index")->with("transferPointBetweenXY", "Bắn điểm thành công đên tổng số ".$numberUser." thành viên từ STT ".$request->input('start')."-" .$request->input('end'));
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message' . $exception->getMessage() . 'line :' . $exception->getLine());
            return redirect()->route("admin.user_frontend.index")->with("transferPointBetweenXYError", "Bắn điểm không  thành công");
        }
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
