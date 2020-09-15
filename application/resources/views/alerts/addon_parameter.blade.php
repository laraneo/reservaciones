@if(Session::has('addons_parameter_created'))
    <div class="alert alert-success">{{session('addons_parameter_created')}}</div>
@endif

@if(Session::has('addons_parameter_deleted'))
    <div class="alert alert-success">{{session('addons_parameter_deleted')}}</div>
@endif

@if(Session::has('addons_parameter_updated'))
    <div class="alert alert-success">{{session('addons_parameter_updated')}}</div>
@endif