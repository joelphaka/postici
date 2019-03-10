@extends('templates.layouts.simple')

@section('pageTitle')
    Edit post
@endSection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @include('templates.partials.alerts')
        </div>
    </div>
    <div class="margin-top-30"></div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ route('post.update', [$post]) }}" method="POST" class="panel panel-primary">
                <div class="panel-heading custom-blue">
                    Edit Post
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title"
                               value="{{ request()->has('title') ? old('title') : $post->title }}"
                               placeholder="Title">
                        @if ($errors->has('title'))
                            <div class="margin-top-5"></div>
                            <span class="help-block error" style="margin-bottom:2px">
                                {{ $errors->first('title') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="content">Write something</label>
                        <textarea name="content" id="content" class="form-control" rows="7" placeholder="Write something...">{{ $post->content }}</textarea>
                        @if ($errors->has('content'))
                            <div class="margin-top-5"></div>
                            <span class="help-block error" style="margin-bottom:2px">
                                {{ $errors->first('content') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="is_public">
                            <?php $is_public = ''?>
                            <input type="checkbox" class="checkbox-inline" name="is_public" id="is_public" {{ (old('is_public') || $post->is_public ) ? 'checked' : '' }} >
                            <span>Public</span>
                        </label>
                    </div>
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <input type="hidden" name="id" value="{{ $post->id }}">
                </div>
                <div class="panel-footer float-container">
                    <div class="pull-right">
                        <button type="button"
                                class="btn btn-danger"
                                data-target="#modal06"
                                data-toggle="modal">
                            Delete
                        </button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
            @if (parse_url(request()->url())['path'] != parse_url(url()->previous())['path'])
                <a href="{{ url()->previous() }}" class="btn center-block text-center" style="width:74px">
                    <span class="glyphicon glyphicon-arrow-left"></span>
                    <span>Back</span>
                </a>
            @endif
        </div>
    </div>
@endSection

@section('modals')
    <div class="modal fade custom blue" id="modal06">
        <div class="modal-dialog">
            <form action="{{ route('post.destroy', [$post]) }}" method="post" class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Delete Post</h4>
                </div>
                <div class="modal-body">
                    Do you really want to delete this post?
                </div>
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </form>
        </div>
    </div>
@endsection()

@section('scripts')
    <script src="{{ url('/assets/js/jquery.validate.js') }}"></script>
    <script src="{{ url('/assets/js/validator.js') }}"></script>
    <script>
        $(function () {
            $('#form104').validate(validator({
                rules: {
                    title: {required: true, notEmpty: true, minlength: 6, maxlength: 64},
                    content: {required: true, notEmpty: true, minlength: 6},
                }
            }));
        });
    </script>
@endsection