@extends('layouts.admin', ['title' => __('backend.starter_report')])

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

.starter-report-hidde-calendar {
    display: none;
}

.starter-report-show-calendar {
    display: block;
}

.starter-report-time {
    font-size: 16px;
    font-weight: bold;
    height: 100%;
    position: relative;
    padding-top: 29px;
}

.starter-report-time-package-title {
    text-align:center;
    border: 1px solid black;
    border-bottom: 0px transparent;
    padding-top: 10px;
    padding-bottom: 10px;
    font-weight: bold;
}

.starter-report-clearfix {
    margin-bottom: 24px !important;
    height: 90px !important;
}

@media only screen and (max-width: 600px) {

    .starter-report-time {
        padding-top: 10px;
        border-top: 1px solid black;
        border-bottom: 1px solid black;
    }

    .starter-report-time-package-title {
        background-color: #7f8c8d;
        font-weight: bold;
        color: white;
    }

    .starter-report-clearfix {
        height: 180px !important;
    }
	
}


</style>

    <div class="page-title">
        <h3>{{ __('backend.starter_report') }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li class="active">{{ __('backend.starter_report') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                
                    <div class="panel-heading clearfix starter-report-clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('backend.starter_report') }}</h4>
                        </div>

                        <div class="col-md-4 form-group" style="margin-top: 20px;">
                                    <select class="form-control" id="category_id" name="category_id" onchange="onSelecCategory()">
                                        <option value="">Seleccione Categoria</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select> 
                        </div>
                        <div class="col-md-4 form-group starter-calendar-container starter-report-hidde-calendar" style="margin-top: 20px;">
                            <div class="row">
                                <div class="col-md-2 form-group" style="    line-height: 2;" >{{ __('backend.date') }}</div>
                                <div class="col-md-10 form-group">
                                    <input type="date" class="form-control" id="bookingDate" name="bookingDate" onchange="onSelectDate()" >
                                </div>
                            </div>
                        </div>
                        
                       
                        
                </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12" id="schedule"></div>
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
        $('#bookingDate').val('');
        $('#schedule').empty();
        if(id > 0) {
            $('.starter-calendar-container').removeClass('starter-report-hidde-calendar');
            $('.starter-calendar-container').addClass('starter-report-show-calendar');
        } else {
            $('.starter-calendar-container').removeClass('starter-report-show-calendar');
            $('.starter-calendar-container').addClass('starter-report-hidde-calendar');
        }
    }

    function renderBookingPlayers(participants) {
        let html = '';
        participants.forEach(element => {
            html += `  <div class="col-md-12">${element.user_name.first_name} ${element.user_name.last_name}</div>`;
        });
        return html;
    }

    function renderBookings(bookings) {
        let html = '';
        bookings.forEach((element, i) => {
            html += `
            <div class="col-md-3 starter-report-time" style="${i > 0 ? 'border-top: 1px solid black;' : ''}">${element.booking_time}</div>
            <div class="col-md-9" style="${i > 0 ? 'border-top: 1px solid black;' : ''} border-left: 1px solid black; height:100%; position:relative;" >
                <div class="row" style="padding-top: 10px; padding-bottom: 10px">
                    ${renderBookingPlayers(element.bookingplayers)}
                </div>
            </div>
            `;
        });
        return html;
    }

    function renderPackage(data) {
        let html = '';
        data.forEach(element => {
            html +=`<div class="col-md-6 form-group">
                <div class="col-md-12 starter-report-time-package-title"> ${element.package.title} </div>
                <div class="col-md-12" style="text-align:center">
                    <div class="row" style="border: 1px solid black;">
                        ${renderBookings(element.bookings)}
                    </div>
                </div>
            </div>`;
        });
        return html;
    }


    function onSelectDate() {
            const URL_CONCAT = $('meta[name="index"]').attr('content');
            const bookingDate = document.getElementById("bookingDate").value;
            const category = document.getElementById("category_id").value;
            $.ajax({
                type: 'GET',
                url: '/starter-report-packages',
                data: { 
                    category: category,
                    bookingDate : moment(bookingDate).format('DD-MM-YYYY'),
                },
                    beforeSend: function() {
                        // $('#packages_loader').removeClass('d-none');
                        $('#schedule').empty();
                    },
                    success: function(response) {
                        console.log('response ', response);
                        const html = `
                        <div class="row">
                            ${renderPackage(response)}
                        </div>
                        `;
                        if(response.length > 0) {
                            $('#schedule').fadeIn().html(html);
                        } else {
                            const html = `
                            <div class="row">
                                <div class="col-md-12" style="color: red; font-weight: bold">NO SE ENCUENTRAN REGISTROS</div>
                            </div>
                            `;
                            $('#schedule').empty();
                            $('#schedule').fadeIn().html(html);
                        }
                        
                    },
                });
        }
    
</script>

@endsection

