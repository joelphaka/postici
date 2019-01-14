@if (Session::has('info'))
    @if (Session::has('info_type'))
        <div class="alert alert-{{ Session::get('info_type') }}">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <span>{{ Session::get('info') }}</span>
        </div>
    @else
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <span>{{ Session::get('info') }}</span>
        </div>
    @endif
@endif