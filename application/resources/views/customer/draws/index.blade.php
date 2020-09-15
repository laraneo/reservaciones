@extends('layouts.customer', ['title' => __('backend.draws')])

@section('content')
    <div class="page-title">
        <h3>{{ __('backend.draws') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.draws') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.bookings')
                <div class="panel panel-white">
                    <div class="panel-heading clearfix" style="margin-bottom: 24px; height: 90px;">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.draws') }}</h4>
                        </div>
                        <div class="col-md-4 form-group" style="margin-top: 20px;">
                            <select class="form-control" id="category_id" name="category_id" onchange="onSelecCategory()">
                                    <option value="">Seleccione Categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.reservation') }}</th>
                                    <th>{{ __('backend.package') }}</th>
                                    <th>{{ __('backend.category') }}</th>
                                    <th>{{ __('backend.date') }}</th>
                                    <th>{{ __('backend.time') }}</th>
                                    <th>{{ __('backend.priority') }}</th>
									<th>{{ __('backend.locator') }}</th>
                                    <th>{{ __('backend.result') }}</th>
                                    <th>{{ __('backend.status') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.reservation') }}</th>
                                    <th>{{ __('backend.package') }}</th>
                                    <th>{{ __('backend.category') }}</th>
                                    <th>{{ __('backend.date') }}</th>
                                    <th>{{ __('backend.time') }}</th>
                                    <th>{{ __('backend.priority') }}</th>
									<th>{{ __('backend.locator') }}</th>
									<th>{{ __('backend.result') }}</th>
                                    <th>{{ __('backend.status') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($draws as $draw)
                                    <tr>
                                        <td>{{ $draw->id }}</td>
                                        <td>{{ $draw->evento }}</td>
                                        <td>{{ $draw->package }}</td>
                                        <td>{{ $draw->categoria }}</td>
                                        <td>{{ $draw->draw_date }}</td>
                                        <td>{{ $draw->draw_time }}</td>
                                        <td>{{ $draw->priority }}</td>
                                        <td>
											{{ $draw->locator }}
										</td>
                                        <td>
											{{ $draw->booking_id !== NULL || $draw->booking_id == "0" ? 'Adjudicado' : '' }}
										</td>
                                        <td>
                                            <span class="label {{ $draw->status == __('backend.cancelled') ? 'label-danger' : 'label-success' }}">
                                                {{ $draw->status }}
                                            </span>
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
    
        function onSelecCategory() {
            const URL_CONCAT = $('meta[name="index"]').attr('content');
            const id = document.getElementById("category_id").value;
            if(id > 0) {
                window.location.href = `/customer/draws?category=${id}`;
            }
            
        }
    
    </script>

@endsection