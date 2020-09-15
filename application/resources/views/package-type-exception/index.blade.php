@extends('layouts.admin', ['title' => __('backend.packages_type_exception')])

<style>

#package-calendar {
	margin: 20px 0px 20px 0px;
    color: #2c3e50;
}

#package-calendar .cell {
	border: 1px solid #2c3e50;
}
#package-calendar .cell.active {
	background-color: #f1c40f;
}

#package-calendar .cell.active-green {
	background-color: #27ae60;
}
#package-calendar .header, .time {
	font-weight: bold;
}

#package-calendar .package-title {
	border-bottom: 0px transparent;
	border-left: 0px transparent;
	border-right: 0px transparent;
}

#package-calendar .court-title {
	border-bottom: 0px transparent;
	border-left: 0px transparent;
	border-right: 0px transparent;
}

#package-calendar .court-container {
	border: 1px solid black;
	border-top: 0px transparent;
	border-bottom: 0px transparent;
	border-bottom: 0px transparent;
}

#package-calendar .calendar-container {
	border: 1px solid black;
	border-top: 0px transparent;

}

#package-calendar .package-type-container {
	border: 1px solid black;
	border-top: 0px transparent;
	border-bottom: 0px transparent;
}

#package-calendar .package-days .cell {
	border: 0px transparent;
}


@media only screen and (max-width: 600px) {
	#package-calendar .cell {
		font-size: 9px;
		flex: 0 0 16.66666667%;
		max-width: 16.66666667%;
		padding-left: 5px;
		padding-right: 0px;
	}
}


</style>

@section('content')
    <div class="page-title">
        <h3>{{ __('backend.packages_type_exception') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.packages_type_exception') }}</li>
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
                            <h4 class="panel-title">{{ __('backend.packages_type_exception') }}</h4>
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
                        <div id="package-calendar" ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <script>

        function renderDays() {
            const html = ` 
            `
            return html;
        }

        function renderCalendar() {
			let html = `
            <div class="row calendar-container">
                <div class="col-sm-12 col-xs-12 col-md-12">
                    <div class="row header">
                        <div class="col-sm-2 col-xs-2 col-md-2 cell">Paquetes</div>
                        <div class="col-sm-10 col-xs-10 col-md-10 cell">Tipos de Paquetes</div>
                    </div>

                    <div class="row court-container court-container">

                        <div class="col-sm-2 col-xs-2 col-md-2 cell time court-title">Cancha 1 </div>

                        <div class="col-sm-5 col-xs-5 col-md-5"> 
                        
                            <div class="row package-type-container">
                            
                                <div class="col-sm-3 col-xs-3 col-md-3 cell package-title">Single</div>
                                <div class="col-sm-9 col-xs-9 col-md-9 cell">
                                    <div class="row package-days">
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">Lunes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp;</div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Martes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Miercoles </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Jueves </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Viernes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Sabado </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Domingo </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                    </div>
                                </div>
                            
                            </div>
                        
                         </div>


                        <div class="col-sm-5 col-xs-5 col-md-5"> 
                        
                            <div class="row package-type-container">
                            
                                <div class="col-sm-3 col-xs-3 col-md-3 cell package-title">Double</div>
                                <div class="col-sm-9 col-xs-9 col-md-9 cell">
                                    <div class="row package-days">
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">Lunes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp;</div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Martes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp;</div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Miercoles </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp;</div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Jueves </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp;</div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Viernes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp;</div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Sabado </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp;</div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Domingo </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp;</div>
                                    </div>
                                </div>
                            
                            </div>
                        
                         </div>
                        
                </div>


                <div class="row court-container court-container">

                        <div class="col-sm-2 col-xs-2 col-md-2 cell time court-title">Cancha 2 </div>

                        <div class="col-sm-5 col-xs-5 col-md-5"> 
                        
                            <div class="row package-type-container">
                            
                                <div class="col-sm-3 col-xs-3 col-md-3 cell package-title">Single</div>
                                <div class="col-sm-9 col-xs-9 col-md-9 cell">
                                    <div class="row package-days">
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">Lunes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp;</div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Martes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"> &nbsp;</div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Miercoles </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Jueves </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Viernes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Sabado </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Domingo </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                    </div>
                                </div>
                            
                            </div>
                        
                         </div>


                        <div class="col-sm-5 col-xs-5 col-md-5"> 
                        
                            <div class="row package-type-container">
                            
                                <div class="col-sm-3 col-xs-3 col-md-3 cell package-title">Double</div>
                                <div class="col-sm-9 col-xs-9 col-md-9 cell">
                                    <div class="row package-days">
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">Lunes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp;</div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Martes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Miercoles </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Jueves </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Viernes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Sabado </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Domingo </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                    </div>
                                </div>
                            
                            </div>
                        
                         </div>
                        
                    </div>


                    <div class="row court-container court-container">

                        <div class="col-sm-2 col-xs-2 col-md-2 cell time court-title">Cancha 3 </div>

                        <div class="col-sm-5 col-xs-5 col-md-5"> 
                        
                            <div class="row package-type-container">
                            
                                <div class="col-sm-3 col-xs-3 col-md-3 cell package-title">Single</div>
                                <div class="col-sm-9 col-xs-9 col-md-9 cell">
                                    <div class="row package-days">
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">Lunes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp;</div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Martes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"> &nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Miercoles </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Jueves </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Viernes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Sabado </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Domingo </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                    </div>
                                </div>
                            
                            </div>
                        
                         </div>


                        <div class="col-sm-5 col-xs-5 col-md-5"> 
                        
                            <div class="row package-type-container">
                            
                                <div class="col-sm-3 col-xs-3 col-md-3 cell package-title">Double</div>
                                <div class="col-sm-9 col-xs-9 col-md-9 cell">
                                    <div class="row package-days">
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">Lunes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp;</div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Martes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Miercoles </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Jueves </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Viernes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Sabado </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Domingo </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                    </div>
                                </div>
                            
                            </div>
                        
                         </div>
                        
                    </div>


                    <div class="row court-container court-container">

                        <div class="col-sm-2 col-xs-2 col-md-2 cell time court-title">Cancha 4 </div>

                        <div class="col-sm-5 col-xs-5 col-md-5"> 
                        
                            <div class="row package-type-container">
                            
                                <div class="col-sm-3 col-xs-3 col-md-3 cell package-title">Single</div>
                                <div class="col-sm-9 col-xs-9 col-md-9 cell">
                                    <div class="row package-days">
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">Lunes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp;</div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Martes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"> &nbsp;</div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Miercoles </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Jueves </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Viernes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Sabado </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Domingo </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                    </div>
                                </div>
                            
                            </div>
                        
                         </div>


                        <div class="col-sm-5 col-xs-5 col-md-5"> 
                        
                            <div class="row package-type-container">
                            
                                <div class="col-sm-3 col-xs-3 col-md-3 cell package-title">Double</div>
                                <div class="col-sm-9 col-xs-9 col-md-9 cell">
                                    <div class="row package-days">
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">Lunes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp;</div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Martes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Miercoles </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Jueves </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Viernes </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active">1:00 PM - 6:00 PM </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Sabado </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green"">Domingo </div>
                                        <div class="col-sm-6 col-xs-6 col-md-6 cell time active-green">&nbsp; </div>
                                    </div>
                                </div>
                            
                            </div>
                        
                         </div>
                        
                    </div>

                    
                   
                </div>
            </div>
			`;
            document.getElementById('package-calendar').innerHTML = html;
	
		}

renderCalendar();


        
    
    </script>

@endsection