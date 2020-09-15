@extends('layouts.admin', ['title' => __('backend.courts_manage')])

@section('content')

    <div class="page-title">
        <h3>{{ __('backend.courts_manage') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.courts') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.court')
                <a class="btn btn-primary btn-lg btn-add" href="{{ route('court.create') }}"><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('backend.court_add') }}</a>
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title">{{ __('backend.courts_manage') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
									<th>#</th>
									<th>{{ __('backend.name') }}</th>
									<th>{{ __('backend.package') }}</th>
									<th>{{ __('backend.is_active') }}</th>
									<th>{{ __('backend.actions') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
									<th>#</th>
									<th>{{ __('backend.name') }}</th>
                                    <th>{{ __('backend.package') }}</th>
									<th>{{ __('backend.is_active') }}</th>
									<th>{{ __('backend.actions') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    @foreach($courts as $element)
                                        <tr>
                                            <td>{{ $element->id }}</td>
                                            <td>{{ $element->title }}</td>
                                            <td>{{ $element->package ? $element->package()->first()->title: '' }}</td>
                                            <td>
                                                @if($element->is_active)
                                                    <span class="label label-success" style="font-size:12px;">{{ __('backend.active') }}</span>
                                                @else
                                                    <span class="label label-danger" style="font-size:12px;">{{ __('backend.blocked') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('court.edit', $element->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $element->id }}"><i class="fa fa-trash-o"></i></a>

                                                    <!-- Event Delete Modal -->
                                                    <div id="{{ $element->id }}" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
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
                                                                <form method="post" action="{{ route('court.destroy', $element->id) }}">
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

@endsection

