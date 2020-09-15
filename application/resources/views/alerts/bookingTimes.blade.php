@if(Session::has('booking_time_updated'))
    <div class="alert alert-success">{{session('booking_time_updated')}}</div>
@endif