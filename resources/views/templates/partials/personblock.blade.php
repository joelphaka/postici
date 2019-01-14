<?php $person = isset($result) ? $result : $person;?>

<li class="list-group-item person-item">
    <a class="person-avatar" href="{{ route('user.profile', ['username'=>$person->username]) }}">
        <img src="{{ route('user.avatar', ['username'=>$person->username]). '?' . time() }}" alt="{{ $person->getName() }}">
    </a>
    <div class="content relative">
        <a class="p-link block person-name" href="{{ route('user.profile', ['username'=>$person->username]) }}">
            <span>{{ $person->getName() }}</span>
        </a>
        @if ($person->country)
            <a href="#" class="p-link block person-country text-muted">
                <span class="glyphicon glyphicon-map-marker"></span>
                <span>{{ $person->country->name }}</span>
            </a>
        @endif
        @if (!$person->isAuthUser())
            @if (Auth::user()->pendingRequestExists($person))
                @if (Auth::user()->isRequestPending($person))
                    <a href="{{ route('user.follow.delete', ['id'=> $person->id]) }}" class="btn btn-primary btn-xs center-v absolute fixed-right-15 request-action">
                        <span class="action-text">Delete</span>
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                @elseif (Auth::user()->hasPendingRequestFrom($person))
                    <div class="btn-group-xs center-v absolute fixed-right-10">
                        <a href="{{ route('user.follow.accept', ['id'=> $person->id]) }}" class="btn btn-primary request-action">
                            <span class="action-text">Accept</span>
                            <span class="glyphicon glyphicon-ok"></span>
                        </a>
                        <a href="{{ route('user.follow.delete', ['id'=> $person->id]) }}" class="btn btn-primary request-action">
                            <span class="action-text">Delete</span>
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </div>
                @endif
            @else
                @if (!Auth::user()->isFollowerOf($person))
                    <a href="{{ route('user.follow', ['id'=> $person->id]) }}" class="btn btn-primary btn-xs center-v absolute fixed-right-10">
                        Follow
                    </a>
                @elseif ($person->isFollowedBy(Auth::user()))
                    <a href="{{ route('user.unfollow', ['id'=> $person->id]) }}" class="btn btn-primary btn-xs center-v absolute fixed-right-10">
                        Unfollow
                    </a>
                @endif
            @endif
        @endif
    </div>
</li>