<?php $post = isset($result) ? $result : $post;?>

<li class="list-group-item flex pad-small overflow-ellipsis-all post-item" data-post-id="{{ $post->id }}">
    <div class="content">
        <div class="float-container">
            <img src="{{ route('user.avatar', ['username' => $post->user->username ]) . '?' . time() }}"
                 class="person-avatar pull-left img-circle"
                 alt="{{ $post->user->getName() }}"
                 <?=!$post->user->hasAvatar() ? 'style="border:1px solid darkgray"' : '' ?>>
            <div class="pull-left">
                <a href="#" class="block post-link">
                    <h5 class="text-bold text-inherit v-space-0 post-title">
                        {{ $post->title }}
                    </h5>
                </a>
                <span class="post-date text-muted block">
                    @if ($post->created_at)
                        {{ $post->created_at->diffForHumans() }}
                        &nbsp;&bullet;&nbsp;
                    @endif
                    <a href="{{ route('user.profile', ['username'=> $post->user->username]) }}">
                         {{ !$post->user->isAuthUser() ? $post->user->getName() : 'You' }}
                    </a>
                </span>
            </div>
        </div>
        <div class="v-space-8 post-content">
            @if (strlen($post->content) > 172)
                {{ substr($post->content, 0, 172) }}...
            @else
                {{ $post->content }}
            @endif
        </div>
        <div class="text-small text-muted">

        </div>
        <hr class="v-space-2">
        <div class="text-medium">
            <span class="glyphicon glyphicon-thumbs-up"></span>
            @if ($post->likes()->count())
                <a href="{{ route('like.users', ['type'=>'post', 'id' => $post->id]) }}">
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
            @if ($post->comments()->count())
                <span>{{ $post->comments()->count() }}</span>
            @endif
            <span class="glyphicon glyphicon-comment"></span>
            <a href="#">
                @if ($post->comments()->count())
                    Comments
                @else
                    Comment
                @endif
            </a>
            @if ($post->user->isAuthUser())
                &nbsp;&bullet;&nbsp;
                <span class="glyphicon glyphicon-edit"></span>
                <a href="{{ route('post.edit', [$post]) }}">Edit</a>
            @endif
        </div>
    </div>
</li>
