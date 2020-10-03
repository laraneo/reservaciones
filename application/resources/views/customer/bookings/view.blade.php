@extends('layouts.customer', ['title' => __('backend.view_booking')])

@section('content')

<style>

.show-form {
	display: block;
}

.hidde-form {
	display: none;
}
	
</style>

<?php
	$domain_id = config('settings.business_name', 'Reservaciones');
	$date = date('Y-m-d');
	$calculated_token = md5($domain_id.$date);	
	//$calculated_token = $domain_id.$date.date_default_timezone_get();	
	//$calculated_token = "123";
?>

<script language="javascript" type="text/javascript"> 

function wait(ms){
   var start = new Date().getTime();
   var end = start;
   while(end < start + ms) {
     end = new Date().getTime();
  }
}

function Reload()
{
	document.location.reload(false);
	//window.location.reload(true); 
}
 
//Browser Support Code 
function ajaxFunctionInclude(PlayerSlot){ 
	console.log('flag');
	//clean members div
	document.getElementById("GridMembers").innerHTML = " ";
	
	//var PlayerSlot;
    var ajaxRequest;  // The variable that makes Ajax possible! 
     
    try{ 
        // Opera 8.0+, Firefox, Safari 
        ajaxRequest = new XMLHttpRequest(); 
    } catch (e){ 
        // Internet Explorer Browsers 
        try{ 
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP"); 
        } catch (e) { 
            try{ 
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP"); 
            } catch (e){ 
                // Something went wrong 
                alert("Your browser broke!"); 
                return false; 
            } 
        } 
    } 

	//disable buttons meanwhile
	document.getElementById("btnSearch").disabled = true;
	//document.getElementById("btnRefresh").disabled = true;

	var errorPlayer = 0;
	const package = '{{ Session::get('package_id') }}';
    if (PlayerSlot==1)
	{
		var player1 = document.getElementById('player1').value; 

		if (player1.trim().toLowerCase()  == 'favorites')
		{
			var queryString = "?command=favorites&email=" +  "{{Auth::user()->email}}"  +  "&token=" + "<?php echo $calculated_token; ?>" + "&package_id="+package;  
		}
		else if (player1.trim().toLowerCase()  == 'partners')
		{
			var queryString = "?command=partners&email=" +  "{{Auth::user()->email}}"  +  "&token=" + "<?php echo $calculated_token; ?>" + "&package_id="+package;  
		}
		else if (player1.indexOf('-') > -1)
		{
			//it is a group		
				var queryString = "?command=group&group_id=" + player1	+ "&email=" +  "{{Auth::user()->email}}"  +  "&token=" + "<?php echo $calculated_token; ?>" + "&package_id="+package;  
		}
		else
		{
			//validate that user is not included as participant again
			if (player1=={{Auth::user()->doc_id}})
			{
				alert("Como solicitante ya estás registrado como participante");
				errorPlayer = 1;
			}
			else
			{

			}
			
	//		if (player1)
			{
				const idBookingPlayer = $('#idBookingPlayer').val();
				var queryString = "?command=include-booking-player&doc_id=" + player1+ "&email=" +  "{{Auth::user()->email}}" 
				+ "&bookingId=" + "{{ (string)$booking->id }}"
				+ "&idBookingPlayer=" + idBookingPlayer
                +  "&booking_date=" + "{{ Session::get('event_date') }}" 
				+  "&token=" + "<?php echo $calculated_token; ?>"
				 + "&package_id="+'{{ Session::get('package_id') }}' 
				 + "&categoryType="+'{{ Session::get('categoryType') }}' 
				 + "&packageType="+'{{ Session::get('packageType') }}';

//                 var queryString = `?command=include-booking-player&doc_id=${player1}&email={{Auth::user()->email}}&bookingId={{ $booking->id }}`
				//PlayerSlot=1;
			}
		}
	}

	if (errorPlayer==0)
	{
		// Create a function that will receive data sent from the server 
		ajaxRequest.onreadystatechange = function()
		{ 
			var ajaxDisplay;
			var ajaxDisplayType;
			var ajaxDisplayStatus;
			var ajaxDisplayError;
			var ajaxDisplayIcons;
			
			if(ajaxRequest.readyState == 4){ 
			
				if (PlayerSlot==1)
				{
					 ajaxDisplay = document.getElementById('player1Name'); 	
					 ajaxDisplayType = document.getElementById('player1Type');
					 ajaxDisplayStatus = document.getElementById('player1Status');
					 ajaxDisplayError = document.getElementById('player1ErrorMessage');
					 ajaxDisplayIcons = document.getElementById('player1Icons');
				}	
				
				//clean
				ajaxDisplay.value = '';
				ajaxDisplayType.value = '';
				ajaxDisplayStatus.value = '';
				ajaxDisplayIcons.innerHTML = '';
				ajaxDisplayError.innerHTML = '';		
				
				var ResponseType = '';
				var responseData = ajaxRequest.responseText; 
				//split response
				var partsOfStr = responseData.split(';');

				//alert(responseData);
				
				for (var k = 0; k < partsOfStr.length; k++) {
					if (k==0)
					{  var ResponseType=partsOfStr[k]; }
					if (k==1)
					{  var PlayerName=partsOfStr[k]; }
					if (k==2)
					{  var PlayerType=partsOfStr[k]; }
					if (k==3)
					{  var PlayerStatus=partsOfStr[k]; }
					if (k==4)
					{  var PlayerErrorMessage=partsOfStr[k]; }		
				}
				
				ResponseType = ResponseType.trim();
				
				//alert('**' + ResponseType + '**');
				if (ResponseType =='include-booking-player')
				{
					PlayerIcons = '';
					// if (PlayerType==0)
					// {
						// //PlayerIcons = PlayerIcons + '<span class="glyphicon glyphicon-user"></span>';
						// PlayerIcons = PlayerIcons + 'Socio ';
					// }
					// if (PlayerType==1)
					// {
						// PlayerIcons = PlayerIcons + 'Invitado ';
					// }
					if (PlayerType==-1)
					{
						PlayerIcons = PlayerIcons + '<font color="red">Jugador No Registrado </font>';
					}
					
					if (PlayerStatus==0)
					{
						//PlayerIcons = PlayerIcons + '<span class="glyphicon glyphicon-ban-circle"></span>';
						// PlayerIcons = PlayerIcons + '<font color="red">NO PERMITIDO</font>';
					}	
					else
					{
						//PlayerIcons = PlayerIcons + '<span class="glyphicon glyphicon-ok-circle"></span>';
						//PlayerIcons = PlayerIcons + 'OK';
					}	//"?doc_id="

					ajaxDisplay.value = PlayerName;
					ajaxDisplayType.value = PlayerType;
					ajaxDisplayStatus.value = PlayerStatus;
					ajaxDisplayIcons.innerHTML = PlayerIcons;
					ajaxDisplayError.innerHTML = PlayerErrorMessage;
							

					//ajaxDisplay.value = ajaxRequest.responseText; 
					//ajaxDisplay.innerHTML = ajaxRequest.responseText; 

	
						
				}
				else if (ResponseType =='favorites')
				{
					//alert(ResponseType);

					//draw table for group
					//alert(PlayerName); 
					var partsOfStrMembers = PlayerName.split('#');
					var errorMessage = PlayerType.trim();
					
					//alert (errorMessage);
					
					ajaxDisplayError = document.getElementById('player1ErrorMessage');
				
					//clean
					ajaxDisplayError.innerHTML = "";					
					
					if (errorMessage == '')
					{
						var GridMembers = '';
						var RowMember = '';
						
						for (var w = 0; w < partsOfStrMembers.length; w++) {
							//member
							var partsOfStrItem = partsOfStrMembers[w].split('*');	
							
							//alert(partsOfStrMembers[w]);
							//partsOfStrItem = partsOfStrItem.trim();
							
							if (partsOfStrMembers[w] !='')
							{
								//alert(partsOfStrMembers[w]); 
								for (var z = 0; z < partsOfStrItem.length; z++) {
									if (z==0)
									{  var MemberID=partsOfStrItem[z]; }
									if (z==1)
									{  var MemberName=partsOfStrItem[z]; }
								}

								//draw row
								RowMember = '';

								RowMember = RowMember + '<div id=\"PlayerRowSelect' + MemberID  + '\" > ';
								RowMember = RowMember + '<div class=\"row\">';
								
								RowMember = RowMember + '<div class=\"col-md-1\"> \
									<div class=\"text-left player_type\">  \
										 <i class=\"fa fa-star\"></i>  \
									</div>  \
								</div>';

								RowMember = RowMember + '<div class=\"col-md-2\"> \
									<div class=\"text-left player_doc_id\">'+ MemberID  + '</div> \
								</div>';
								
								RowMember = RowMember +  '<div class="col-md-6"> \
									<div class="text-left player_name">' + MemberName + '</div> \
								</div>';
								
								RowMember = RowMember + '<form name=\"myFormSelect' + MemberID  + '\" method=\"post\" action=\"outputHelper.php\"> \
								<div class=\"col-md-2\"> \
									<div class=\"text-left player_select\" > \
										<input type=\"button\" \
										onclick=\"ajaxFunctionSelect(' + MemberID +  ')\" value=\"Seleccionar\" /> \
									</div> \
								</div> \
								</form>	';					
								
								RowMember = RowMember + '</div>';
								RowMember = RowMember + '</div>';
								
								//RowMember = MemberID + " - " + MemberName + '<br>';
								GridMembers = GridMembers + RowMember;
								//alert (MemberID + " - " + MemberName);
							}
							else
							{
								
							}
						}
						
						document.getElementById("GridMembers").innerHTML = GridMembers;
					}
					else  //has errors
					{
						ajaxDisplayError.innerHTML = errorMessage;
					}		
					
					//enable buttons meanwhile
					//alert ("habilitando");
					document.getElementById("btnSearch").disabled = false;
					//document.getElementById("btnRefresh").disabled = false;		
					
					
					
				}	
				else if (ResponseType =='partners')
				{

					//alert(ResponseType);

					//draw table for group
					//alert(PlayerName); 
					var partsOfStrMembers = PlayerName.split('#');
					var errorMessage = PlayerType.trim();
					
					//alert (errorMessage);
					
					ajaxDisplayError = document.getElementById('player1ErrorMessage');
				
					//clean
					ajaxDisplayError.innerHTML = "";					
					
					if (errorMessage == '')
					{
						var GridMembers = '';
						var RowMember = '';
						
						for (var w = 0; w < partsOfStrMembers.length; w++) {
							//member
							var partsOfStrItem = partsOfStrMembers[w].split('*');	
							
							//alert(partsOfStrMembers[w]);
							//partsOfStrItem = partsOfStrItem.trim();
							
							if (partsOfStrMembers[w] !='')
							{
								//alert(partsOfStrMembers[w]); 
								for (var z = 0; z < partsOfStrItem.length; z++) {
									if (z==0)
									{  var MemberID=partsOfStrItem[z]; }
									if (z==1)
									{  var MemberName=partsOfStrItem[z]; }
									if (z==2)
									{  var MemberCount=partsOfStrItem[z]; }
								
								}

								//draw row
								RowMember = '';

								RowMember = RowMember + '<div id=\"PlayerRowSelect' + MemberID  + '\" > ';
								RowMember = RowMember + '<div class=\"row\">';
								
								RowMember = RowMember + '<div class=\"col-md-1\"> \
									<div class=\"text-left player_type\">  \
										 <i class=\"fa fa-star\"></i>  \
									</div>  \
								</div>';

								RowMember = RowMember + '<div class=\"col-md-2\"> \
									<div class=\"text-left player_doc_id\">'+ MemberID  + '</div> \
								</div>';
								
								RowMember = RowMember +  '<div class="col-md-4"> \
									<div class="text-left player_name">' + MemberName + '</div> \
								</div>';

								RowMember = RowMember +  '<div class="col-md-2"> \
									<div class="text-left player_count">( ' + MemberCount + ' )</div> \
								</div>';
								
								RowMember = RowMember + '<form name=\"myFormSelect' + MemberID  + '\" method=\"post\" action=\"outputHelper.php\"> \
								<div class=\"col-md-2\"> \
									<div class=\"text-left player_select\" > \
										<input type=\"button\" \
										onclick=\"ajaxFunctionSelect(' + MemberID +  ')\" value=\"Seleccionar\" /> \
									</div> \
								</div> \
								</form>	';					
								
								RowMember = RowMember + '</div>';
								RowMember = RowMember + '</div>';
								
								//RowMember = MemberID + " - " + MemberName + '<br>';
								GridMembers = GridMembers + RowMember;
								//alert (MemberID + " - " + MemberName);
							}
							else
							{
								
							}
						}
						
						document.getElementById("GridMembers").innerHTML = GridMembers;
					}
					else  //has errors
					{
						ajaxDisplayError.innerHTML = errorMessage;
					}		
					
					//enable buttons meanwhile
					//alert ("habilitando");
					document.getElementById("btnSearch").disabled = false;
					//document.getElementById("btnRefresh").disabled = false;		
					
								
			
				}
				else if (ResponseType =='group')
				{
					//draw table for group
					//alert(PlayerName); 
					var partsOfStrMembers = PlayerName.split('#');
					var errorMessage = PlayerType.trim();
					
					//alert (errorMessage);
					
					ajaxDisplayError = document.getElementById('player1ErrorMessage');
				
					//clean
					ajaxDisplayError.innerHTML = "";					
					
					if (errorMessage == '')
					{
						var GridMembers = '';
						var RowMember = '';
						
						for (var w = 0; w < partsOfStrMembers.length; w++) {
							//member
							var partsOfStrItem = partsOfStrMembers[w].split('*');	
							
							//alert(partsOfStrMembers[w]);
							//partsOfStrItem = partsOfStrItem.trim();
							
							if (partsOfStrMembers[w] !='')
							{
								//alert(partsOfStrMembers[w]); 
								for (var z = 0; z < partsOfStrItem.length; z++) {
									if (z==0)
									{  var MemberID=partsOfStrItem[z]; }
									if (z==1)
									{  var MemberName=partsOfStrItem[z]; }
								}

								//draw row
								RowMember = '';

								RowMember = RowMember + '<div id=\"PlayerRowSelect' + MemberID  + '\" > ';
								RowMember = RowMember + '<div class=\"row\">';
								
								RowMember = RowMember + '<div class=\"col-md-1\"> \
									<div class=\"text-left player_type\">  \
										 <i class=\"fa fa-star\"></i>  \
									</div>  \
								</div>';

								RowMember = RowMember + '<div class=\"col-md-2\"> \
									<div class=\"text-left player_doc_id\">'+ MemberID  + '</div> \
								</div>';
								
								RowMember = RowMember +  '<div class="col-md-6"> \
									<div class="text-left player_name">' + MemberName + '</div> \
								</div>';
								
								RowMember = RowMember + '<form name=\"myFormSelect' + MemberID  + '\" method=\"post\" action=\"outputHelper.php\"> \
								<div class=\"col-md-2\"> \
									<div class=\"text-left player_select\" > \
										<input type=\"button\" \
										onclick=\"ajaxFunctionSelect(' + MemberID +  ')\" value=\"Seleccionar\" /> \
									</div> \
								</div> \
								</form>	';					
								
								RowMember = RowMember + '</div>';
								RowMember = RowMember + '</div>';
								
								//RowMember = MemberID + " - " + MemberName + '<br>';
								GridMembers = GridMembers + RowMember;
								//alert (MemberID + " - " + MemberName);
							}
							else
							{
								
							}
						}
						
						document.getElementById("GridMembers").innerHTML = GridMembers;
					}
					else  //has errors
					{
						ajaxDisplayError.innerHTML = errorMessage;
					}		
					
					//enable buttons meanwhile
					//alert ("habilitando");
					document.getElementById("btnSearch").disabled = false;
					//document.getElementById("btnRefresh").disabled = false;		
					
				}
				else if (ResponseType =='delete-booking-player')
				{
					
				}
				else
				{
					
					
				}
				
				//refresh
				if (PlayerErrorMessage=='')
				{
					//window.location.reload(false);
					Reload();
				}

				//enable buttons meanwhile
				//alert ("habilitando");
				document.getElementById("btnSearch").disabled = false;
				//document.getElementById("btnRefresh").disabled = false;					
	

			} 
			
			//refresh page
			//wait(3000);
			//document.location.reload(true);
			//window.location.reload(true); 

		} 
	
		//alert ('queryString ' + queryString);
		ajaxRequest.open("GET", "../../../../dataHelper.php" + queryString, true); 
		ajaxRequest.send(null);  
	}
	else
	{
		document.getElementById("btnSearch").disabled = false;
		//document.getElementById("btnRefresh").disabled = false;	
	}
} 
//--> 

