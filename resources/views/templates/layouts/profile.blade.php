<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('pageTitle')</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ url('/assets/css/bootstrap.css') }}" rel="stylesheet">

    <!-- JQuery UI CSS -->
    <link href="{{ url('/assets/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/jquery-ui/jquery-ui.structure.min.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/jquery-ui/jquery-ui.theme.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ url('/assets/css/main.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/css/styles.css') }}" rel="stylesheet">

    @yield('styles')

    <!-- Custom Fonts -->
    <link href="{{ url('/assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="{{ url('/assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('/assets/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
    @include('templates.partials.nav-profile')
    <div class="container-fluid edge" id="mainContainer">
        <div class="row">
            <div id="side-wrapper" class="col-md-3 col-sm-4 side-wrapper">
                <div class="sidebar" style="overflow-y:auto">
                    <div class="relative margin-bottom-10">
                        <!--route('user.avatar', ['username' => $user->username])-->
                        <img id="sideAvatar"
                             src="{{ route('user.avatar', ['username' => $user->username]) .'?'.time() }}"
                             alt="avatar"
                             class="avatar-p img-circle"
                             data-toggle="modal"
                             data-target="#modal04">
                        @if ($user->isAuthUser())
                            <button class="btn open-img-modal center-h" type="button" data-toggle="modal" href="#modal01" title="Change your avatar">
                                <span class="glyphicon glyphicon-picture"></span>
                            </button>
                        @endif
                    </div>
                    <h3 class="text-center margin-top-25 margin-bottom-25 overflow-ellipsis" style="color:rgb(210,210,210)">
                        {{ $user->getName() }}
                    </h3>
                    <div id="foll-stats" class="margin-top-5 margin-bottom-15">
                        <a href="{{ route('user.following', ['username' => $user->username]) }}">
                            <span class="type">Following</span>
                            <span class="count">{{ $user->acceptedFollowing()->count() }}</span>
                            <div class="indicator"></div>
                        </a>
                        <a href="{{ route('user.followers', ['username' => $user->username]) }}">
                            <span class="type">Followers</span>
                            <span class="count">{{ $user->acceptedFollowers()->count() }}</span>
                            <div class="indicator"></div>
                        </a>
                    </div>
                    <ul id="sidebar-nav" class="nav nav-pills nav-stacked crimson">
                        <li>
                            <a href="{{ route('user.profile', ['username' => $user->username]) }}" class="btn btn-primary relative">
                                <span class="glyphicon glyphicon-info-sign"></span>
                                <span>&nbsp;About</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.timeline', ['username' => $user->username]) }}" class="btn btn-primary relative">
                                <span class="glyphicon glyphicon-time"></span>
                                <span>&nbsp;Timeline</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.likes', ['username' => $user->username]) }}" class="btn btn-primary relative">
                                <span class="glyphicon glyphicon-thumbs-up"></span>
                                <span>&nbsp;Likes</span>
                            </a>
                        </li>
                        @if (!$user->isAuthUser())
                            <hr class="display-block-768" style="margin:8px 0;border:1px solid #5f6366;border-top:0">
                            @if (Auth::user()->pendingRequestExists($user))
                                @if (Auth::user()->isRequestPending($user))
                                    <li>
                                        <a href="{{ route('user.follow.delete', ['id'=> $user->id]) }}" class="btn btn-primary relative">
                                            <span class="glyphicon glyphicon-trash"></span>
                                            <span>&nbsp;Delete</span>
                                        </a>
                                    </li>
                                @elseif (Auth::user()->hasPendingRequestFrom($user))
                                    <li>
                                        <a href="{{ route('user.follow.accept', ['id'=> $user->id]) }}" class="btn btn-primary relative">
                                            <span class="glyphicon glyphicon-ok"></span>
                                            <span>&nbsp;Accept</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('user.follow.delete', ['id'=> $user->id]) }}" class="btn btn-primary relative">
                                            <span class="glyphicon glyphicon-trash"></span>
                                            <span>&nbsp;Delete</span>
                                        </a>
                                    </li>

                                @endif
                            @else
                                @if (!Auth::user()->isFollowerOf($user))
                                    <li>
                                        <a href="{{ route('user.follow', ['id'=> $user->id]) }}" class="btn btn-primary relative">
                                            <span class="glyphicon glyphicon-plus"></span>
                                            <span>&nbsp;Follow</span>
                                        </a>
                                    </li>
                                @elseif ($user->isFollowedBy(Auth::user()))
                                    <li>
                                        <a href="{{ route('user.unfollow', ['id'=> $user->id]) }}" class="btn btn-primary relative">
                                            <span class="glyphicon glyphicon-minus"></span>
                                            <span>&nbsp;Unfollow</span>
                                        </a>
                                    </li>
                                @endif
                            @endif
                        @endif
                    </ul>
                    <div class="margin-bottom-45 display-block-768"></div>
                </div>
            </div>
            <div id="profile-content" class="col-md-9 col-sm-8">
                <div class="margin-top-35"></div>
                @include('templates.partials.alerts')
                <div class="float-container profile-header">
                    <h1 class="pull-left">@yield('pageHeader')</h1>
                    @yield('extraHeader')
                </div>
                <hr>
                @yield('content')
            </div>
            <button class="sidebar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        @yield('paginator')
    </div>
    @if ($user->isAuthUser())
        <div class="modal fade custom blue" id="modal01">
            <form id="uploadForm" action="{{ route('avatar.upload') }}" method="post" enctype="multipart/form-data" class="modal-dialog" >
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal" aria-hidden="true">
                            <span>&times;</span>
                        </button>
                        <h4 class="modal-title">Your avatar</h4>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalAvatar"
                             src="{{ route('user.avatar', ['username' => $user->username]) .'?'.time() }}"
                             alt="{{ $user->getName() }}"
                             class="center-block"
                             style="max-width:100%;max-height:355px">
                        <div class="btn-group margin-top-10 margin-bottom-5">
                            <button id="btnModal02" class="btn btn-danger" type="button" data-target="#modal02" data-toggle="modal"
                                    title="Remove your avatar"
                                    style="display: {{ $user->has_avatar ? 'inline-block' : 'none' }}">
                                <span class="glyphicon glyphicon-remove-sign"></span>
                                <span>&nbsp;Remove</span>
                            </button>
                            <label for="imgfile" class="btn btn-primary file-chooser">
                                <span class="glyphicon glyphicon-file"></span>
                                <span>&nbsp;Choose</span>
                                <input type="file" name="imgfile" id="imgfile" required>
                            </label>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <div class="modal-footer relative">
                        <img src="{{ url('/assets/images/loading3.gif') }}"
                             alt="Loading"
                             class="center-v fixed-left-15 absolute"
                             id="progressIndicator"
                             style="display:none;height:32px;width:32px">
                        <button class="btn btn-default btn-cancel" type="button" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remove"></span>
                            <span>&nbsp;Close</span>
                        </button>
                        <button class="btn btn-primary" type="submit">
                            <span class="glyphicon glyphicon-upload"></span>
                            <span>&nbsp;Upload</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!--The modal used to confirm if the user really wants the avatar removed -->
        <div class="modal fade custom blue" id="modal02">
            <div class="modal-dialog">
                <form action="{{ route('avatar.delete') }}" method="post" class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Remove Avatar</h4>
                    </div>
                    <div class="modal-body">
                        Do you really want to remove your avatar?
                    </div>
                    {{ csrf_field() }}
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btnRemoveAv">Yes</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    <div class="modal fade custom blue" id="modal04">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">
                        @if (!$user->isAuthUser())
                            @if (strtolower(substr($user->firstname, -1)) == 's')
                                {{ $user->firstname . '\' avatar' }}
                            @else
                                {{ $user->firstname . '\'s avatar' }}
                            @endif
                        @else
                            Your Avatar
                        @endif
                    </h4>
                </div>
                <div class="modal-body" {{ $user->has_avatar ? 'style=background:black':'' }}>
                    <img src="{{ route('user.avatar', ['username' => $user->username]) .'?'.time() }}"
                         alt="{{ $user->getName() }}"
                         class="center-block"
                         style="max-width:100%;max-height:355px">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @include('templates.partials.footer')
    <script src="{{ url('/assets/js/bootstrap.js') }}"></script>
    <script src="{{ url('/assets/js/script.js') }}"></script>
    <script src="{{ url('/assets/js/jquery.validate.js') }}"></script>
    <script src="{{ url('/assets/js/jquery.form.js') }}"></script>
    <script src="{{ url('/assets/js/validator.js') }}"></script>
    @if ($user->isAuthUser())
        <script>
            $(function () {
                var uploadForm = $('#uploadForm');
                var upFormValidator = uploadForm.validate({
                    rules: {
                        imgfile: {
                            required: true,
                            maxFileSize: 1024, 
                            fileExtensions: ['jpeg', 'jpg', 'png']
                        }
                    },
                    messages: {
                        imgfile: {
                            required: 'Please choose an image.',
                            maxFileSize: 'The file may not be greater than 1024 kilobytes',
                            fileExtensions: 'The file must be an image of type jpeg or png.'
                        }
                    },
                    errorElement: 'div',
                    errorPlacement: function (error, element) {
                        error.addClass('text-center');
                        var parent = $(element).parents('.btn-group:first');
                        parent.nextAll('.error').remove();

                        if (parent.next('.fi').length) {
                            parent.next('.fi').nextAll('.error').remove();
                            error.insertAfter(parent.next('.fi'));
                        } else {
                            error.insertAfter(parent);
                        }
                    }
                });

                $('#imgfile').change(onFileChange);

                $('#modal01').on('hidden.bs.modal', resetUploadForm);

                $('#btnModal02').on('click', function () {
                    $('#modal01').modal('hide');
                });
                
                function resetUploadForm() {
                    upFormValidator.resetForm();
                    upFormValidator.reset();
                    upFormValidator.clean();

                    $(this).find('.file-chooser>#imgfile').remove();
                    $(this).find('.fi').remove();

                    var _fileInput = $('<input type="file" name="imgfile" id="imgfile" required>');
                    _fileInput.on('change', onFileChange);

                    $(this).find('label.file-chooser[for="imgfile"]').append(_fileInput);
                    $('#modalAvatar').attr('src', getAvatarUrl());
                }

                function onFileChange() {
                    var $this = $('#imgfile');
                    var _file = $this.get(0).files[0];

                    if (!_file) return;

                    $('#modalAvatar').removeAttr('src').attr('src', URL.createObjectURL(_file));

                    var fiParent = $this.parents('.file-chooser:first').parent();

                    if (fiParent.next('.fi').length) {
                        fiParent.next('.fi').text(_file.name).css('text-align', 'center');
                        fiParent.next('.fi').removeClass('block').addClass('block');
                    } else {
                        var nameEl = $('<span>');
                        nameEl.attr('class', 'fi');
                        nameEl.text(_file.name).css('text-align', 'center');
                        nameEl.addClass('block');
                        nameEl.insertAfter(fiParent);
                    }
                }

                function getAvatarUrl() {
                    return '{{ route('user.avatar', ['username' => $user->username]) }}?' + new Date().getTime();
                }
            })
        </script>
    @endif
    @yield('scripts')
    @include('templates.partials.api-search')
</body>

</html>