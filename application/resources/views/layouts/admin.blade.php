<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>{{ $title }} | {{ config('settings.business_name') }} {{ __('backend.admin') }}</title>

    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta charset="UTF-8">
    <meta name="title" content="{{ $title }}" />
    <meta name="description" content="Admin Panel for {{ config('settings.business_name') }}." />
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
    <link href="{{ asset('plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('plugins/summernote-master/summernote.css') }}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{ asset('js/moment.min.js') }}" rel="stylesheet"></script>
    <script type="text/javascript" src="{{ asset('js/moment-es.min.js') }}" rel="stylesheet"></script>

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

@yield('template')

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
                            <a href="{{ route('bookings.index') }}">
                                <i class="icon-calendar text-success"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('users.index') }}">
                                <i class="icon-users text-info"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('settings.index') }}">
                                <i class="icon-settings text-danger"></i>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic toggle-fullscreen"><i class="fa fa-expand"></i></a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                <span class="user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}<i class="fa fa-angle-down"></i></span>
                                <img class="img-circle avatar" src="{{ Auth::user()->photo ? asset(Auth::user()->photo->file) : asset('images/profile-placeholder.png') }}" width="40" height="40"
                                     alt="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}">
                            </a>
                            <ul class="dropdown-menu dropdown-list" role="menu">
                                <li role="presentation"><a href="{{ route('users.edit', Auth::user()->id) }}"><i class="icon-user"></i>{{ __('backend.my_profile') }}</a></li>
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
                                <span><i class="icon-logout m-r-xs"></i>{{ __('backend.logout') }}</span>
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
                    <a href="{{ route('users.edit', Auth::user()->id) }}">
                        <div class="sidebar-profile-details">
                            <span>{{ __('backend.welcome') }} <br>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}<br><small>{{ ucfirst(Auth::user()->role->name) }}</small></span>
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

                <li class="{{ Request::is('bookings') || Request::is('bookings/*') || Request::is('invoice/*') ? 'active' : '' }}">
                    <a href="{{ route('bookings.index') }}" class="waves-effect waves-button">
                        <span class="menu-icon icon-calendar"></span>
                        <p>{{ __('backend.bookings') }}</p>
                    </a>
                </li>

                @if(config('settings.allow_to_cancel'))
                    <!--<li class="{{ Request::is('cancel-requests')  ? 'active' : '' }}">
                        <a href="{{ route('cancel-requests.index') }}" class="waves-effect waves-button">
                            <span class="menu-icon icon-close"></span>
                            <p>{{ __('backend.cancel_request_admin_menu') }}</p>
                        </a>
                    </li>-->

                <li class="droplink {{ Request::is('cancel-requests')  ? 'active' : '' }}">
                    <a class="waves-effect waves-button">
                        <span class="menu-icon icon-close"></span>
                        <p>{{ __('backend.cancel_request_admin_menu') }}</p>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" style="display: none;">  <!--style="display: block!important;" -->
                        <li class="{{ Request::is('cancel-requests') ? 'active' : '' }}">
							<!-- parámetro en index es ignorado ... -->
							<a href="{{ route('cancel-requests.index', 0) }}">{{ __('backend.current_cancel_request') }}</a>
						</li>
						
							<!-- ... por lo que se usa show que internamente llama a index y le pasa el parámetro -->
                        <li class="{{ Request::is('cancel-requests') ? 'active' : '' }}">
							<a href="{{ route('cancel-requests.show', 1) }}">{{ __('backend.historic_cancel_request') }}</a>
						</li>
                    </ul>
                </li>
					
                @endif

<!-- 

                @if(config('settings.offline_payments'))
                    <li class="{{ Request::is('unpaid-invoices') ? 'active' : '' }}">
                        <a href="{{ route('unpaidInvoices') }}" class="waves-effect waves-button">
                            <span class="menu-icon icon-energy"></span>
                            <p>{{ __('backend.unpaid_invoices') }}</p>
                        </a>
                    </li>
                @endif