</script> 



<script language="javascript" type="text/javascript"> 

function ajaxFunctionDelete(doc_id){ 
	//var PlayerSlot;
    var ajaxRequest;  // The variable that makes Ajax possible! 
     
    try{ 
        // Opera 8.0+, Firefox, Safari 
        ajaxRequest = new XMLHttpRequest(); 
    } catch (e){ 
        // Internet Explorer Browsers 
        try{ 
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP"); 
        } catch (e) { 
            try{ 
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP"); 
            } catch (e){ 
                // Something went wrong 
                alert("Your browser broke!"); 
                return false; 
            } 
        } 
    } 
	
	var queryString = "?command=delete-booking-player&doc_id=" + doc_id + "&email=" + "{{Auth::user()->email}}" + "&bookingId=" + "{{ $booking->id }}" + 
	"&token=" + "<?php echo $calculated_token; ?>";  
	

    // Create a function that will receive data sent from the server 
    ajaxRequest.onreadystatechange = function()
	{ 
		var ajaxDisplay;
		
        if(ajaxRequest.readyState == 4){ 
		
			 ajaxDisplay = document.getElementById('PlayerRow' + doc_id); 	
        //ajaxDisplay = document.getElementById('PlayerRow12422099'); 	
		
		
		var responseData = ajaxRequest.responseText; 
		//split response
		/*var partsOfStr = responseData.split(';');

		for (var k = 0; k < partsOfStr.length; k++) {
			if (k==0)
			{  var PlayerName=partsOfStr[k]; }
			if (k==1)
			{  var PlayerType=partsOfStr[k]; }
			if (k==2)
			{  var PlayerStatus=partsOfStr[k]; }
			if (k==3)
			{  var PlayerErrorMessage=partsOfStr[k]; }		
		}
		*/
		
		//hide row
		
		//ajaxDisplay.value = responseData;

		//ajaxDisplay.value = ajaxRequest.responseText; 
		//ajaxDisplay.innerHTML = ajaxRequest.responseText; 
        window.location.href = `/customer/booking/{{ $booking->id }}`;
        } 

    } 

	
    ajaxRequest.open("GET", "../../../../dataHelper.php" + queryString, true); 
    ajaxRequest.send(null);  

} 
</script>


