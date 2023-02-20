<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="utf-8">
    <style>
        .content {
            font-size: 15px;
            line-height: 1.5;
        }

    </style>
</head>

<body>

    <div class="wrap-content">
        <h2>{{ $content->name }}</h2>
        <div class="content">
            <h1>Hello {{ optional($review->user)->username }}</h1>
            {!! $content->description !!}
        </div>
        <div style="text-align: center;">
            <a href="{{ route('profile.bookAgree',['code'=>$review->code]) }}" class="btn btn-success">Click vào đây để nhận sách</a>
            <a href="{{ route('profile.bookCancel',['code'=>$review->code]) }}" class="btn btn-danger">Từ chối nhận sách</a>
        </div>
    </div>
</body>

</html>
