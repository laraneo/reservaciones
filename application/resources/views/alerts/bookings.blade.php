@if(Session::has('booking_updated'))
    <div class="alert alert-success">{{session('booking_updated')}}</div>
@endif

@if(Session::has('booking_deleted'))
    <div class="alert alert-danger">{{session('booking_deleted')}}</div>
@endif

@if(Session::has('booking_cancelled'))
    <div class="alert alert-danger">{{session('booking_cancelled')}}</div>
@endif