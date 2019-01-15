<nav id="navbar" class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header relative">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            @if (Auth::check())
                <form action="{{ route('search.index') }}" class="search-control">
                    <div class="form-group">
                        <input type="text" class="form-control" id="q0" name="q" placeholder="Search" value="{{ request()->query('q') }}">
                    </div>
                    <button class="btn btn-primary" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </form>
            @endif
            <a href="/" class="navbar-brand profile">PI</a>
        </div>
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            @if (Auth::check())
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li>
                        <a href="{{ route('user.profile', ['username'=>Auth::user()->username]) }}">Profile</a>
                    </li>
                </ul>
            @endif
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    <li id="accDropdown" class="dropdown">
                        <a href="#" class="dropdown-toggle simple" data-toggle="dropdown">
                        <span class="text-bold">
                            {{ Auth::user()->firstname[0] .', ' . Auth::user()->lastname}}
                        </span>
                            <b class="caret"></b>
                        </a>
                        <div class="dropdown-toggle pretty" data-toggle="dropdown">
                            <img id="navAvatar"
                                 src="{{ route('user.avatar', ['username'=> Auth::user()->username]) .'?'. time() }}"
                                 alt="{{ Auth::user()->getName() }}">                            <b class="caret"></b>
                        </div>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header">{{ Auth::user()->getName() }}</li>
                            <li>
                                <a href="{{ route('account.index') }}">
                                    <span class="glyphicon glyphicon-user"></span>
                                    <span>&nbsp;Account</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('auth.logout') }}">
                                    <span class="glyphicon glyphicon-log-out"></span>
                                    <span>&nbsp;Logout</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ route('auth.signin') }}">
                            <span class="glyphicon glyphicon-user"></span>
                            <span>&nbsp;Login</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('auth.signup') }}">
                            <span class="glyphicon glyphicon-edit"></span>
                            <span>&nbsp;Register</span>
                        </a>
                    </li>
                @endif
            </ul>
            @if (Auth::check() && stripos(request()->path(), 'search') !== 0)
                <form action="{{ route('search.index') }}" class="navbar-form navbar-right" role="search" id="nav-form">
                    <div class="search-control">
                        <div class="form-group" style="margin-right:-7px">
                            <input type="text" class="form-control" id="q1" name="q" placeholder="Search" value="{{ request()->query('q') }}" style="height:30px">
                        </div>
                        <button class="btn btn-primary" type="submit" style="margin-left:-4px;height:30px;padding:6px 9px;font-size:12px">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
    <script>
        $(function () {
            $('form[role=search]').submit(function () {
                var q = $(this).find('#q').val().toString().trim();

                return Boolean(q);
            });
        })
    </script>
</nav>

