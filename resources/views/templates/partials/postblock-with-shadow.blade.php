<?php $post = isset($result) ? $result : $post;?>

<li class="list-group-item flex pad-small overflow-ellipsis-all simple-box-shadow">
    <div class="content">
        <a href="#" class="block">
            <h4 class="text-bold text-inherit v-space-0">
                {{ $post->title }}
            </h4>
        </a>
        <div class="v-space-3">
            {{ $post->content }}
        </div>
        <div class="text-small text-muted">
            <span>
                @if ($post->created_at != null)

                    @if (Carbon::now()->year == $post->created_at->year &&
                         Carbon::now()->month == $post->created_at->month &&
                         Carbon::now()->day == $post->created_at->day)

                        {{ $post->created_at->diffForHumans() }}

                    @elseif (Carbon::now()->year == $post->created_at->year)

                        {{ $post->created_at->format('F d \a\t H:i') }}
                    @else

                        {{ $post->created_at->format('F d, Y \a\t H:i') }}
                    @endif
                @else

                @endif
            </span>

            @if (!$post->user()->first()->isAuthUser())
                &nbsp;&bullet;&nbsp;
                <a href="{{ route('user.profile', ['username'=> $post->user()->first()->username]) }}">
                    {{ $post->user()->first()->username }}
                </a>
            @else
                &nbsp;&bullet;&nbsp;
                <a href="#">
                    Edit
                </a>
            @endif
        </div>
        <hr class="v-space-2">
        <div class="text-medium">
            <span class="glyphicon glyphicon-thumbs-up"></span>
            @if ($post->likes()->count())
                <a href="{{ route('like.users', ['type'=>'post', 'id'=>$post->id]) }}">
                    {{ $post->likes()->count() }}
                </a>
                &nbsp;&bullet;&nbsp;
            @endif
            <a href="{{
                !$user->hasLiked($post) ?
                    route('like', ['type' => 'post', 'id' => $post->id]) :
                    route('unlike', ['type' => 'post', 'id' => $post->id])
                }}">
                @if ($user->hasLiked($post))
                    <span class="text-bold">Like</span>
                @else
                    <span>Like</span>
                @endif
            </a>
            &nbsp;&bullet;&nbsp;
            @if (false)
                <span>10</span>
            @endif
            <span class="glyphicon glyphicon-comment"></span>
            <a href="#">
                @if ($post->comments()->count())
                    Comments
                @else
                    Comment
                @endif
            </a>
        </div>
    </div>
</li>
