@foreach(['danger', 'warning', 'success', 'info'] as $msg)
    @if(session()->has($msg))
        <div class="alert-info">
            <p class="alert alert-danger-{{$msg}}">
                {{session()->get($msg)}}
            </p>
        </div>
    @endif
@endforeach