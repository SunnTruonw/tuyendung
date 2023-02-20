<div class="sidebar">
    <div class="wrap-thanhvien">
        <div class="title-thanhvien">
            Thành viên nổi bật
        </div>
        <div class="list-item-thanhvien">
            @if (isset($sidebar['userHot'])&&$sidebar['userHot'])

            @foreach ($sidebar['userHot'] as $item)

            <div class="item-thanhvien">
                <div class="box">
                    <div class="image">
                        <img src="{{ asset($item->avatar_path??$shareFrontend['userNoImage']) }}" alt="">
                    </div>
                    <div class="content">
                        <h3><a href="{{ route('profile.infoReview',['username'=>$item->username,'id'=>$item->id]) }}">{{ $item->name }}</a></h3>
                        <h4>Có {{ $item->reviews_count }} review</h4>
                        <a href="{{ route('profile.infoReview',['username'=>$item->username,'id'=>$item->id]) }}" class="xemthemtv">[ xem thêm ]</a>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
