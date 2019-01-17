@extends('templates.layouts.default')

@section('content')
    @include('templates.partials.alerts')
    <div class="margin-top-25"></div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">
            <div class="float-container">
                <h2 class="pull-left v-space-0">
                    Recent posts
                </h2>
                <button class="btn btn-default pull-right toggleable-rev" data-toggle="modal" data-target="#modal05">
                    Create Post
                </button>
                <a href="{{ route('post.create') }}" class="btn btn-default pull-right toggleable">
                    Create Post
                </a>
            </div>
            <hr class="margin-bottom-30">
            @if ($posts->count())
                <ul class="list-group space-items">
                    @foreach ($posts as $post)
                        @include ('templates.partials.postblock')
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    @if ($posts->count())
        <div class="margin-top-40"></div>
        {!! $posts->render() !!}
    @endif ($posts->count())
@endsection

@section('modals')
    <div id="modal05" class="modal fade custom blue">
        <div class="modal-dialog">
            <form id="form104" action="{{ route('post.store') }}" method="post" class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Create Post</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" value="" placeholder="Title">
                    </div>
                    <div class="form-group">
                        <label for="body">Write something</label>
                        <textarea name="content" id="body" class="form-control" rows="7" placeholder="Write something..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="is_public">
                            <input type="checkbox" class="checkbox-inline" name="is_public" id="is_public">
                            <span>Public</span>
                        </label>
                    </div>
                </div>
                {{ csrf_field() }}
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ url('/assets/js/jquery.validate.js') }}"></script>
    <script src="{{ url('/assets/js/validator.js') }}"></script>
    <script>
        $(function () {
            var f104Validator = $('#form104').validate(validator({
                rules: {
                    title: {required: true, notEmpty: true, minlength: 6, maxlength: 64},
                    content: {required: true, notEmpty: true, minlength: 6},
                }
            }));

            $('#modal05').on('hidden.bs.modal', function () {
                f104Validator.resetForm();
                f104Validator.reset();
                f104Validator.clean();
            })
        });
    </script>
@endSection