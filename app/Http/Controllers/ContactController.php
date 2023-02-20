<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Setting;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Mail\ContactEmail;
use Illuminate\Support\Facades\Mail;
class ContactController extends Controller
{
    //
    private $setting;
    private $contact;
    public function __construct(Setting $setting, Contact $contact)
    {
        /*$this->middleware('auth');*/
        $this->setting=$setting;
        $this->contact=$contact;
    }
    public function index(){
        $dataAddress=$this->setting->find(28);
        $map=$this->setting->find(33);
        $breadcrumbs= [
            [
                'name'=>"Liên hệ",
                'slug'=>makeLink('contact'),
            ],
        ];

        // Thông tin mục hệ thống
        $system = $this->setting->where('id','57')->where('active', 1)->orderByDesc('created_at')->first();
        // Thông tin item mục hệ thống
        $systemChilds = $this->setting->where('parent_id','57')->where('active', 1)->orderByDesc('created_at')->limit(2)->get();
        $listAddress = $this->setting->where('parent_id','28')->where('active', 1)->orderBy('created_at','ASC')->limit(6)->get();


        return view("frontend.pages.contact",[
            'breadcrumbs' => $breadcrumbs,
            'systemChilds'=>$systemChilds,
            'system'=>$system,
            'listAddress'=>$listAddress,
            'typeBreadcrumb' => 'contact',
            'title' =>  "Thông tin liên hệ",

            'seo' => [
                'title' => "Thông tin liên hệ",
                'keywords' =>  "Thông tin liên hệ",
                'description' =>   "Thông tin liên hệ",
                'image' =>  "",
                'abstract' =>  "Thông tin liên hệ",
            ],

            "dataAddress"=>$dataAddress,
            "map"=>$map,
        ]);
    }
    public function storeAjax(Request $request){
     //   dd($request->name);
    // dd($request->ajax());
         try {
             DB::beginTransaction();

            $dataContactCreate = [
                'name' => $request->input('name'),
                'phone' => $request->input('phone')??"",
                'type' => $request->input('type')??0,
                'email' => $request->input('email')??"",
                'active' => $request->input('active')??1,
                'status' => 1,
                'city_id' => $request->input('city_id')??null,
                'district_id' => $request->input('district_id')??null,
                'commune_id' => $request->input('commune_id')??null,
                'address_detail' => $request->input('address_detail')??null,
                'content'=>'
                    Nội dung: '.$request->input('content')??null,
                'admin_id' => 0,
                'user_id' => Auth::check() ? Auth::user()->id : 0,
            ];
            // Tên dự án: '.$request->input('nameDuan').'<br>
            // Giá dự án: '.$request->input('priceDuan').'<br>
            // Diện tích dự án: '.$request->input('dientichDuan').' m2 <br>
            $contact = $this->contact->create($dataContactCreate);

            //  dd($contact);
            DB::commit();
            //
            // Mail::to('nhadatnamdo@gmail.com')->send(new ContactEmail($contact));
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
                'html'=>'Gửi thông tin không thành công',
                "message" => "fail"
            ], 500);

         }
    }
}
