@extends('templates.layouts.simple')

@section('content')
    <div class="margin-top-30"></div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ route('post.store') }}" method="post" id="form07" class="panel panel-primary">
                <div class="panel-heading custom-blue">
                    Create Post
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" placeholder="Title">
                        @if ($errors->has('title'))
                            <div class="margin-top-5"></div>
                            <span class="help-block error" style="margin-bottom:2px">
                                {{ $errors->first('title') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="content">Write something</label>
                        <textarea name="content" id="content" class="form-control" rows="7" placeholder="Write something...">{{ old('content') }}</textarea>
                        @if ($errors->has('content'))
                            <div class="margin-top-5"></div>
                            <span class="help-block error" style="margin-bottom:2px">
                                {{ $errors->first('content') }}
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="is_public">
                            <input type="checkbox" class="checkbox-inline" name="is_public" id="is_public" {{ old('is_public') ? 'checked' : '' }} >
                            <span>Public</span>
                        </label>
                    </div>
                    {{ csrf_field() }}
                </div>
                <div class="panel-footer float-container">
                    <div class="pull-right">
                        <a href="{{ route('home') }}" class="btn btn-default">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endSection
@section('scripts')
    <script src="{{ url('/assets/js/jquery.validate.js') }}"></script>
    <script src="{{ url('/assets/js/validator.js') }}"></script>
    <script>
        $(function () {
            $('#form07').validate(validator({
                rules: {
                    title: {required: true, notEmpty: true, minlength: 6, maxlength: 64},
                    content: {required: true, notEmpty: true, minlength: 6},
                }
            }));
        })
    </script>
@endsection