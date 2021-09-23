<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ Setting::get('SITE_NAME') }} - @yield('title')</title>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="RealEstate Management System">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--  Desktop Favicons  -->
        <link rel="icon" type="image/png" href="{{ Setting::get('ICON') }}" sizes="32x32">
        <!-- Main CSS-->
        <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/main.css')}}">
        <!-- Font-icon css-->
        <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/font-awesome.css')}}">
        <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/font-awesome.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{URL::asset('css/custom.css')}}">
        <link rel="stylesheet" type="text/css" href="{{URL::asset('back-end/css/listswap.css')}}">

        <link rel="stylesheet" href="{{URL::asset('back-end/css/normalize.css')}}"/>
        <link rel="stylesheet" href="{{URL::asset('back-end/css/planit.css')}}"/>
        <script type="text/javascript" src="{{URL::asset('back-end/js/modernizr-2.8.3.min.js')}}"></script>
        @yield('style')
        <style type="text/css">
            @font-face{
                font-family: 'Hanuman Regular';
                src: url('{{ asset('back-end/fonts/Hanuman-Regular.ttf') }}') format("truetype");
            }
            *{
                font-family: Hanuman Regular;
            }
            ::-webkit-scrollbar {
                width: 1em;
            }
            ::-webkit-scrollbar-thumb {
                background: linear-gradient(transparent,gray) !important;
                box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.2) !important;
                border-radius: 5px;
            }

            ::-webkit-scrollbar-track:hover{
                display: block;
            }   
            .input-group-text-position, .input-group-text-department, .input-group-text-sale_type {
                cursor: pointer;
            }
            .table-nowrap tr th, .table-nowrap tr td{
                white-space: nowrap;
            }
            ul.dropdown-menu.settings-menu.dropdown-menu-right.show {
                width: 15em;
            }
            .file-preview-thumbnails{
                overflow: hidden;
            }
            .app-header__logo{
                background-color: #ffff;
            }
            /* .app-header{
                background-color: #002959;
            } */

        </style>

    </head>
    <div id="loadingDiv" style="
        position: fixed;
        left:0;
        top:0;
        width: 100%;
        height: 100vh;
        background: rgba(0,0,0,0.1);
        z-index: 10000;
        text-align: center;
        vertical-align: center;
    ">
        <img style="position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        transform: -webkit-translate(-50%, -50%);
        transform: -moz-translate(-50%, -50%);
        transform: -ms-translate(-50%, -50%);"
        src="{{ asset('back-end/loading/loader.gif') }}">
    </div>
    <body class="app sidebar-mini rtl" style="position: relative;">
        <!-- Navbar-->
        <header class="app-header"><a class="app-header__logo" href="{{ url('/') }}" style="padding: 0 0;line-height: 40px;">
            <img src="{{Setting::get('LOGO')}}" style="height: 50px;">
        </a>
            <!-- Sidebar toggle button-->
            <a class="app-sidebar__toggle" hresf="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
            <!-- Navbar Right Menu-->
            <ul class="app-nav">
                <!-- User Menu-->
                <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
                    <ul class="dropdown-menu settings-menu dropdown-menu-right">

                        <li><a class="dropdown-item" href="#"><i class="fa fa-cog fa-lg"></i> {{ __('item.settings') }}</a></li>
                        <li><a class="dropdown-item" href="{{route('user.profile', auth()->id())}}"><i class="fa fa-user fa-lg"></i> {{ __('item.profile') }}</a></li>
                        <li><a class="dropdown-item" href="{{route('user.change-password')}}"><i class="fa fa-key fa-lg"></i> {{ __('item.change_password') }}</a></li>

                        <li>
                          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-lg"></i>{{ __('item.logout') }}</a>
                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </li>
                    </ul>
                </li>
                <!-- End User Menu-->
                <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-globe" aria-hidden="true" style="font-size: 20px;"></i> {{ __('item.language') }}</a>
                    <ul class="dropdown-menu settings-menu dropdown-menu-right">
                        <li class="nav-item"><a class="dropdown-item nav-link" href="{{ url('locale/en') }}"><img src="{{ URL::asset('/public/images/en-round.png') }}"> {{ __('item.english') }}</a></li>
                        <li class="nav-item"><a class="dropdown-item nav-link" href="{{ url('locale/kh') }}"><img src="{{ URL::asset('/public/images/cambodia-round.png') }}"> {{ __('item.khmer') }}</a></li>
                    </ul>
                </li>
            </ul>
        </header>

    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
        <!-- Block User Authorize -->
        <div class="app-sidebar__user">
            @php
                $url = asset('back-end/img/user.png');
                if($user_profile != null && file_exists(public_path($user_profile)))
                    $url = asset('public'.$user_profile);
            @endphp
            <img class="app-sidebar__user-avatar" src="{{$url}}">
            <div>
                <p class="app-sidebar__user-name">{{ Auth::user()->name }}</p>
                <p class="app-sidebar__user-designation">{{ Auth::user()->userRole()->first()->role->name }}</p>
            </div>
        </div>
        <!-- End Block User Authorize -->

        <!-- Block Sidebar -->
        <ul class="app-menu">

            <!-- Dashboard -->
            <li><a class="app-menu__item {{Request::is('dashboard')?'active':''}}" href="{{ url('/') }}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">{{ __('item.dashboard') }}</span></a></li>
            
            @if(Auth::user()->can('list-customer') || $isAdministrator)
                <li><a class="app-menu__item {{Request::is('customer', "customer/*")?'active':''}}" href="{{ url('customer') }}"><i class="app-menu__icon fa fa-address-book" aria-hidden="true"></i><span class="app-menu__label">{{ __('item.customer') }}</span></a></li>
            @endif

            @if(Auth::user()->can('list-employee') || $isAdministrator)
                <!-- Project Action -->
                <li class="treeview {{Request::is('sale-type','sale-type/create', 'sale-type/*/edit','employee/add', 'department' ,'department/*/edit', 'department/create', 'employee','employee/*/edit', 'position', 'position/create', 'position/*/edit')?'is-expanded':''}}"><a class="app-menu__item {{Request::is('employee/create', 'employee','employee/*/edit', 'projectzone', 'projectzone/create', 'projectzone/*/edit')?'active':''}}" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-user"></i><span class="app-menu__label">{{ __('item.employee') }}</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                    <ul class="treeview-menu">
                        @if(Auth::user()->can('list-position') || $isAdministrator)
                            <li><a class="treeview-item {{Request::is('position','employee/create','position/*/edit')?'active':''}}" href="{{ route('position.index') }}"><i class="icon fa fa-exchange pr-1"></i>{{ __('item.position') }}</a></li>
                        @endif  

                        @if(Auth::user()->can('list-department') || $isAdministrator)
                            <li><a class="treeview-item {{Request::is('department','department/*/edit', 'department/create')?'active':''}}" href="{{ route('department.index') }}"><i class="icon fa fa-suitcase pr-1"></i>{{ __('item.department') }}</a></li>
                        @endif

                        @if(Auth::user()->can('list-sale-type') || $isAdministrator)
                            <li><a class="treeview-item {{Request::is('sale-type','sale-type/create', 'sale-type/*/edit')?'active':''}}" href="{{ route('sale-type.index') }}"><i class="icon fa fa-life-ring pr-1"></i>{{ __('item.sale_type') }}</a></li>
                        @endif

                        @if(Auth::user()->can('list-employee') || $isAdministrator)
                            <li><a class="treeview-item {{Request::is('employee', 'employee/add', 'employee/*/edit')?'active':''}}" href="{{ url('employee') }}"><i class="icon fa fa-user pr-1"></i>{{ __('item.employee') }}</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            @if(Auth::user()->can('list-exspense-group') || Auth::user()->can('list-general-expense') || $isAdministrator)
                <!-- Project Action -->
                <li class="treeview {{Request::is('expense_group','expense_group/create','expense_group/*/edit','general_expense','general_expense/create','general_expense/*/edit')?'active':''}}">
                    <a class="app-menu__item {{Request::is('expense_group','expense_group/create','expense_group/*/edit','general_expense','general_expense/create','general_expense/*/edit')?'active':''}}" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-credit-card"></i><span class="app-menu__label">{{ __('item.expense') }}</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                    <ul class="treeview-menu">
                        @if(Auth::user()->can('list-exspense-group') || $isAdministrator)
                            <li><a class="treeview-item {{Request::is('expense_group','expense_group/create','expense_group/*/edit')?'active':''}}" href="{{ route('expense_groups') }}"><i class="icon fa fa-tag pr-1"></i>{{ __('item.expense_type') }}</a></li>
                        @endif
                        @if(Auth::user()->can('list-general-expense') || $isAdministrator)
                            <li><a class="treeview-item {{Request::is('general_expense','general_expense/create','general_expense/*/edit')?'active':''}}" href="{{ route('general_expenses') }}"><i class="icon fa fa-money pr-1"></i>{{ __('item.expense') }}</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            {{-- @if(Auth::user()->can('list-product') || $isAdministrator)
                <li><a class="app-menu__item @if(Route::is('productList') || Route::is('productCreate') || Route::is('productEdit') || Route::is('product.units') || Route::is('product.unit.create') || Route::is('product.unit.edit') || Route::is('product.categories') || Route::is('product.category.create') || Route::is('product.category.edit')) active @endif" href="{{ route('productList') }}"><i class="app-menu__icon fa fa-product-hunt"></i><span class="app-menu__label">{{ __('item.product') }}</span></a></li> 
            @endif
            @if(Auth::user()->can('list-inventory') || $isAdministrator)
                 <li><a class="app-menu__item @if(Route::is('inventories')) active @endif" href="{{route('inventories')}}"><i class="app-menu__icon fa fa-houzz"></i><span class="app-menu__label">{{ __('item.inventory') }}</span></a></li> 
            @endif
            @if(Auth::user()->can('list-purchase') || $isAdministrator)
                 <li><a class="app-menu__item @if(Route::is('purchases') || Route::is('purchase.create') || Route::is('purchase.edit') || Route::is('purchase.view')) active @endif" href="{{route('purchases')}}"><i class="app-menu__icon fa fa-cart-arrow-down"></i><span class="app-menu__label">{{ __('item.purchase') }}</span></a></li> 
            @endif
            @if(Auth::user()->can('list-subtract-inventory') || $isAdministrator)
                <li><a class="app-menu__item @if(Route::is('subtract_inventories') || Route::is('subtract_inventory.create') || Route::is('subtract_inventory.edit') || Route::is('subtract_inventory.view')) active @endif" href="{{route('subtract_inventories')}}"><i class="app-menu__icon fa fa-minus-square"></i><span class="app-menu__label">{{ __('item.subtract_inventory') }}</span></a></li> 
            @endif
            @if(Auth::user()->can('list-supplyer') || $isAdministrator)
                <li><a class="app-menu__item @if(Route::is('supplyers') || Route::is('supplyer.create') || Route::is('supplyer.edit')) active @endif" href="{{ route('supplyers') }}"><i class="app-menu__icon fa fa-industry" aria-hidden="true"></i><span class="app-menu__label">{{ __('item.supplier') }}</span></a></li> 
            @endif --}}
            {{-- @if(Auth::user()->can('list-sale') || $isAdministrator)
                 <li><a class="app-menu__item {{Request::is('sale','sale/*')?'active':''}}" href="{{route('sale.index')}}"><i class="app-menu__icon fa fa-cart-arrow-down"></i><span class="app-menu__label">{{ __('item.sale') }}</span></a></li>
            @endif --}}

            @if(Auth::user()->can('list-land') || $isAdministrator)
                <!-- Land Action -->
                <li style = "display:none;" class="treeview"><a class="app-menu__item {{Request::is('land', 'land/create','land/*/edit')?'active':''}}" href="{{ route('land') }}"><i class="app-menu__icon fa fa-globe"></i><span class="app-menu__label">{{ __('item.land') }}</span><i class="treeview-indicator"></i></a>
                </li> 
            @endif

            @if(Auth::user()->can('list-project') || Auth::user()->can('list-project-zone') || $isAdministrator)
                <!-- Project Action -->
                <li style = "display:none;" class="treeview {{Request::is('project/create', 'project','project/*/edit', 'projectzone', 'projectzone/create', 'projectzone/*/edit')?'is-expanded':''}}"><a class="app-menu__item {{Request::is('project/create', 'project','project/*/edit', 'projectzone', 'projectzone/create', 'projectzone/*/edit')?'active':''}}" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-university"></i><span class="app-menu__label">{{ __('item.project') }}</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                    <ul class="treeview-menu">
                        @if(Auth::user()->can('list-project') || $isAdministrator)
                            <li><a class="treeview-item {{Request::is('project')?'active':''}}" href="{{ route('project') }}"><i class="icon fa fa-industry pr-1"></i>{{ __('item.project') }}</a></li>
                        @endif  

                        @if(Auth::user()->can('list-property-zone') || $isAdministrator)
                            <li><a class="treeview-item {{Request::is('projectzone')?'active':''}}" href="{{ route('projectzone') }}"><i class="icon fa fa-list pr-1"></i>{{ __('item.project_zone') }}</a></li>
                        @endif
                    </ul>
                </li>
            @endif            

            @if(Auth::user()->can('list-property') || Auth::user()->can('list-property-type') || $isAdministrator)
                <!-- Property Action -->
                <li class="treeview {{Request::is('property', 'property/create','property/*/edit')?'is-expanded':''}}"><a class="app-menu__item {{Request::is('property', 'property/create','property/*/edit')?'active':''}}" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-money"></i><span class="app-menu__label">{{ __('លក់ និង​បង់រំលស់') }}</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                    <ul class="treeview-menu">
                        @if(Auth::user()->can('list-property') || Auth::user()->can('list-property-type') || $isAdministrator)
                            
                        {{-- <li><a class="treeview-item {{Request::is('property')?'active':''}}" href="{{ route('property') }}"><i class="icon fa fa-home pr-1"></i>{{ __('item.land') }}</a></li>  --}}
                        {{-- <li><a class="treeview-item {{Request::is('vehicle')?'active':''}}" href="{{ route('vehicle') }}"><i class="icon fa fa-building pr-1"></i>{{ __('item.car/motor') }}</a></li>--}}
                        <li><a class="treeview-item {{Request::is('others')?'active':''}}" href="{{ route('others') }}"><i class="icon fa fa-building pr-1"></i>{{ __('item.others') }}</a></li> 
                        
                            
                            <!-- <li><a class="treeview-item {{Request::is('property')?'active':''}}" href="{{ route('property') }}"><i class="icon fa fa-building pr-1"></i>{{ __('item.property') }}</a></li> -->
                        @endif
                        @if(Auth::user()->can('list-property') || Auth::user()->can('list-property-type') || $isAdministrator)
                            <!-- <li><a class="treeview-item {{Request::is('propertytype')?'active':''}}" href="{{ route('propertytype') }}"><i class="icon fa fa-list pr-1"></i>{{ __('item.property_types') }}</a></li> -->
                        @endif
                    </ul>
                </li>
            @endif

            @if(Auth::user()->can('list-payment-stage') || $isAdministrator)
                <li  class="treeview"><a class="app-menu__item {{Request::is('payment_stages', 'payment_stage/*')?'active':''}}" href="{{ route('payment_stages') }}"><i class="app-menu__icon fa fa-tag"></i><span class="app-menu__label">{{ __('item.payment_method') }}</span><i class="treeview-indicator"></i></a>
                </li>
            @endif

            {{-- @if(Auth::user()->can('list-timeline') || $isAdministrator)
                <li class="treeview"><a class="app-menu__item {{Request::is('payment-timeline', 'payment-timeline/create','payment-timeline/*/edit')?'active':''}}" href="{{ route('payment-timeline.index') }}"><i class="app-menu__icon fa fa-map"></i><span class="app-menu__label">{{ __('item.payment_timeline') }}</span><i class="treeview-indicator"></i></a>
                </li>
            @endif --}}

            @if(Auth::user()->can('list-user') || Auth::user()->can('list-user-group') || $isAdministrator)
                <li class="treeview {{Request::is('roles/*', 'roles', 'users', 'users/*')?'is-expanded':''}}">
                    <a class="app-menu__item {{Request::is('roles/*', 'roles')?'active':''}}" href="#" data-toggle="treeview">
                        <i class="app-menu__icon fa fa-building"></i><span class="app-menu__label">{{ __('item.authentication') }}</span>
                        <i class="treeview-indicator fa fa-angle-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        @if(Auth::user()->can('list-user-group') || $isAdministrator)
                            <li>
                                <a class="treeview-item {{Request::is('roles/*', 'roles')?'active':''}}" href="{{ route('roles') }}" class="app-menu__item ">
                                    <span class="title"><i class="icon fa fa-users"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.user_group') }}</span>
                                </a>
                            </li>
                        @endif
                        @if(Auth::user()->can('list-user') || $isAdministrator)
                            <li>
                                <a class="treeview-item {{Request::is('users/*', 'users')?'active':''}}" href="{{ route('users') }}" class="app-menu__item ">
                                    <span class="title"><i class="icon fa fa-user"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.user') }} </span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <li class="treeview @if(Route::is('report.index') || Route::is('loan_report') || Route::is('sale_detail_report') || Route::is('land_report') ||  Route::is('zone_report') || Route::is('customer_report') || Route::is('property_report') || Route::is('project_report') || Route::is('sale_report') || Route::is('payment_report') || Route::is('deposit_report') || Route::is('commission_report') || Route::is('receivable_report') || Route::is('expense_report') || Route::is('purchase_report') || Route::is('purchase_detail_report') || Route::is('property_price_report')) is-expanded @endif">
                <a class="app-menu__item {{Request::is('report/*')?'active':''}}" href="#" data-toggle="treeview">
                    <i class="app-menu__icon fa fa-line-chart"></i><span class="app-menu__label">{{ __('item.report') }}</span>
                    <i class="treeview-indicator fa fa-angle-right"></i>
                </a>
                <ul class="treeview-menu">
                    {{-- <li>
                        <a class="treeview-item @if(Route::is('report.index')) active @endif" href="{{url('report')}}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-cart-arrow-down"></i> {{ __('item.sale_process_report') }}</span>
                        </a>
                    </li> --}}
                    <li>
                        <a class="treeview-item @if(Route::is('sale_report')) active @endif" href="{{ route('sale_report') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-globe"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.sale_report') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item @if(Route::is('sale_detail_report')) active @endif" href="{{ route('sale_detail_report') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-bar-chart"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.sale_detail_report') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item @if(Route::is('loan_report')) active @endif" href="{{ route('loan_report') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-globe"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.loan_report') }}</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a class="treeview-item @if(Route::is('land_report')) active @endif" href="{{ route('land_report') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-globe"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.land_report') }}</span>
                        </a>
                    </li> --}}
                     {{-- <li>
                        <a class="treeview-item @if(Route::is('project_report')) active @endif" href="{{ route('project_report') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-globe"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.project_report') }}</span>
                        </a>
                    </li> --}}
                    {{-- <li>
                        <a class="treeview-item @if(Route::is('zone_report')) active @endif" href="{{ route('zone_report') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-list"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.zone_report') }}</span>
                        </a>
                    </li> --}}
                    <li>
                        <a class="treeview-item @if(Route::is('customer_report')) active @endif" href="{{ route('customer_report') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-address-book"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.customer') }}</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a class="treeview-item @if(Route::is('property_report')) active @endif" href="{{ route('property_report') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-building"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.property_report') }}</span>
                        </a>
                    </li> --}}
                    <li>
                        <a class="treeview-item @if(Route::is('property_price_report')) active @endif" href="{{ route('property_price_report') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-building"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.property_price_report') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item @if(Route::is('payment_report')) active @endif" href="{{ route('payment_report') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-building"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.receipt_report') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="treeview-item @if(Route::is('payment_report')) active @endif" href="{{ route('late_payment') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-building"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.date_payment') }}</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a class="treeview-item @if(Route::is('deposit_report')) active @endif" href="{{ route('deposit_report') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-building"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.deposit_report') }}</span>
                        </a>
                    </li> 
                     {{-- <li>
                        <a class="treeview-item @if(Route::is('receivable_report')) active @endif" href="{{ route('receivable_report') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-building"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.receivable_report') }}</span>
                        </a>
                    </li> --}}
                    {{-- <li>
                        <a class="treeview-item @if(Route::is('commission_report')) active @endif" href="{{ route('commission_report') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-building"></i> {{ __('item.commission_report') }}</span>
                        </a>
                    </li> --}}
                    <li>
                        <a class="treeview-item @if(Route::is('expense_report')) active @endif" href="{{ route('expense_report') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-building"></i> {{ __('item.expense_report') }}</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a class="treeview-item @if(Route::is('purchase_report')) active @endif" href="{{ route('purchase_report') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-building"></i> {{ __('item.purchase_report') }}</span>
                        </a>
                    </li> --}}
                    {{-- <li>
                        <a class="treeview-item @if (Route::is('purchase_detail_report')) active @endif" href="{{ route('purchase_detail_report') }}" class="app-menu__item ">
                            <span class="title"><i class="icon fa fa-building"></i>{{ __('item.purchase_detail_report') }}</span>
                        </a>
                    </li> --}}
                </ul>
            </li>
            @if(Auth::user()->can('settings') || $isAdministrator || Auth::user()->can('public_holidays') || Auth::user()->can('penalties'))
                <li class="treeview {{Request::is('setting/*', 'config', 'setting', 'setting/*','public_holiday', 'public_holiday/*')?'is-expanded':''}}">
                    <a class="app-menu__item {{Request::is('setting/*', 'config','public_holiday', 'public_holiday/*')?'active':''}}" href="#" data-toggle="treeview">
                        <i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">{{ __('item.settings') }}</span>
                        <i class="treeview-indicator fa fa-angle-right"></i>
                    </a>
                    <ul class="treeview-menu">
                        @if(Auth::user()->can('settings') || $isAdministrator)
                            <li>
                                <a class="treeview-item {{Request::is('setting/config', "config")?'active':''}}" href="{{url('setting/config')}}" class="app-menu__item ">
                                    <span class="title"><i class="icon fa fa-wrench"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.config') }}</span>
                                </a>
                            </li>
                        @endif
                        @if(Auth::user()->can('public_holiday') || $isAdministrator)
                            <li>
                                <a class="treeview-item {{Route::is('public_holidays')?'active':''}}" href="{{ route('public_holidays') }}" class="app-menu__item ">
                                    <span class="title"><i class="icon fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.public_holiday') }}</span>
                                </a>
                            </li>
                        @endif
                        @if(Auth::user()->can('list_province') || $isAdministrator)
                            <li>
                                <a class="treeview-item {{Route::is('setting.address.province.index') || Request::is('setting/address/*')?'active':''}}" href="{{ route('setting.address.province.index') }}" class="app-menu__item ">
                                    <span class="title"><i class="icon fa fa-map-marker"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.list_province') }}</span>
                                </a>
                            </li>
                        @endif
                        {{-- @if(Auth::user()->can('penalties') || $isAdministrator)
                            <li>
                                <a class="treeview-item {{Route::is('penalties')?'active':''}}" href="{{ route('penalties') }}" class="app-menu__item ">
                                    <span class="title"><i class="icon fa fa-ban"></i>&nbsp;&nbsp;&nbsp;&nbsp;{{ __('item.penalty') }}</span>
                                </a>
                            </li>
                        @endif --}}
                    </ul>
                </li>
            @endif

            <li>&nbsp;</li>
            <li>&nbsp;</li>

        </ul>
        <!-- End Block Sidebar -->
    </aside>
    

    <!-- Block Content -->

    @yield('content')

    @include('back-end.employee.custom_modal')

    <!-- End Block Content -->

    <!-- Essential javascripts for application to work-->
    <script type="text/javascript" src="{{URL::asset('back-end/js/jquery-3.2.1.min.js')}}"></script>

    <script type="text/javascript" src="{{URL::asset('back-end/js/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('back-end/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{URL::asset('back-end/js/main.js')}}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script type="text/javascript" src="{{URL::asset('back-end/js/plugins/pace.min.js')}}"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="{{URL::asset('back-end/js/plugins/chart.js')}}"></script>
    <script type="text/javascript" src="{{url('back-end/js/jquery.listswap.js')}}"></script>
    <script type="text/javascript" src="{{ URL::asset('back-end/js/select2.min.js') }}"></script>
    <!-- Internal From Active Page -->
    <script type="text/javascript" src="{{URL::asset('back-end/js/plugins/sweetalert.min.js')}}"></script>
    @yield('script')
    <script type="text/javascript">
    $('input[type=submit], button[type=submit]').click(function() {
        $(this).attr('disabled', 'disabled');
        $(this).parents('form').submit();
    });
        // Check Loading
        var $loading = $('#loadingDiv');
        let stateCheck = setInterval(() => {
            if (document.readyState === 'complete') {
                clearInterval(stateCheck);
                $loading.hide();
            }
        }, 100);
        $('form').submit(function(){
            $loading.show();
        });
        $(document).ajaxStart(function () {
            $loading.show();
        }).ajaxStop(function () {
            $loading.hide();
        });
        // End Loading
        $(document).ready(function() {
            _token = $('input[name=_token]').val();
            $('input').attr( "autocomplete", "off" );
            $('.input-group-text-position').on('click', function() {
                $('.btn-add-position').trigger('click');
            });
            $('.btn-save-position').on('click', function() {
                url = $(this).attr('data-url');
                positino_title = $('input[name=positino_title]').val();
                $.ajax({
                    url: url, 
                    method: 'POST',
                    data: {_token:_token, title:positino_title},
                    success: function(result){
                        if(result.status) {
                            var html_position = "";
                            $.each(result.positions, function (key, val) {
                                html_position += "<option selected value='"+ key +"'>" + val + "</option>";
                            });
                            $('#select-position').append(html_position);
                            // $('.btn-close-position').trigger('click');
                            $('input[name=positino_title]').val('');
                            $('.display_message').html(result.success);
                            $("#modal-modal-position").hide();
                            setTimeout(function(){ $('.display_message').html(''); }, 3000);

                            return false;
                        }
                        $('.display_message').html(result.error);
                        $('input[name=positino_title]').focus();
                        setTimeout(function(){ $('.display_message').html(''); }, 2000);
                    }
                });
            });

            $('.input-group-text-department').on('click', function() {
                $('.btn-add-department').trigger('click');
            });
            $('.btn-save-department').on('click', function() {
                url = $(this).attr('data-url');
                department_title = $('input[name=department_title]').val();
                $.ajax({
                    url: url, 
                    method: 'POST',
                    data: {_token:_token, title:department_title},
                    success: function(result){
                        if(result.status) {
                            var html_departments = "";
                            $.each(result.departments, function (key, val) {
                                html_departments += "<option selected value='"+ key +"'>" + val + "</option>";
                            });
                            $('#select-department').append(html_departments);
                            $('input[name=department_title]').val('');
                            $('.display_message').html(result.success);
                            $("#modal-modal-department").hide();
                            setTimeout(function(){ $('.display_message').html(''); }, 3000);
                            return false;
                        }
                        $('.display_message').html(result.error);
                        $('input[name=department_title]').focus();
                        setTimeout(function(){ $('.display_message').html(''); }, 2000);
                    }
                });
            });

            $('.input-group-text-sale_type').on('click', function() {

                if($("#check_sale").is(":checked")) {
                    $('.btn-add-sale-type').trigger('click');
                }
                return false;
            });
            $('.btn-save-sale-type').on('click', function() {
                url = $(this).attr('data-url');
                sale_type_title = $('input[name=sale_type_title]').val();
                $.ajax({
                    url: url, 
                    method: 'POST',
                    data: {_token:_token, name:sale_type_title},
                    success: function(result){
                        if(result.status) {
                            var html_sale_types = "";
                            $.each(result.sale_types, function (key, val) {
                                html_sale_types += "<option selected value='"+ key +"'>" + val + "</option>";
                            });
                            $('.select-sale-type').append(html_sale_types);
                            $('input[name=sale_type_title]').val('');
                            $('.display_message').html(result.success);
                            $("#modal-modal-sale-type").hide();
                            setTimeout(function(){ $('.display_message').html(''); }, 3000);
                            return false;
                        }
                        $('.display_message').html(result.error);
                        $('input[name=sale_type_title]').focus();
                        setTimeout(function(){ $('.display_message').html(''); }, 2000);
                    }
                });
            });

        }); 
        $(document).ready(function() {
            $('.select2-option-picker').select2();
        });
    </script>
    <!-- End -->
    
  </body>
</html>