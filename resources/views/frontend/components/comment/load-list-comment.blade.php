@if (isset($dataComment)&&$dataComment)
<div class="count-comment">
    Bình luận  {{ $countComment }}
</div>

@foreach ($dataComment as $comment)
<div class="media border p-3">
    @php
        if (optional($comment->user)->avatar_path) {
           $avatar=optional($comment->user)->avatar_path;
        }else{
            $avatar=$shareFrontend['userNoImage'];
        }
    @endphp
    <img src="{{ asset($avatar) }}" alt="{{ $comment->name  }}" class="mr-3  rounded-circle" style="width:60px;">
    <div class="media-body">
      <h4>{{ $comment->name }}
        {{-- <small><i>Posted on February 19, 2016</i></small> --}}
      </h4>
      <h5 class="date-comment">{{ date_format($comment->created_at,'h:i d/m/Y') }}</h5>
      <p>{!! $comment->content !!}</p>
    </div>
  </div>
    {{-- <div class="media">
        <div class="media-left">
            @if ($comment->user_id)
                {{ optional($comment->user)->avatar_path?asset(optional($comment->user)->avatar_path):asset($shareFrontend['userNoImage']) }}
            @else
            <img src="{{ asset($shareFrontend['userNoImage']) }}" class="media-object" style="width:60px;max-width:unset;">
            @endif

        </div>
        <div class="media-body">
            <h4 class="media-heading">{{ $comment->name }}</h4>
            <h5 class="date-comment">{{ date_format($comment->created_at,'h:i d/m/Y') }}</h5>
            <p>{!! $comment->content !!}</p>
        </div>
    </div> --}}
@endforeach
{!! $dataComment->links() !!}
@endif

