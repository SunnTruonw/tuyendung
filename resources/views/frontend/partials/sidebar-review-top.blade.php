<div class="side-bar">
    <div class="title-b">
        <span> Top review trong tuần</span>
    </div>
    <div class="list-review-sb">
        @if (isset($sidebar['listViewWeek'])&&$sidebar['listViewWeek'])
        @foreach ($sidebar['listViewWeek'] as $review)
        <div class="col-card-news-horizontal">
            <div class="card-news-horizontal-2">
                <div class="box">
                    <div class="image">
                        <a href="{{ route('review.detail',['id'=>$review->id,'slug'=>$review->slug]) }}">
                            <img src="{{ asset($review->avatar_path) }}"   alt="{{ $review->name }}">
                        </a>
                    </div>
                    <div class="content">
                        <h3><a href="{{ route('review.detail',['id'=>$review->id,'slug'=>$review->slug]) }}">{{ $review->name }}</a>
                        </h3>
                        <ul class="list-info-post">
                            <li class="date">
                                <i class="fa fa-calendar"></i>{{ date_format($review->created_at,'d/m/Y') }}</li>
                            <li class="view"><i class="fas fa-eye"></i>{{ number_format($review->view) }}</li>
                            <li class="comment"><i class="fas fa-comment-dots"></i>{{ optional($review->comments)->count() }}
                            </li>
                        </ul>
                        <div class="desc">
                            {{ $review->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
<div class="side-bar">
    <div class="title-b">
        <span> Top review trong tháng </span>
    </div>
    <div class="list-review-sb">
        @if (isset($sidebar['listViewMonth'])&&$sidebar['listViewMonth'])
        @foreach ($sidebar['listViewMonth'] as $review)
        <div class="col-card-news-horizontal">
            <div class="card-news-horizontal-2">
                <div class="box">
                    <div class="image">
                        <a href="{{ route('review.detail',['id'=>$review->id,'slug'=>$review->slug]) }}">
                            <img src="{{ asset($review->avatar_path) }}"   alt="{{ $review->name }}">
                        </a>
                    </div>
                    <div class="content">
                        <h3><a href="{{ route('review.detail',['id'=>$review->id,'slug'=>$review->slug]) }}">{{ $review->name }}</a>
                        </h3>
                        <ul class="list-info-post">
                            <li class="date">
                                <i class="fa fa-calendar"></i>{{ date_format($review->created_at,'d/m/Y') }}</li>
                            <li class="view"><i class="fas fa-eye"></i>{{ number_format($review->view) }}</li>
                            <li class="comment"><i class="fas fa-comment-dots"></i>{{ optional($review->comments)->count() }}
                            </li>
                        </ul>
                        <div class="desc">
                            {{ $review->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
