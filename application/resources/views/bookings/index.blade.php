@extends('layouts.admin', ['title' => __('backend.bookings')])

@section('content')

<style>

.booking-error-meessage-hidden {
    display: none
}

.booking-error-meessage-show {
    display: block
}


</style>

    <div class="page-title">
        <h3>{{ __('backend.bookings') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.bookings') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                @include('alerts.bookings')
                <div class="alert alert-danger booking-error booking-error-meessage-hidden">Fecha desde tiene que ser menor a fecha hasta</div>
                <div class="panel panel-white">
                    <div class="panel-heading clearfix" style="margin-bottom: 24px; height: 90px;" >
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.bookings') }}</h4>
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
                            <select class="form-control" id="package_id" name="package_id" onchange="onSelecPackage()">
                                <option value="">Seleccione Paquete</option>
                                @foreach($packages as $package)
                                    <option value="{{ $package->id }}" {{ $selectedPackage == $package->id ? 'selected' : '' }}>{{ $package->title }}</option>
                                @endforeach
                            </select>
                        </div> 

                        <div class="col-md-2 form-group">
                            <label class="control-label" for="date">{{ __('backend.from') }}</label>
                            <input type="date" class="form-control" id="dateStart" name="dateStart" onchange="onSelectDate()" value="{{ $selectedDateStart }}" >
                        </div>                 

                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.category') }}</th>
                                    <th>{{ __('backend.package') }}</th>
                                    <th>{{ __('backend.date') }}</th>
                                    <th>{{ __('backend.time') }}</th>
                                    <th>{{ __('backend.status') }}</th>
									
									<th>{{ __('backend.booking_username') }}</th>
									
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                    <th>{{ __('backend.players') }}</th>
									<th>{{ __('backend.locator') }}</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('backend.category') }}</th>
                                    <th>{{ __('backend.package') }}</th>
                                    <th>{{ __('backend.date') }}</th>
                                    <th>{{ __('backend.time') }}</th>
                                    <th>{{ __('backend.status') }}</th>
									
									<th>{{ __('backend.booking_username') }}</th>
									
                                    <th>{{ __('backend.created') }}</th>
                                    <th>{{ __('backend.actions') }}</th>
                                    <th>{{ __('backend.players') }}</th>
									<th>{{ __('backend.locator') }}</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->id }}</td>
                                        <td>{{ $booking->package->category->title }}</td>
                                        <td>{{ $booking->package->title }}</td>
                                        <td>{{ $booking->booking_date }}</td>
                                        <td>{{ $booking->booking_time }}</td>
                                        <td><span class="label {{ $booking->status == __('backend.cancelled') ? 'label-danger' : 'label-success' }}">{{ $booking->status }}
										 @if ($booking->booking_address != '' )
										 - Falto Confirmacion
										 @endif
										
										</span></td>
										<td>{{ $booking->user->first_name }} {{ $booking->user->last_name }}</td>
										
                                        <td>{{ $booking->created_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('bookings.show', [ 'id' => $booking->id]) }}" class="btn btn-primary btn-sm">{{ __('backend.details') }}</a>
                                        </td>
                                        
										 
										<td> {{ $booking->bookingplayerslist()	}}
											<!--
                                            <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-primary btn-sm">{{ __('backend.playerdetails') }}</a>
											LA -->
                                        </td>	
										
										<td>{{ $booking->locator }}</td>
										
										
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
            if(id == -1) {
                window.location.href = `/bookings?category=&package=`;
            } else {
                window.location.href = `/bookings?category=${id}&package=`;
            }
        }

        function onSelecPackage() {
            const URL_CONCAT = $('meta[name="index"]').attr('content');
            const id = document.getElementById("package_id").value;
            const category = document.getElementById("category_id").value;
            if(id == -1) {
                window.location.href = `/bookings?category=${category}&package=`;
            } else {
                window.location.href = `/bookings?category=${category}&package=${id}`;
            }
        }

        function onSelectDate() {
            const URL_CONCAT = $('meta[name="index"]').attr('content');
            const package = document.getElementById("package_id").value;
            const category = document.getElementById("category_id").value;
            const dateStart = document.getElementById("dateStart").value;
            console.log(`start: ${dateStart}`);
            if(dateStart !== '') {
                window.location.href = `/bookings?category=${category}&package=${package}&dateStart=${dateStart}`;
            }
        }
        
    </script>

@endsection