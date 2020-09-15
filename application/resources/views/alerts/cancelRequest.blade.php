@if(Session::has('cancel_request_deleted'))
    <div class="alert alert-success">{{session('cancel_request_deleted')}}</div>
@endif

@if(Session::has('cancel_request_updated'))
    <div class="alert alert-success">{{session('cancel_request_updated')}}</div>
@endif