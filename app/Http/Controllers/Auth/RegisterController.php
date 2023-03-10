<?php

namespace App\Http\Controllers\Auth;

use Str;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Helper\AddressHelper;
use App\Models\City;
use App\Models\District;
use App\Models\Commune;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $city;
    private $district;
    private $commune;
    private $setting;
    public function __construct(
        City $city,
        District $district,
        Commune $commune,
        Setting $setting
    ) {
        $this->middleware('guest');
        $this->commune = $commune;
        $this->city = $city;
        $this->district = $district;
        $this->setting = $setting;
        //   $this->middleware('guest:web');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //  dd($data);
        $validate = [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'username' => [
                'required',
                'string',
                'max:191',
                'unique:users',
                function ($attribute, $value, $fail) {
                    $validate_value = ['??', '??', '???', '???', '??', '??', '???', '???', '???', '???', '???', '??', '???', '???', '???', '???', '???', '??', '??', '???', '???', '???', '??', '???', '???', '???', '???', '???', '??', '??', '???', '??', '???', '??', '??', '???', '??', '???', '??', '???', '???', '???', '???', '???', '??', '???', '???', '???', '???', '???', '??', '??', '???', '??', '???', '??', '???', '???', '???', '???', '???', '??', '???', '???', '???', '???', '??', '`', '~', '!', '#', '|', '$', '%', '^', '&', '*', '(', ')', '+', '=', ',', '.', '/', '?', '>', '<', '\"', '\'', ':', ';', ' '];
                    $contains = Str::contains($value, $validate_value);
                    if ($contains) {
                        $fail($attribute . ' kh??ng ch???a c??c k?? t??? ?????c bi???t ho???c kho???ng tr???ng!');
                    }
                },
            ],
            'password' => ['required', 'string', 'confirmed'],
          //  'sex' => ['required'],
            // 'type' => [
            //     'required',
            //     Rule::in([1, 2, 3]),
            // ],
            "phone" => ['required', 'regex:/[0-9]{10,11}/', 'unique:users'],
            "address_detail" => 'nullable',

            // 'date_birth' => ['required', 'date','before:today'],
            // 'info_more' => ['required', 'string', 'max:191'],
            // 'you_become' => ['required', 'string', 'max:191'],
            'checkrobot'=>['accepted']
        ];
        $messages = [
            "name.required" => "T??n c???a b???n kh??ng ???????c ????? tr???ng",
            "name.string" => "T??n ph???i l?? 1 chu???i k?? t???",
            "name.max" => "S??? k?? t??? ph???i nh??? h??n 255",

            "email.required" => "Email kh??ng ???????c ????? tr???ng",
            "email.string" => "Email ph???i l?? 1 chu???i k?? t???",
            "email.max" => "S??? k?? t??? ph???i nh??? h??n 255",
            "email.email" => "L??m ??n nh???p ????ng ?????nh d???ng",
            "email.unique" => "Email ???? t???n t???i",

            "username.required" => "T??n ????ng nh???p c???a b???n kh??ng ???????c ????? tr???ng",
            "username.string" => "T??n ????ng nh???p ph???i l?? 1 chu???i k?? t???",
            "username.max" => "S??? k?? t??? ph???i nh??? h??n 255",
            "username.unique" => "T??n ????ng nh???p ???? t???n t???i",

            "password.required" => "M???t kh???u c???a b???n kh??ng ???????c ????? tr???ng",
            "password.string" => "M???t kh???u ph???i l?? 1 chu???i k?? t???",
            "password.min" => "S??? k?? t??? ph???i l???n h??n 8",
            "password.confirmed" => "M???t kh???u v?? nh???p l???i m???t kh???u kh??ng tr??ng kh???p",

            "sex.required" => "B???n ch??a ch???n gi???i t??nh",

            "phone.required" => "S??? ??i???n tho???i c???a b???n kh??ng ???????c ????? tr???ng",
            "phone.regex" => "S??? ??i???n tho???i l?? number v?? c?? 10 ?????n 11 k?? t???",
            "phone.unique" => "S??? ??i???n tho???i ???? ???????c ????ng k??",

            "date_birth.unique" => "Ng??y sinh l?? tr?????ng b???t bu???c",
            "date_birth.date" => "Ng??y sinh kh??ng ????ng ?????nh d???ng",
            "date_birth.before" => "Ng??y sinh ph???i tr?????c ng??y h??m nay",

            "info_more.required" => "S??? th??ch l?? tr?????ng b???t bu???c",
            "info_more.max" => "S??? th??ch < 191 k?? t???",
            "info_more.string" => "S??? th??ch kh??ng ????ng ?????nh d???ng",

            "you_become.before" => "B???n mu???n tr??? th??nh  l?? tr?????ng b???t bu???c",
            "you_become.max" => "B???n mu???n tr??? th??nh  < 191 k?? t???",
            "you_become.string" => "B???n mu???n tr??? th??nh  kh??ng ????ng ?????nh d???ng",
            "checkrobot.accepted"=>"B???n ph???i ?????ng ?? v???i ??i???u kho???n c???a ch??ng t??i",
        ];
        // if ($data['type'] == 1) {
        //     $validate['city_id']=['required'];
        //     $validate['district_id']=['required'];
        //     $validate['tai_chinh']=['required'];
        //     $messages['city_id.required']='Th??nh ph??? l?? tr?????ng b???t bu???c';
        //     $messages['district_id.required']='Qu???n huy???n l?? tr?????ng b???t bu???c';
        //     $messages['tai_chinh.required']='T??i ch??nh l?? tr?????ng b???t bu???c';
        // }
        return Validator::make(
            $data,
            $validate,
            $messages
        );
    }


    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $address = new AddressHelper();
        $data = $this->city->orderby('name')->find([1,79]);
        $cities = $address->cities($data);
      //  $content = $this->setting->find(54);
        $data=$this->setting->find(164);
        return view('auth.register', [
            'cities' => $cities,
           // 'content' => $content,
            'data'=>$data
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $verification_code = time() . uniqid(true);

        // return redirect(route('login'))->with('status', 'Vui l??ng x??c nh???n t??i kho???n email');
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'] ?? "",
            'phone' => $data['phone'],
            'tai_chinh' => $data['tai_chinh']??null,
            'city_id' => $data['city_id']??null,
            'district_id' => $data['district_id']??null,
            'commune_id' => $data['commune_id']??null,
            'address_detail' => $data['address_detail']??null,
            'sex' => $data['sex']??null,
            'username' => $data['username'],
          //  'info_more' => $data['info_more']??null,
          //  'you_become' => $data['you_become']??null,
           // 'date_birth' => $data['date_birth']??null,
            'password' => Hash::make($data['password']),
            'active' => 0,
            'admin_id' => null,
            //'type' => $data['type'],

            // xac thuc email
            // 'verification_code' => $verification_code,
            // 'is_verified' => 0,
        ]);


        return $user;
    }

    public function register(Request $request)
    {

        if($request->ajax()){
            $validator = Validator::make($request->all(),  [
                'username' => ['required', 'string', 'max:191', 'unique:users'],
                'name' => ['required', 'string', 'max:191'],
                'email' => ['required', 'string', 'email', 'max:191','unique:users'],
                "phone" => ['required', 'regex:/[0-9]{10,11}/', 'unique:users'],
                'password' => ['required', 'string', 'min:1', 'confirmed'],
                'date_birth' => ['required', 'date','before:today'],
                'info_more' => ['required', 'string', 'max:191'],
                'you_become' => ['required', 'string', 'max:191'],
            ]);
            //  $validator= $this->validator($request->all());
            if($validator->passes()){
                event(new Registered($user = $this->create($request->all())));
                $this->guard()->login($user,false);
                return response()->json([
                    'code' => 200,
                    'data' => '',
                    'messange' => 'success',
                    'validate' => false
                ], 200);
            }else{
                return response()->json([
                    'code' => 200,
                    'htmlErrorValidate' => view('admin.components.load-error-ajax', [
                        "errors" => $validator->errors()
                    ])->render(),
                    'messange' => 'error',
                    'validate' => true
                ], 200);
            }

        }else{
            $validator= $this->validator($request->all())->validate();
            event(new Registered($user = $this->create($request->all())));

            $this->guard()->login($user);

            if ($response = $this->registered($request, $user)) {
                return $response;
            }

        //  $this->guard()->login($user);
        /*    ??o???n code verify email */

        // Mail::send('emails.verify', ['verification_code' => $user->verification_code], function ($message) {
        //     $message->to(request()->email, request()->name)
        //         ->subject('Verify your email address');
        // });
        // $notification_status = "B???n ph???i v??o email c???a b???n ????? x??c nh???n  ho??n th??nh ????ng k??. Xin c???m ??n!";
        // return redirect(route('login'))->with('status', $notification_status);

         /*  end code verify email       */
            return $request->wantsJson()
                        ? new JsonResponse([], 201)
                        : redirect($this->redirectPath());
        }
    }

    public function verify($code)
    {
        $user = User::where('verification_code', $code);

        if ($user->count() > 0) {
            $user->update([
                'is_verified' => 1,
                'verification_code' => null
            ]);
            $notification_status = 'B???n ???? x??c nh???n email th??nh c??ng';
        } else {
            $notification_status = 'M?? x??c nh???n kh??ng ch??nh x??c';
        }

        return redirect(route('login'))->with('statusSuccess', $notification_status);
    }
}
