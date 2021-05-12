
<footer class="footer">
    <div class="footer-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-xs-12 content-box">
                    <div class="footer-layer">
                        <div class="title-footer">
                            {{ $footer['dataAddress']->value }}
                        </div>
                        <ul class="address_footer">
                            @foreach ($footer['dataAddress']->childs as $item)
                                <li><strong>{{ $item->name }}</strong> {{ $item->value }}</li>
                            @endforeach

                        </ul>
                    </div>
                </div>

                @foreach ($footer['linkFooter'] as $item)
                <div class="col-lg-2 col-md-6 col-sm-12 content-box">
                    <div class="footer__other">
                        <div class="title-footer">
                            <span>   {{ $item->name }} </span>
                        </div>
                        <div class="footer__policy">
                            @foreach ($item->childs as $item2)
                                 <a href="{{ $item2->slug }}"> {{ $item2->name }}</a>
                             @endforeach
                        </div>
                    </div>
                </div>
                @endforeach


                <div class="col-lg-4 col-md-6 col-sm-12 content-box">
                    <div class="footer__other">
                        <div class="title-footer">
                            <span>  {{ $footer['registerSale']->name }}</span>
                        </div>
                        <div class="desc-footer">
                            {{ $footer['registerSale']->value }}
                        </div>

                        <div class="box-form-2">
                            <form action="index.php?act=newsletter" method="post" name="frmnewsletter" id="frmnewsletter" onsubmit="return validate('Vui lòng nhập email của bạn.');">
                                <div class="form-group">
                                    <input type="text" name="txtemail" class="form-control" placeholder="Nhập địa chỉ email">
                                </div>
                                <button type="submit" class="btn btn-primary">Đăng ký ngay</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="footer-top">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-xs-12">
                            <div class="list-pay-footer">
                                <div class="title-footer">
                                   {{ $footer['pay']->value }}
                                </div>
                                <div class="image">
                                    <a href="{{ $footer['pay']->slug }}">
                                        <img src="{{ $footer['pay']->image_path }}" alt="{{ $footer['pay']->name }}">
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="box-social-footer">
                                <div class="title-footer">
                                    Kết nối với chúng tôi
                                </div>
                                <div class="social-footer">
                                    <ul>
                                        @foreach($header["socialParent"]->childs as $social )
                                        <li class=""><a href="{{ $social->slug }}">{!! $social->value  !!} </a></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="cpy">
                        <p class="text-xs-center">
                            {{ $footer['coppy_right']->value }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>






