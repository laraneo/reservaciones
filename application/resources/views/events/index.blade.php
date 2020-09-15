@extends('layouts.admin', ['title' => __('backend.all_events')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.all_events') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.events') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.events')
                <a class="btn btn-primary btn-lg btn-add" href="{{ route('events.create') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('backend.add_new_event') }}</a>
                <div class="panel panel-white">
                
                    <div class="panel-heading clearfix" style="margin-bottom: 24px; height: 90px;">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.all_events') }}</h4>
                        </div>

                        <div class="col-md-4 form-group" style="margin-top: 20px;">
                            <select class="form-control" id="type" name="type" onchange="onSelecType()">
                                <option value="">Seleccione Tipo</option>
                                <option value="0" {{ $selectedType !== null && $selectedType == 0 ? 'selected' : '' }} >{{ __('backend.reservation') }}</option>
                                <option value="2" {{ $selectedType !== null && $selectedType == 2 ? 'selected' : '' }} >{{ __('backend.draw') }}</option>
                            </select>
                        </div> 

                        <div class="col-md-4 form-group" style="margin-top: 20px;">
                            <select class="form-control" id="category_id" name="category_id" onchange="onSelecCategory()">
                                <option value="">Seleccione Categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div> 

                        <div class="col-md-4 form-group" style="margin-top: 20px;">
                            <select class="form-control" id="internal" name="internal" onchange="onSelecInternal()">
                                <option value="">{{ __('backend.select_use') }}</option>
                                <option value="0" {{ $selectedInternal !== null && $selectedInternal == 0 ? 'selected' : '' }} >{{ __('backend.general_use') }}</option>
                                <option value="1" {{ $selectedInternal !== null && $selectedInternal == 1 ? 'selected' : '' }} >{{ __('backend.internal_use') }}</option>
                            </select>
                        </div>  
                    
                        
                </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
									<th>{{ __('backend.idevent') }}</th>
									<th>{{ __('backend.date') }}</th>
									<th>{{ __('backend.time1') }}</th>
									<th>{{ __('backend.time2') }}</th>
									<th>{{ __('backend.description') }}</th>
									<th>{{ __('backend.type') }}</th>
									<th>{{ __('backend.category') }}</th>
                                    <th>{{ __('backend.drawtime1') }}</th>
									<th>{{ __('backend.drawtime2') }}</th>
									<th>{{ __('backend.is_active') }}</th>
									<th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
									<th>{{ __('backend.idevent') }}</th>
									<th>{{ __('backend.date') }}</th>
									<th>{{ __('backend.time1') }}</th>
									<th>{{ __('backend.time2') }}</th>
									<th>{{ __('backend.description') }}</th>
									<th>{{ __('backend.type') }}</th>
                                    <th>{{ __('backend.category') }}</th>
									<th>{{ __('backend.drawtime1') }}</th>
									<th>{{ __('backend.drawtime2') }}</th>
									<th>{{ __('backend.is_active') }}</th>
									<th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($events as $event)
                                        <tr>
                                            <td>{{ $event->id }}</td>
                                            <td>{{ $event->date }}</td>
                                            <td>{{ $event->getH1() }}</td>
                                            <td>{{ $event->getH2() }}</td>
                                            <td>{{ $event->description }}</td>
                                            <td style="color: {{ $event->internal == 1 ? 'red; font-weight: bold;' : 'black' }}" >{{ $event->event_type == 2 ? 'Sorteo' : 'Evento' }}</td>
                                            <td>{{ $event->category ? $event->category()->first()->title : '' }}</td>
                                            <td>
                                                @if($event->event_type == 2)
                                                    {{ \Carbon\Carbon::parse($event->drawtime1)->format('Y-m-d') }} <br> {{ \Carbon\Carbon::parse($event->drawtime1)->format('H:i:s A')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($event->event_type == 2)
                                                    {{ \Carbon\Carbon::parse($event->drawtime2)->format('Y-m-d') }} <br> {{ \Carbon\Carbon::parse($event->drawtime2)->format('H:i:s A')}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($event->is_active)
                                                    <span class="label label-success" style="font-size:12px;">{{ __('backend.active') }}</span>
                                                @else
                                                    <span class="label label-danger" style="font-size:12px;">{{ __('backend.blocked') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $event->id }}"><i class="fa fa-trash-o"></i></a>

                                                    <!-- Event Delete Modal -->
                                                    <div id="{{ $event->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>{{ __('backend.delete_event_message') }}</p>
                                                                </div>
                                                                <form method="post" action="{{ route('events.destroy', $event->id) }}">
                                                                    <div class="modal-footer">
                                                                        {{csrf_field()}}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit" class="btn btn-danger">{{ __('backend.delete_btn') }}</button>
                                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('backend.no') }}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>    
    
    function onSelecType() {
        const URL_CONCAT = $('meta[name="index"]').attr('content');
        const id = document.getElementById("type").value;
        const category = document.getElementById("category_id").value;
        const internal = document.getElementById("internal").value;
        if(id == -1) {
            window.location.href = `/events?type=&category=${category}&internal=${internal}`;
        } else {
            window.location.href = `/events?type=${id}&category=${category}&internal=${internal}`;
        }
    }

    function onSelecCategory() {
        const URL_CONCAT = $('meta[name="index"]').attr('content');
        const type = document.getElementById("type").value;
        const id = document.getElementById("category_id").value;
        const internal = document.getElementById("internal").value;
        if(id > 0) {
            window.location.href = `/events?type=${type}&category=${id}&internal=${internal}`;
        } else {
            window.location.href = `/events?type=${type}&category=&internal=${internal}`;
        }
    }

    function onSelecInternal() {
        const URL_CONCAT = $('meta[name="index"]').attr('content');
        const type = document.getElementById("type").value;
        const category = document.getElementById("category_id").value;
        const id = document.getElementById("internal").value;
        if(id == -1) {
            window.location.href = `/events?type=${type}&category=${category}&internal=`;
        } else {
             window.location.href = `/events?type=${type}&category=${category}&internal=${id}`
        }
    }
    
</script>

@endsection

