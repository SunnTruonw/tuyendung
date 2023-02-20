<div class="wrap-comment">
    <div class="form-comment">
        <form action="{{ route($settingComment['routeNameStore'], ['slug' => $data->slug, 'id' => $data->id]) }}"
            data-url="{{ route($settingComment['routeNameStore'], ['slug' => $data->slug, 'id' => $data->id]) }}"
            method="GET" name="formComment" id="formCommentAuth">
            @csrf
            <input type="hidden" value="" name="social" id="urlSocial">
            <div class="form-group">
                <textarea name="content" id="content" class="form-control" rows="3"
                    required="required"
                    placeholder="Viết bình luận của bạn"></textarea>
            </div>
            <button type="button"
                class="btn btn-primary btn-send-comment-before btn-checkLogin"
                data-check="{{ route('ajax.login.checkLoginAjax') }}">Gửi bình
                luận</button>
        </form>
    </div>
    <div class="list-comment" id="loadListComment">
        @if (isset($dataComment) && $dataComment)
            {{-- <div class="count-comment">
                Bình luận {{ $countComment }}
            </div>
            @foreach ($dataComment as $comment)
                <div class="media">
                    <div class="media-left">
                        @if ($comment->user_id&&optional($comment->user)->avatar_path)
                        <img src="{{ asset($comment->user->avatar_path) }}"
                        class="media-object"
                        style="width:60px;max-width:unset;">
                        @else
                            <img src="{{ asset($shareFrontend['userNoImage']) }}"
                                class="media-object"
                                style="width:60px;max-width:unset;">
                        @endif

                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">{{ $comment->name }}</h4>
                        <h5 class="date-comment">
                            {{ date_format($comment->created_at, 'h:i d/m/Y') }}
                        </h5>
                        <p>{!! $comment->content !!}</p>
                    </div>
                </div>
            @endforeach
            {!! $dataComment->links() !!} --}}
            @include('frontend.components.comment.load-list-comment',[
                'dataComment'=>$dataComment,
                'countComment'=>$countComment,
            ])
        @endif
    </div>
</div>
<div class="modal fade" id="modal-comment">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close-modal-comment" data-dismiss="modal"><i class="fa fa-times"
                    aria-hidden="true"></i></button>
            <div class="modal-body">
                <div role="tabpanel" class="wrap-form-comment">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active session-guest">
                            <a class="nav-link active" href="#tabGuest" aria-controls="home" role="tab" data-toggle="tab">Bình luận</a>
                        </li>
                        <li role="presentation">
                            <a class="nav-link" href="#tabLogin" aria-controls="tab" role="tab" data-toggle="tab">Đăng nhập</a>
                        </li>
                        <li role="presentation">
                            <a  class="nav-link" href="#tabRegister" aria-controls="tab" role="tab" data-toggle="tab">Đăng ký</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                            </li>
                          </ul> --}}
                        <div role="tabpanel" class="tab-pane fade show active tab-guest" id="tabGuest">
                            <form data-url="{{ route($settingComment['routeNameStore'], ['slug' => $data->slug, 'id' => $data->id]) }}"
                                method="POST" name="formComment" id="formCommentGuest">

                                @csrf
                                {{-- <input type="hidden" name="content" value="" id="contentFormGuest"> --}}
                                <div class="icon-m">
                                    <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                                </div>
                                <div class="title-m">Thông tin bạn đọc</div>
                                <div class="desc-m">
                                    Thông tin của bạn đọc sẽ được bảo mật an toàn và chỉ sử dụng trong trường hợp
                                    toà soạn cần thiết để liên lạc với bạn.
                                </div>
                                <div id="loadListErrorCommentGuest"></div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" placeholder="Tên hiển thị"
                                        required>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Email"
                                        required>
                                </div>
                                <div class="g-recaptcha"
                                    data-sitekey="{{ config('services.recaptcha.GOOGLE_RECAPTCHA_KEY') }}"></div>
                                <br />
                                <div class="text-right">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                                </div>
                                <div class="content-f">
                                    Bạn đã có tài khoản <a class="btn-tab-login">Đăng nhập</a> ngay
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tabLogin">
                            <form action="{{ route('login') }}" data-url="{{ route('login') }}" method="POST" role="form" id="formLogin">
                                <div id="loadListErrorLogin"></div>
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control" name="username" id="" placeholder="Tên đăng nhập">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" id="" placeholder="Mật khẩu">
                                </div>
                                <div class="d-flex group-dangnhap">
                                    @if (Route::has('password.request'))
                                      <a class="btn btn-link" href="{{ route('password.request') }}" target="blank">
                                         Quên mật khẩu ?
                                      </a>
                                    @endif
                                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
                                </div>
                            </form>
                            <div class="login-with">
                                <h3>Đăng nhập bằng</h3>
                                <div class="text-center">
                                    <a href="{{ route('login.social',['social'=>'google']) }}" target="_blank" class="google btn-login-social">
                                        <i class="fab fa-google"></i>
                                    </a>
                                    <a href="{{ route('login.social',['social'=>'facebook']) }}" target="_blank" class="facebook btn-login-social">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tabRegister">
                            <form data-url="{{ route('register') }}" method="POST" role="form" id="formRegister">
                                @csrf
                                <div id="loadListErrorRegister"></div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="username" id=""
                                        placeholder="Tên đăng nhập (*)">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" id=""
                                        placeholder="Họ và tên (*)">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="email" id=""
                                        placeholder="Email đăng nhập (*)">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="phone" id=""
                                        placeholder="Số điện thoại (*)">
                                </div>

                                <div class="form-group">
                                    <input type="date" class="form-control  @error('date_birth') is-invalid @enderror"
                                    value="{{ old('date_birth')}}" name="date_birth" placeholder="Ngày sinh">
                                    @error('date_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control  @error('you_become') is-invalid @enderror"
                                    value="{{ old('you_become')}}" name="you_become" placeholder="Bạn muốn trở thành (*)">
                                    @error('you_become')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <textarea class="form-control  @error('info_more') is-invalid @enderror"
                                        cols="30" rows="2" placeholder="Sở thích của bạn (*)" name="info_more"
                                        >{{ old('info_more') }}</textarea>
                                    @error('info_more')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" id=""
                                        placeholder="Mật khẩu">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password_confirmation" id=""
                                        placeholder="Xác nhận mật khẩu">
                                </div>



                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary btn-register">Đăng ký</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
