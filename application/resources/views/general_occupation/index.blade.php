@extends('layouts.admin', ['title' => __('backend.general_occupation')])

@section('content')

<style>

#packages-calendar {
	margin: 20px 0px 20px 0px;
}

#packages-calendar .cell {
	border: 1px solid #2c3e50;
}
#packages-calendar .cell.active {
	background-color: #27ae60;
}

#packages-calendar .cell.blocked {
	background-color: #e74c3c;
}

#packages-calendar .cell.expired {
	background-color: #7f8c8d;
}

#packages-calendar .cell.event {
	background-color: #f1c40f;
}

#packages-calendar .header, .time {
	font-weight: bold;
}

#packages-calendar .cell.header.active-header {
    border-top: 5px solid #3498db;
    border-left: 5px solid #3498db;
    border-right: 5px solid #3498db;
}

#packages-calendar .cell.body.active-body {
    border-left: 5px solid #3498db;
    border-right: 5px solid #3498db;
}

.custom-table {
    table-layout: fixed;
    border-collapse: collapse;
    width: 100%;
}

.custom-table tbody{
  display:block;
  width:100%;
}

.custom-table tbody::-webkit-scrollbar {
  display: none;
  overflow: hidden;
}

.custom-table thead {
    font-weight: bold;
}

.custom-table thead tr{
  display:block;
}

.custom-table th, .custom-table td {
  padding: 5px;
  width: 168px;
}

@media only screen and (max-width: 600px) {

    .custom-table th, .custom-table td {
        padding: 1px;
        width: 82px;
        font-size: 75%;
        text-align: center;
    }

    #packages-calendar .header .init-default {
        width: 108px;
    }

	//**#packages-calendar .cell {
		font-size: 9px;
		flex: 0 0 16.66666667%;
		max-width: 16.66666667%;
		padding-left: 5px;
		padding-right: 0px;
	} **/
}


</style>

    <div class="page-title">
        <h3>{{ __('backend.general_occupation') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.general_occupation') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                
                    <div class="panel-heading clearfix" style="margin-bottom: 24px; height: 90px;">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.general_occupation') }}</h4>
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
                        <div class="row">
                            <div class="col-md-12" id="select-days"></div>
                            <div class="col-md-12" id="packages-by-type"></div>
                            <div class="col-md-12" id="packages-calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>    

        function renderStatus(data) {
            if(data.expired) return 'expired';
            if(data.blocked) return 'blocked';
            if(data.event) return 'event';
            if(!data.available) return 'active';
        }


        function renderSchedule(data) {
            let html = '';
			data.forEach(element => {
				html +=`<td class="cell ${renderStatus(element)} body calendar-package-${element.id}" calendar-package="${element.id}" >&nbsp;</td>`;
			});
            return html;
        }

        function renderCalendarHeader(packages) {
            let html = '';
			packages.forEach(element => {
				html +=`<td class="cell header calendar-package-${element.id}" onclick="handlePackageCalendar(${element.id})" style="cursor:pointer;" >${element.title}</td>`;
			})
            return html;
        }

		function handleSelectDay(category) {
            let date = document.getElementById("tennis-time").value;
			var URL_CONCAT = $('meta[name="index"]').attr('content');
            if(date !== '') {
                let number = moment(date).weekday();
                if(number == 0) number = number + 1;
                $.ajax({
                type: 'GET',
                url: '/booking-category-calendar',
                data: { 
                    date : moment(date).format('DD-MM-YYYY'),
                    number : number,
                    category : category,
                },
                    beforeSend: function() {
                        $('#packages_loader').removeClass('d-none');
                        $('#packages-calendar').empty();
                    },
                    success: function(response) {
                        const packages = response.packages;
                        const schedule = response.schedule;
                        let html = '';
                        const header = `
                            <tr class="header">
                                <td class="cell init-default" ></td>
                                ${renderCalendarHeader(packages)}
                            </tr>`;

                        let content = '';
                        
                        schedule.forEach(element => {
                            content += `
                                <tr>
                                    <td class="cell time" >${moment(element.hour, 'hh:mm A').format('hh:mm A')}</td>
                                    ${renderSchedule(element.packages)}
                                </tr>
                            `;
                        } );

                        html += `
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 col-md-12">
                                <table class="custom-table" >
                                    <thead>${header}</thead>
                                    <tbody>${content}  </tbody>
                                </table>   
                            </div>
                        </div>
                        `;
                        $('#packages-calendar').fadeIn().html(html);
                        $('#packages_loader').addClass('d-none');
                    },
                });
            }
			
		}


    function renderDates(dates) {
        let html = '';
        html +=`<option value="" selected >Seleccione Dia</option>`;
        dates.forEach(element => {
            html +=`<option value="${element.date.date}">${moment(element.date.date).format('DD-MM-YYYY')}</option>`;
        })
        return html;
    }

    function onSelecCategory() {
        const URL_CONCAT = $('meta[name="index"]').attr('content');
        const id = document.getElementById("category_id").value;

        if(id !== '') {
            $.ajax({
            type: 'GET',
            url: '/admin-get-select-days',
                beforeSend: function() {
                $('#packages_loader').removeClass('d-none');
                $('#packages_holder').empty();
                $('#package_id').remove();
            },
            success: function(response) {
            const selectHtml = `
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <select class="form-control" name="tennis-time" id="tennis-time" onchange="handleSelectDay(${id})">
                                        ${renderDates(response.dates)}	
                                    </select>
                                    </div>
                                
                                <div class="col-md-12 form-group">
                                    <div class="row">           
                                        <div class="col-md-2">
                                        <a class="btn btn-outline-dark btn-lg btn-block btn-slot disabled" style="border: 1px solid grey"> DISPONIBLE</a>
                                        </div>
                                        
                                        <div class="col-md-2">
                                        <a class="btn   btn-lg btn-block  btn-slot btn-warning disabled">EVENTO</a>
                                        </div>
                                        
                                        <div class="col-md-2">
                                        <a class="btn   btn-lg btn-block  btn-slot btn-secondary disabled" style="background-color: grey"><font color="FFFFFF"> EXPIRADO</font></a>
                                        </div>
                                        
                                        <div class="col-md-2">
                                        <a class="btn   btn-lg btn-block  btn-slot btn-success disabled" style="background-color: green" ><font color="FFFFFF"> RESERVADO</font></a>
                                        </div>

                                        <div class="col-md-2">
                                        <a class="btn   btn-lg btn-block  btn-slot btn-danger disabled"><font color="FFFFFF"> EN PROCESO </font></a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12" id="packages-calendar" style="text-align:center"></div>

                                </div>
                            `;
            $('#select-days').fadeIn().html(selectHtml);
            },
            complete: function () {
                $('#packages_loader').addClass('d-none');
            }
            });
        } else {
            $('#select-days').empty();
            $('#packages-by-type').empty();
            $('#packages-calendar').empty();
        }
	
    }
    
</script>

@endsection

