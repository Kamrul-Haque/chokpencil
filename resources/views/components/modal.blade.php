<div class="modal fade" id="{{ $id ?? '' }}">
    <div class="modal-dialog">
        <div class="modal-content">
            @if( isset($title) )
                <div class="modal-header">
                    <p class="modal-title">{{ $title }}</p>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            @endif

            <div class="modal-body @if($type) text-{{ $type }} @endif font-weight-bold">
                <h4>{{ $slot }}</h4>
            </div>

            @if( isset($action) )
                <div class="modal-footer">
                    <button type="button" class="btn custom btn-primary btn-sm" data-dismiss="modal">Cancel</button>
                    <form {{ $action }} method="post">
                        @isset($method)
                        @method($method)
                        @endisset
                        @csrf
                        <button type="submit" class="btn custom btn-danger btn-sm">Confirm</button>
                    </form>
                </div>
            @else
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary custom btn-sm" data-dismiss="modal">OK</button>
                </div>
            @endif
        </div>
    </div>
</div>
