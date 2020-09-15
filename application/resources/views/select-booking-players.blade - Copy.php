@extends('layouts.app', ['title' => __('app.step_players_page_title')])


@section('content')

<script language="javascript" type="text/javascript"> 
<!--  
//Browser Support Code 
function ajaxFunction(PlayerSlot){ 
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

    if (PlayerSlot==1)
	{
		var player1 = document.getElementById('player1').value; 
//		if (player1)
		{
			var queryString = "?doc_id=" + player1 + '&email=' +  'luca@cantv.net' ; 
			//PlayerSlot=1;
		}
	}

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
        
		
		
		var responseData = ajaxRequest.responseText; 
		//split response
		var partsOfStr = responseData.split(';');

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
		
		PlayerIcons = '';
		
		if (PlayerType==0)
		{
			//PlayerIcons = PlayerIcons + '<span class="glyphicon glyphicon-user"></span>';
			PlayerIcons = PlayerIcons + 'Socio - ';
		}
		if (PlayerType==1)
		{
			PlayerIcons = PlayerIcons + 'Invitado - ';
		}
		if (PlayerType==-1)
		{
			PlayerIcons = PlayerIcons + 'No registrado - ';
		}
		
		if (PlayerStatus==0)
		{
			//PlayerIcons = PlayerIcons + '<span class="glyphicon glyphicon-ban-circle"></span>';
			PlayerIcons = PlayerIcons + '<font color="red">NO PERMITIDO</font>';
		}	
		else
		{
			//PlayerIcons = PlayerIcons + '<span class="glyphicon glyphicon-ok-circle"></span>';
			PlayerIcons = PlayerIcons + 'OK';
		}	
//PlayerIcons = 'ggg';

		ajaxDisplay.value = PlayerName;
		ajaxDisplayType.value = PlayerType;
		ajaxDisplayStatus.value = PlayerStatus;
		ajaxDisplayIcons.innerHTML = PlayerIcons;
		ajaxDisplayError.innerHTML = PlayerErrorMessage;
				

		//ajaxDisplay.value = ajaxRequest.responseText; 
		//ajaxDisplay.innerHTML = ajaxRequest.responseText; 
        } 
    } 

	
ajaxRequest.open("GET", "dataHelper.php" + queryString, true); 
    ajaxRequest.send(null);  
} 
//--> 
</script> 


    <div class="jumbotron promo">
        <div class="container">
            <h1 class="text-center promo-heading">{{ __('app.step_players_page_title') }}</h1>
            <p class="promo-desc text-center">{{ __('app.step_players_subtitle') }}</p>
        </div>
    </div>

    <form method="post" id="booking_step_player" action="{{ route('postStepPlayer') }}">
        <input type="hidden" name="session_email" value="{{ Auth::user()->email }}">
        {{ csrf_field() }}
        <div class="container">
            <div class="content">

                <div class="row">
                    <div class="col-md-12">
                        <div class="progress mx-lg-5" style="height: 30px;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">35%</div>

                        </div>
                    </div>
                </div>

				<?php
				$i=0;
				?>
				
				<script>
				var ItemValue;
				var item;
				</script>
				
				@if(count($session_players))
					@foreach($session_players as $player)

					<div class="row">
						<div class="col-md-3">

							<div class="text-left player_doc_id">{{ $player->doc_id  }} </div>
									
								<script>
								/*
								ItemValue = '{{ $player->doc_id  }}';
								item = document.getElementById('player<?php	echo $i;?>');
								item.value = ItemValue;
								*/
								</script>
						</div>
						
						<div class="col-md-3">
							<div class="text-left player_name">

							{{ $player->first_name  }}
							{{ $player->last_name  }}

							</div>
									
						</div>

						<div class="col-md-3">
							<div class="text-left player_name">

							Eliminar

							</div>
									
						</div>

						
					</div>
					@endforeach

				@else
				@endif

				<br><br>

				<form name='myForm' method="post" action="outputHelper.php"> 

				<div class="row">
						<div class="col-md-2">
                            <h5>{{ __('app.player') }}</h5>
						</div>	
                        <div class="col-md-3">    
							<input type="text"  rows="" class="form-control has-success has-feedback form-control-lg" name="player1"
                                   id="player1" placeholder="{{ __('app.player_placeholder') }}" autocomplete="off">
						</div>
						
						<input type='button' onclick='ajaxFunction(1)' value='Buscar' /> 
						<div id='ajaxDivPlayer1'> 
						</div>
						
						<div class="col-md-6">
							<input type="text" class="form-control form-control-lg" name="player1Name"
                                   id="player1Name"  autocomplete="off" disabled>								   
							<input type="hidden" class="form-control form-control-lg" name="player1Type"
                                   id="player1Type"  autocomplete="off">
							<input type="hidden" class="form-control form-control-lg" name="player1Status"
                                   id="player1Status"  autocomplete="off">
							<div id="player1Icons" name="player1Icons"></div>
							<div id="player1ErrorMessage" name="player1ErrorMessage"></div>								   
                        </div>
				</div>		
				</form> 

            </div>
        </div>

        <br><br>
        <footer class="footer d-none d-sm-none d-md-block d-lg-block d-xl-block">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <span class="text-copyrights">
                            {{ __('auth.copyrights') }}. &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }} {{ config('settings.business_name', 'Bookify') }}.
                        </span>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('loadStep2') }}" class="navbar-btn btn btn-primary btn-lg ml-auto">
                            {{ __('app.step_player_button') }}
                        </a>
                    </div>
                </div>
            </div>
        </footer>

        {{--FOOTER FOR PHONES--}}

        <footer class="footer d-block d-sm-block d-md-none d-lg-none d-xl-none">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="{{ route('loadFinalStep') }}" class="navbar-btn btn btn-primary btn-lg ml-auto">
                            {{ __('app.step_one_button') }}
                        </a>
                    </div>
                </div>
            </div>
        </footer>

    </form>

@endsection

@section('scripts')
    <script>
        $('.addon_buttons').on('click', 'a.btn-addon', function() {

            var method = $(this).attr('data-method');

            if(method === "add") {
                $(this).removeClass('btn-primary').addClass('btn-danger').text('{{ __("app.remove_service_btn") }}');
            }

            else if(method === "remove") {
                $(this).removeClass('btn-danger').addClass('btn-primary').text('{{ __("app.add_service_btn") }}');
            }

        });
    </script>
	
@endsection