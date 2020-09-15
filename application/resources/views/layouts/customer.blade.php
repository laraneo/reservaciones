<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>{{ $title }} | {{ config('settings.business_name') }}</title>

    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta charset="UTF-8">
    <meta name="title" content="{{ $title }}" />
    <meta name="description" content="Customer Panel for {{ config('settings.business_name') }}." />
    <meta name="keywords" content="Booking, Calender, Make Booking, Laravel" />
    <meta name="author" content="Xtreme Webs" />

    <link rel="icon" href="{{ asset('favicon.png') }}">

    <!-- Styles -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link href="{{ asset('plugins/pace-master/themes/blue/pace-theme-flash.css') }}" rel="stylesheet"/>
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/fontawesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/line-icons/simple-line-icons.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/waves/waves.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/datatables/css/jquery.datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/datatables/css/jquery.datatables_themeroller.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/summernote-master/summernote.css') }}" rel="stylesheet" type="text/css"/>


    <!-- Theme Styles -->
    <link href="{{ asset('css/backend.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/themes/green.css') }}" class="theme-color" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css"/>

@yield('styles')

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body class="page-header-fixed">
<div class="overlay"></div>

<main class="page-content content-wrap">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="sidebar-pusher">
                <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <div class="logo-box">
                <a href="{{ route('home') }}" class="logo-text"><span>{{  strtoupper(str_limit(config('settings.business_name'),9)) }}</span></a>
            </div><!-- Logo Box -->

            <div class="topmenu-outer">
                <div class="top-menu">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic sidebar-toggle"><i class="fa fa-bars"></i></a>
                        </li>
                        <li>
                            <a href="{{ route('customerBookings') }}">
                                <i class="icon-calendar text-success"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('index') }}">
                                <i class="icon-plus text-info"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customerInvoices') }}">
                                <i class="icon-list text-danger"></i>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic toggle-fullscreen"><i class="fa fa-expand"></i></a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
					
					
                        <li>
                            <a href="{{ route('index') }}" >
                                <span><i class="icon-plus m-r-xs"></i>
								<font color="blue"><strong>
								<blink>
								{{ __('backend.wanttobook')  }}
								</blink>
								</strong></font>
								</span>
                            </a>
                        </li>					
					
                        <li class="dropdown">
                            <a class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                <span class="user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}<i class="fa fa-angle-down"></i></span>
                                <img class="img-circle avatar" src="{{ Auth::user()->photo ? asset(Auth::user()->photo->file) : asset('images/profile-placeholder.png') }}" width="40" height="40"
                                     alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">
                            </a>
                            <ul class="dropdown-menu dropdown-list" role="menu">
                                <li role="presentation"><a href="{{ route('customerProfile') }}"><i class="icon-user"></i>{{ __('backend.my_profile') }}</a></li>
                                <li role="presentation"><a href="{{ route('changePassword') }}"><i class="icon-lock"></i>{{ __('backend.change_password') }}</a></li>
                                <li role="presentation"><a href="{{ route('logout') }}" onclick="
                                event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                        <i class="icon-logout m-r-xs"></i>{{ __('backend.logout') }}
                                    </a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                        </li>
						

						
                        <li>
                            <a href="{{ route('logout') }}"
                               class="log-out waves-effect waves-button waves-classic"
                               onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <span><i class="icon-logout m-r-xs"></i>{{ __('backend.logout')  }}</span>
                            </a>
                        </li>
                    </ul><!-- Nav -->
                </div><!-- Top Menu -->
            </div>
        </div>
    </div><!-- Navbar -->
    <div class="page-sidebar sidebar">
        <div class="page-sidebar-inner slimscroll">
            <div class="sidebar-header">
                <br>
                <p class="text-center">
                    <img class="img-circle avatar" src="{{ Auth::user()->photo ? asset(Auth::user()->photo->file) : asset('images/profile-placeholder.png') }}" width="60" height="60"
                         alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">
                </p>
                <br>
                <div class="sidebar-profile">
                    <a href="{{ route('customerProfile') }}">
                        <div class="sidebar-profile-details">
                            <span>Bienvenido <br>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}<br><small>{{ ucfirst(Auth::user()->role->name) }}</small></span>
                        </div>
                    </a>
                </div>
            </div>
            <ul class="menu accordion-menu">


                <li class="{{ Request::is('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" class="waves-effect waves-button">
                        <span class="menu-icon icon-home"></span>
                        <p>{{ __('backend.dashboard') }}</p>
                    </a>
                </li>

                <li>
                    <a href="{{ route('index') }}" class="waves-effect waves-button">
                        <span class="menu-icon icon-plus"></span>
                        <p>{{ __('app.new_booking_link') }}</p>
                    </a>
                </li>

                <li class="{{ Request::is('customer/bookings') || Request::is('customer/booking/*') || Request::is('update-booking/*')  ? 'active' : '' }}">
                    <a href="{{ route('customerBookings') }}" class="waves-effect waves-button">
                        <span class="menu-icon icon-calendar"></span>
                        <p>{{ __('backend.bookings') }}</p>
                    </a>
                </li>

                <li class="{{ Request::is('customer/bookings') || Request::is('customer/booking/*') || Request::is('update-booking/*')  ? 'active' : '' }}">
                    <a href="{{ route('customerDraws') }}" class="waves-effect waves-button">
                        <span class="menu-icon icon-calendar"></span>
                        <p>{{ __('backend.draws') }}</p>
                    </a>
                </li>
