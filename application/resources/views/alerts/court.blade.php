@if(Session::has('court_created'))
    <div class="alert alert-success">{{session('court_created')}}</div>
@endif

@if(Session::has('court_deleted'))
    <div class="alert alert-success">{{session('court_deleted')}}</div>
@endif

@if(Session::has('court_updated'))
    <div class="alert alert-success">{{session('court_updated')}}</div>
@endif