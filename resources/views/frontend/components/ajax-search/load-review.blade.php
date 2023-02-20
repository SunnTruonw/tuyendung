@if (isset($data)&&$data)
<div class="row">
    @foreach ($data as $review)
    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
        <div class="card-item-main">
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
                        <li class="comment"><i class="fas fa-comment-dots"></i>{{ $review->comments()->count() }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="text-center">
    @if (count($data))
    {{$data->links()}}
    @endif
</div>
@endif