<script language="javascript" type="text/javascript"> 

function ajaxFunctionSelect(doc_id){ 

	PlayerInput = document.getElementById('player1'); 	

	PlayerInput.value = doc_id; 
	//PlayerInput.innerHTML = doc_id; 
	btnSearch = document.getElementById('btnSearch'); 	
	btnSearch.click();
	//document.getElementById('btnSearch').trigger('click');
	
	//alert("Clicked");
} 
</script>


    <div class="page-title">
        <h3>{{ __('backend.booking') }} # {{ $booking->id }}</h3>
        <div class="page-breadcrumb">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}">{{ __('backend.home') }}</a></li>
                <li><a href="{{ route('customerBookings') }}">{{ __('backend.bookings') }}</a></li>
                <li class="active">{{ __('backend.view_booking') }}</li>
            </ol>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="row">

            <div class="col-md-12">
                @if(Session::has('cancel_request_received'))
                    <div class="alert alert-success">{{session('cancel_request_received')}}</div>
                @endif
            </div>

            @if($booking->user_id == Auth::user()->id)

                <div class="col-md-6">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <div id="account_details_view">
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.category') }}:</strong></div>
                                    <div class="col-md-6">{{ $booking->package->category->title }}</div>
                                </div>
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.package') }}:</strong></div>
                                    <div class="col-md-6">{{ $booking->package->title }}</div>
                                </div>
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.instructions') }}:</strong></div>
                                    <div class="col-md-6">{{ $booking->booking_instructions ? $booking->booking_instructions : __('backend.not_provided') }}</div>
                                </div>
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.extra_services') }}:</strong></div>
                                    <div class="col-md-6">
                                        @if(count($booking->addons))
                                            @foreach($booking->addons as $addon)
                                                {{ $addon->title }}<br>
                                            @endforeach
                                        @else
                                            {{ __('backend.none') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            <div id="account_details_view">
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.date') }}:</strong></div>
                                    <div class="col-md-6">{{ $booking->booking_date }}</div>
                                </div>
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.time') }}:</strong></div>
                                    <div class="col-md-6">{{ $booking->booking_time }}</div>
                                </div>
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.status') }}:</strong></div>
                                    <div class="col-md-6">{{ $booking->status }}</div>
                                </div>
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.locator') }}:</strong></div>
                                    <div class="col-md-6" style="color: blue; font-weight: bold" >{{ $booking->locator }}</div>
                                </div>
							
							<!--
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.invoice_no') }}</strong></div>
                                    <div class="col-md-6">{{ $booking->invoice->id }}</div>
                                </div>
                                <div class="row table-row">
                                    <div class="col-md-6 bold-font"><strong>{{ __('backend.payment_details') }}:</strong></div>
                                    <div class="col-md-6">{{ $booking->invoice->is_paid ? __('backend.paid') : __('emails.to_be_paid') }}

                                        @if(config('settings.currency_symbol_position')== __('backend.right'))

                                            {!! number_format( (float) $booking->invoice->amount,
                                                config('settings.decimal_points'),
                                                config('settings.decimal_separator') ,
                                                config('settings.thousand_separator') ). '&nbsp;' .
                                                config('settings.currency_symbol') !!}

                                        @else

                                            {!! config('settings.currency_symbol').
                                                number_format( (float) $booking->invoice->amount,
                                                config('settings.decimal_points'),
                                                config('settings.decimal_separator') ,
                                                config('settings.thousand_separator') ) !!}

                                        @endif

                                        via {{ $booking->invoice->payment_method }}
                                    </div>
                                </div>
                            
							LA -->
							</div>
                        </div>
                    </div>
                </div>



			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<div class="account_details_view">
			
				@if(count($booking->bookingplayers))
					@foreach($booking->bookingplayers as $player)
							<div class="row table-row">	
                                <div class="col-md-3">
                                    {{-- @if(!$player->isConfirmed())
                                         <i class="{{ $player->player_type === 0 ? 'fa fa-star' : ' fa fa-user-plus' }} "></i> &nbsp; <a class="btn btn-danger" onclick='ajaxFunctionDelete({{$player->doc_id}})'><i class="fa fa-trash"></i> Eliminar</a>
                                    @endif	 --}}
									@if(Auth::user()->doc_id === $player->doc_id )
										<i class="fa fa-star"></i>
									@endif
									
									@if(!$player->isConfirmed() && $player->player_type == 0 )
										<i class="fa fa-user-plus"></i> &nbsp; <a class="btn btn-info" onclick='handlePlayerChange({{$player->id}})'><i class="fa fa-sync"></i> Cambiar</a>
									@endif	
									
									@if(!$player->isConfirmed() && $player->player_type == 1 )
										<i class=" fa fa-user"></i> &nbsp; <a class="btn btn-info" onclick='handlePlayerChange({{$player->id}})'><i class="fa fa-sync"></i> Cambiar</a>
									@endif

                                    </div>
								<div class="col-md-3">
                                
								{{ $player->PlayerRol() }} - {{ $player->PlayerName2() }}
								</div>
								
								<div  class="col-md-2 bold-font {{ $player->isConfirmed()  ? 'label-success' : 'label-danger' }}"> <p align="center" style="color:white; margin: 0 auto; padding: 5px"><strong> {{ $player->PlayerConfirmedStatus() }}</strong></p></div>

								<div class="col-md-3">
								{{ $player->confirmed_at }} 
								</div>								
					
							</div>
					@endforeach
				@else
							<div class="row table-row">	
					{{ __('backend.none') }}
							</div>
				@endif
							
						</div>
						<input type="hidden" id="idBookingPlayer" value="">
                        <form name='myForm' class="search-helper-player hidde-form" method="post" action="outputHelper.php"> 

                            <div class="row">
                                    <div class="col-md-2">
                                        <a name="btnSearch" id="btnSearch" class="btn btn-primary" onclick='ajaxFunctionInclude(1)'>  <i class="fa fa-search"></i> Buscar Jugador</a>
                                    </div>	
                                    <div class="col-md-3">    
                                        <input type="text"  rows="" class="form-control has-success has-feedback form-control-lg" name="player1"
                                               id="player1" placeholder="{{ __('app.player_placeholder') }}" autocomplete="off">
                                    </div>
                                    <div id='ajaxDivPlayer1'> 
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control form-control-lg" name="player1Name"
                                               id="player1Name"  autocomplete="off" disabled>
                                    </div>        
                            </div>	
            
                            <div class="row" >
                                    <div class="col-md-1">
                                    </div>
                                    <div class="col-md-9">
                                               
                                        <input type="hidden" class="form-control form-control-lg" name="player1Type"
                                               id="player1Type"  autocomplete="off">
                                        <input type="hidden" class="form-control form-control-lg" name="player1Status"
                                               id="player1Status"  autocomplete="off">
                                        <div id="player1Icons" name="player1Icons"></div>
                                        
                                        <div id="player1ErrorMessage" name="player1ErrorMessage" style="color:red"></div>							  
                                    </div>
            
                            </div>	
                            <br>
				<div  name="GridMembers" id="GridMembers" >
				</div>
                            </form> 
					</div>
				</div>
			</div>	




                <div class="col-md-3 hidden-xs hidden-sm">
                    @if($booking->status != __('backend.cancelled') and count($booking->cancel_request)==0)
                        @if(config('settings.allow_to_cancel'))
                            <button class="btn btn-lg btn-danger {{ !$allow_to_cancel ? 'disabled' : '' }}" data-toggle="modal" data-target="#request_cancellation"><i class="fa fa-times-circle fa-lg"></i> &nbsp; {{ __('backend.request_to_cancel') }}</button>
                        @endif

                        @if(config('settings.allow_to_update'))
                            <a class="btn btn-lg btn-primary {{ !$allow_to_update ? 'disabled' : ''  }}" href="{{ route('updateBooking', $booking->id) }}"><i class="fa fa-calendar fa-lg"></i> &nbsp; {{ __('backend.change_booking_time') }}</a>
                            <br><br>
                        @endif
                    @endif
                </div>

                <div class="col-md-3 hidden-xs hidden-sm">
                    @if(config('settings.ClientAllowDeleteBookings'))
                        <button class="btn btn-lg btn-danger btn-block" type="button" onclick="handleDeleteBooking('{{ $booking->locator }}')" ><i class="fa fa-times-circle fa-lg"></i> &nbsp; {{ __('backend.delete_booking') }}</button>
                    @endif                 
                </div>

                <div class="col-md-12 hidden-md hidden-lg">
                    @if($booking->status != __('backend.cancelled') and count($booking->cancel_request)==0)
                        @if(config('settings.allow_to_cancel'))
                            <button class="btn btn-lg btn-danger btn-block {{ !$allow_to_cancel ? 'disabled' : '' }}" data-toggle="modal" data-target="#request_cancellation"><i class="fa fa-times-circle fa-lg"></i> &nbsp; {{ __('backend.request_to_cancel') }}</button>
                        @endif

                        @if(config('settings.allow_to_update'))
                            <a class="btn btn-lg btn-primary btn-block {{ !$allow_to_update ? 'disabled' : ''  }}" href="{{ route('updateBooking', $booking->id) }}"><i class="fa fa-calendar fa-lg"></i> &nbsp; {{ __('backend.change_booking_time') }}</a>
                            <br><br>
                        @endif
                    @endif
                </div>



            @else

                <div class="col-md-12">
                    <div class="alert alert-danger">
                        {{ __('backend.not_authorized') }}
                    </div>
                </div>

            @endif
        </div>
    </div>


    {{--CANCEL REQUEST MODAL--}}

    <div id="request_cancellation" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <!-- Modal content-->
            <form method="post" action="{{ route('cancelRequest') }}">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{ __('backend.confirm') }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><strong>{{ __('backend.reason_for_cancellation') }}</strong></label>
                            <textarea class="form-control" name="reason" required></textarea>
                        </div>
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">{{ __('backend.request_to_cancel') }}</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('backend.close') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<script>

    function handleDeleteBooking(locator){
        $.ajax({
        type: 'POST',
        url: `/delete-booking-by-locator`,
        data: { locator: locator }, 
            success: function(response) {
				window.location.href = "/home";
            },
        });
    }

	function handlePlayerChange(id) {
		$('#idBookingPlayer').val(id);
		$('.search-helper-player').removeClass('hidde-form').addClass('show-form');
	}


</script>

@endsection