LA -->

                <li class="{{ Request::is('events') || Request::is('events/*') ? 'active' : '' }}">
                    <a href="{{ route('events.index') }}" class="waves-effect waves-button">
                        <span class="menu-icon icon-calendar"></span>
                        <p>{{ __('backend.events') }}</p>
                    </a>
                </li>

                <li class="{{ Request::is('general-occupation') ? 'active' : '' }}">
                    <a href="{{ route('general-occupation.index') }}" class="waves-effect waves-button">
                        <span class="menu-icon icon-calendar"></span>
                        <p>{{ __('backend.general_occupation') }}</p>
                    </a>
                </li>

                <li class="{{ Request::is('draws') ? 'active' : '' }}">
                    <a href="{{ route('adminDraws') }}" class="waves-effect waves-button">
                        <span class="menu-icon icon-calendar"></span>
                        <p>{{ __('backend.draws') }}</p>
                    </a>
                </li>
				
                <li class="{{ Request::is('groups') || Request::is('groups/*') ? 'active' : '' }}">
                    <a href="{{ route('groups.index') }}" class="waves-effect waves-button">
                        <span class="menu-icon icon-user"></span>
                        <p>{{ __('backend.groups') }}</p>
                    </a>
                </li>				

                <li class="droplink {{ Request::is('users') || Request::is('users/*') ? 'active open' : '' }}">
                    <a class="waves-effect waves-button">
                        <span class="menu-icon icon-users"></span>
                        <p>{{ __('backend.users') }}</p>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" style="display: none;">
                        <li class="{{ Request::is('users') || Request::is('users/*/edit') ? 'active' : '' }}"><a href="{{ route('users.index') }}">{{ __('backend.all_users') }}</a></li>
                        <li class="{{ Request::is('users/create') ? 'active' : '' }}"><a href="{{ route('users.create') }}">{{ __('backend.add_new_user') }}</a></li>
                    </ul>
                </li>
				
                <li class="{{ Request::is('guests') || Request::is('guests/*') ? 'active' : '' }}">
                    <a href="{{ route('guests.index') }}" class="waves-effect waves-button">
                        <span class="menu-icon icon-globe"></span>
                        <p>{{ __('backend.guests') }}</p>
                    </a>
                </li>				

                <li class="{{ Request::is('blacklist') || Request::is('blacklist/*') ? 'active' : '' }}">
                    <a href="{{ route('blacklist.index') }}" class="waves-effect waves-button">
                        <span class="menu-icon icon-lock"></span>
                        <p>{{ __('backend.blacklist') }}</p>
                    </a>
                </li>				

                <li class="{{ Request::is('categories') || Request::is('categories/*') ? 'active' : '' }}">
                    <a href="{{ route('categories.index') }}" class="waves-effect waves-button">
                        <span class="menu-icon icon-briefcase"></span>
                        <p>{{ __('backend.categories') }}</p>
                    </a>
                </li>

                <li class="droplink {{ Request::is('packages') || Request::is('packages/*') ? 'active open' : '' }}">
                    <a class="waves-effect waves-button">
                        <span class="menu-icon icon-list"></span>
                        <p>{{ __('backend.packages') }}</p>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" style="display: none;">
                        <li class="{{ Request::is('packages') || Request::is('packages/*/edit') ? 'active' : '' }}"><a href="{{ route('packages.index') }}">{{ __('backend.all_packages') }}</a></li>
                        <li class="{{ Request::is('packages/create') ? 'active' : '' }}"><a href="{{ route('packages.create') }}">{{ __('backend.add_new_package') }}</a></li>
                        <li class="{{ Request::is('addons-parameters_by_addon') ? 'active' : '' }}" ><a href="{{ route('addons-parameters.index') }}">{{ __('backend.parameters_by_addon') }}</a></li>
                        <li class="{{ Request::is('packages-types') ? 'active' : '' }}"><a href="{{ route('packages-types.index') }}">{{ __('backend.packages_types') }}</a></li>
                        <li class="{{ Request::is('package-types-exception') ? 'active' : '' }}"><a href="{{ route('package-types-exception.index') }}">{{ __('backend.packages_type_exception') }}</a></li>
                        <li class="{{ Request::is('booking-times-package') ? 'active' : '' }}"><a href="{{ route('booking-times-package.index') }}">{{ __('backend.booking_times_package') }}</a></li>
                    </ul>
                </li>

                 <li class="{{ Request::is('court') || Request::is('court/*') ? 'active' : '' }}">
                    <a href="{{ route('court.index') }}" class="waves-effect waves-button">
                        <span class="fa fa-list-ol"></span>
                        <p>{{ __('backend.court') }}</p>
                    </a>
                </li>
				
                <li class="droplink {{ Request::is('addons') || Request::is('addons/*') ? 'active open' : '' }}">
                    <a class="waves-effect waves-button">
                        <span class="menu-icon icon-badge"></span>
                        <p>{{ __('backend.addons') }}</p>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" style="display: none;">
                        <li class="{{ Request::is('addons') || Request::is('addons/*/edit') ? 'active' : '' }}"><a href="{{ route('addons.index') }}">{{ __('backend.all_addons') }}</a></li>
                        <li class="{{ Request::is('addons/create') ? 'active' : '' }}"><a href="{{ route('addons.create') }}">{{ __('backend.add_new_addon') }}</a></li>
                    </ul>
                </li>
				
                <li class="droplink {{ Request::is('settings') || Request::is('booking-times') ? 'active open' : '' }}">
                    <a class="waves-effect waves-button">
                        <span class="menu-icon icon-settings"></span>
                        <p>{{ __('backend.settings') }}</p>
                        <span class="arrow"></span>
                    </a>
                    <ul class="sub-menu" style="display: none;">
                        <li class="{{ Request::is('settings') ? 'active' : '' }}"><a href="{{ route('settings.index') }}">{{ __('backend.settings') }}</a></li>
                        <li class="{{ Request::is('booking-times') ? 'active' : '' }}"><a href="{{ route('booking-times.index') }}">{{ __('backend.booking_times') }}</a></li>
						<li class="{{ Request::is('booking-times-package') ? 'active' : '' }}"><a href="{{ route('booking-times-package.index') }}">{{ __('backend.booking_times_package') }}</a></li>
                    </ul>


					
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
<script src="{{ asset('plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
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
@yield('scripts')
</body>
</html>