<!-- 
                <li class="{{ Request::is('customer/invoices') || Request::is('customer/invoice/*') ? 'active' : '' }}">
                    <a href="{{ route('customerInvoices') }}" class="waves-effect waves-button">
                        <span class="menu-icon icon-list"></span>
                        <p>{{ __('backend.invoices') }}</p>
                    </a>
                </li>
LA -->
                <li class="{{ Request::is('customer/profile') ? 'active' : '' }}">
                    <a href="{{ route('customerProfile') }}" class="waves-effect waves-button">
                        <span class="menu-icon icon-user"></span>
                        <p>{{ __('backend.my_profile') }}</p>
                    </a>
                </li>

                <li class="{{ Request::is('password/update') ? 'active' : '' }}">
                    <a href="{{ route('changePassword') }}" class="waves-effect waves-button">
                        <span class="menu-icon icon-lock"></span>
                        <p>{{ __('backend.change_password') }}</p>
                    </a>
                </li>

                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="waves-effect waves-button">
                        <span class="menu-icon icon-logout"></span>
                        <p>{{ __('backend.logout') }}</p>
                    </a>
                </li>

            </ul>
        </div><!-- Page Sidebar Inner -->
    </div><!-- Page Sidebar -->
    <div class="page-inner">

    @yield('content')

    <!-- Main Wrapper -->
        <div class="page-footer">
            <p class="no-s">
                {{ __('auth.copyrights') }}. &copy; {{ date('Y') }}. {{ __('auth.rights_reserved') }} {{ config('settings.business_name', 'Bookify') }}.
            </p>
        </div>
    </div><!-- Page Inner -->
</main><!-- Page Content -->
<div class="cd-overlay"></div>


<!-- Javascripts -->
<script src="{{ asset('plugins/jquery/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('plugins/pace-master/pace.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('plugins/waves/waves.min.js') }}"></script>
<script src="{{ asset('js/backend.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/js/jquery.datatables.min.js') }}"></script>
<script src="{{ asset('plugins/summernote-master/summernote.min.js') }}"></script>
<script src="{{ asset('js/pages/form-elements.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#xtreme-table').dataTable( {
            "aaSorting": [],
            "language": {
                @if(app()->getLocale() == "en")
                "url": "{{ asset('plugins/datatables/lang/en.json') }}"
                @elseif(app()->getLocale() == "es")
                "url": "{{ asset('plugins/datatables/lang/es.json') }}"
                @elseif(app()->getLocale() == "fr")
                "url": "{{ asset('plugins/datatables/lang/fr.json') }}"
                @elseif(app()->getLocale() == "de")
                "url": "{{ asset('plugins/datatables/lang/de.json') }}"
                @elseif(app()->getLocale() == "da")
                "url": "{{ asset('plugins/datatables/lang/da.json') }}"
                @elseif(app()->getLocale() == "it")
                "url": "{{ asset('plugins/datatables/lang/it.json') }}"
                @elseif(app()->getLocale() == "pt")
                "url": "{{ asset('plugins/datatables/lang/pt.json') }}"
                @endif
            }
        });
    });
</script>

					<script type="text/javascript">
					  function blink() {
						var blinks = document.getElementsByTagName('blink');
						for (var i = blinks.length - 1; i >= 0; i--) {
						  var s = blinks[i];
						  s.style.visibility = (s.style.visibility === 'visible') ? 'hidden' : 'visible';
						}
						window.setTimeout(blink, 1000);
					  }
					  if (document.addEventListener) document.addEventListener("DOMContentLoaded", blink, false);
					  else if (window.addEventListener) window.addEventListener("load", blink, false);
					  else if (window.attachEvent) window.attachEvent("onload", blink);
					  else window.onload = blink;
					</script>



@if(config('settings.freshchat_widget')!=NULL)
    <script src="https://wchat.freshchat.com/js/widget.js"></script>
    <script>
        window.fcWidget.init({
            token: "{{ config('settings.freshchat_widget') }}",
            host: "https://wchat.freshchat.com"
        });
        @if(Auth::user())
        window.fcWidget.setExternalId("{{ Auth::user()->id }}");
        window.fcWidget.user.setFirstName("{{ Auth::user()->first_name }}");
        window.fcWidget.user.setLastName("{{ Auth::user()->last_name }}");
        window.fcWidget.user.setEmail("{{ Auth::user()->email }}");
        @endif
    </script>
@endif

@yield('scripts')
</body>
</html>