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
                    $validate_value = ['á', 'à', 'ả', 'ạ', 'ã', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ', 'é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ', 'í', 'ì', 'ỉ', 'ĩ', 'ị', 'ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ', 'ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự', 'ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ', 'đ', '`', '~', '!', '#', '|', '$', '%', '^', '&', '*', '(', ')', '+', '=', ',', '.', '/', '?', '>', '<', '\"', '\'', ':', ';', ' '];
                    $contains = Str::contains($value, $validate_value);
                    if ($contains) {
                        $fail($attribute . ' không chứa các ký tự đặc biệt hoặc khoảng trắng!');
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
            "name.required" => "Tên của bạn không được để trống",
            "name.string" => "Tên phải là 1 chuỗi ký tự",
            "name.max" => "Số ký tự phải nhỏ hơn 255",

            "email.required" => "Email không được để trống",
            "email.string" => "Email phải là 1 chuỗi ký tự",
            "email.max" => "Số ký tự phải nhỏ hơn 255",
            "email.email" => "Làm ơn nhập đúng định dạng",
            "email.unique" => "Email đã tồn tại",

            "username.required" => "Tên đăng nhập của bạn không được để trống",
            "username.string" => "Tên đăng nhập phải là 1 chuỗi ký tự",
            "username.max" => "Số ký tự phải nhỏ hơn 255",
            "username.unique" => "Tên đăng nhập đã tồn tại",

            "password.required" => "Mật khẩu của bạn không được để trống",
            "password.string" => "Mật khẩu phải là 1 chuỗi ký tự",
            "password.min" => "Số ký tự phải lớn hơn 8",
            "password.confirmed" => "Mật khẩu và nhập lại mật khẩu không trùng khớp",

            "sex.required" => "Bạn chưa chọn giới tính",

            "phone.required" => "Số điện thoại của bạn không được để trống",
            "phone.regex" => "Số điện thoại là number và có 10 đến 11 ký tự",
            "phone.unique" => "Số điện thoại đã được đăng ký",

            "date_birth.unique" => "Ngày sinh là trường bắt buộc",
            "date_birth.date" => "Ngày sinh không đúng định dạng",
            "date_birth.before" => "Ngày sinh phải trước ngày hôm nay",

            "info_more.required" => "Sở thích là trường bắt buộc",
            "info_more.max" => "Sở thích < 191 ký tự",
            "info_more.string" => "Sở thích không đúng định dạng",

            "you_become.before" => "Bạn muốn trở thành  là trường bắt buộc",
            "you_become.max" => "Bạn muốn trở thành  < 191 ký tự",
            "you_become.string" => "Bạn muốn trở thành  không đúng định dạng",
            "checkrobot.accepted"=>"Bạn phải đồng ý với điều khoản của chúng tôi",
        ];
        // if ($data['type'] == 1) {
        //     $validate['city_id']=['required'];
        //     $validate['district_id']=['required'];
        //     $validate['tai_chinh']=['required'];
        //     $messages['city_id.required']='Thành phố là trường bắt buộc';
        //     $messages['district_id.required']='Quận huyện là trường bắt buộc';
        //     $messages['tai_chinh.required']='Tài chính là trường bắt buộc';
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

        // return redirect(route('login'))->with('status', 'Vui lòng xác nhận tài khoản email');
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
        /*    Đoạn code verify email */

        // Mail::send('emails.verify', ['verification_code' => $user->verification_code], function ($message) {
        //     $message->to(request()->email, request()->name)
        //         ->subject('Verify your email address');
        // });
        // $notification_status = "Bạn phải vào email của bạn để xác nhận  hoàn thành đăng ký. Xin cảm ơn!";
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
            $notification_status = 'Bạn đã xác nhận email thành công';
        } else {
            $notification_status = 'Mã xác nhận không chính xác';
        }

        return redirect(route('login'))->with('statusSuccess', $notification_status);
    }
}
