@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Session;
    $fitur_program = $fitur_program ?? [];
    $modul_aktif = Session::get('modul_aktif') ?? '';
    $menu_aktif = Session::get('menu_aktif') ?? '';
    $user_aktif = Auth::user();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>@yield('title'){{ env('APP_NAME') }}</title>
    <meta name="description" content="Updates and statistics" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

    @stack('middle_styles')

    <link href="{{ asset('assets/plugins/global/plugins.bundle.css?v=7.1.0') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.1.0') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css?v=7.1.0') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />

    <link rel="shortcut icon" type="image/png" href="{{ asset('lemon.png') }}" />
    @stack('styles')
</head>

<body id="kt_body" class="header-mobile-fixed subheader-enabled aside-enabled aside-fixed aside-secondary-enabled page-loading">

<div id="kt_header_mobile" class="header-mobile">
    <a href="{{ route('/') }}">
        <img alt="Logo" src="{{ asset('lemon.png') }}" class="logo-default max-h-30px" />
    </a>
    <div class="d-flex align-items-center">
        <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle"><span></span></button>
    </div>
</div>

<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-row flex-column-fluid page">
        <div class="aside aside-left d-flex aside-fixed" id="kt_aside">
            <div class="aside-primary d-flex flex-column align-items-center flex-row-auto">
                <div class="aside-brand d-flex flex-column align-items-center flex-column-auto py-5 py-lg-12">
                    <a href="{{ route('/') }}">
                        <img alt="Logo" src="{{ asset('lemon.png') }}" class="max-h-30px" />
                    </a>
                </div>

                <div class="aside-nav d-flex flex-column align-items-center flex-column-fluid py-5 scroll scroll-pull">
                    <ul class="nav flex-column" role="tablist">
                        @foreach($fitur_program as $key => $fitur)
                            @if($fitur->flag_akses == true)
                                <li class="nav-item mb-3" data-toggle="tooltip" data-placement="right" data-container="body" data-boundary="window" title="{{ $fitur->text }}">
                                    <a href="{{ \Illuminate\Support\Facades\Route::has($fitur->url) ? route($fitur->url): '#' }}" class="nav-link btn btn-icon btn-clean btn-lg {{ $fitur->text == $modul_aktif ? 'active' : '' }}" @if($fitur->url == '#') data-toggle="tab" data-target="#kt_aside_tab_{{ $key }}" role="tab" @endif>
                                        {!! $fitur->menu_icon !!}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="aside-footer d-flex flex-column align-items-center flex-column-auto py-4 py-lg-10">
                    <span class="aside-toggle btn btn-icon btn-primary btn-hover-primary shadow-sm" id="kt_aside_toggle" data-toggle="tooltip" data-placement="right" data-container="body" data-boundary="window" title="Toggle Aside">
                        <i class="ki ki-bold-arrow-back icon-sm"></i>
                    </span>
                    <a href="#" class="btn btn-icon btn-clean btn-lg w-40px h-40px" id="kt_quick_user_toggle" data-toggle="tooltip" data-placement="right" data-container="body" data-boundary="window" title="User Profil">
                        <span class="svg-icon svg-icon-primary svg-icon-2x"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"> <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <polygon points="0 0 24 0 24 24 0 24"/> <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/> <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero"/> </g> </svg></span>
                    </a>
                </div>

            </div>

            <div class="aside-secondary d-flex flex-row-fluid">
                <div class="aside-workspace scroll scroll-push my-2">
                    <div class="tab-content">
                        @foreach($fitur_program as $key => $fitur)
                            @if($fitur->flag_akses == true)
                                <div class="tab-pane {{ $fitur->text == $modul_aktif ? 'show active' : 'fade' }}" id="kt_aside_tab_{{ $key }}">
                                    <div class="aside-menu-wrapper flex-column-fluid px-10 py-5">
                                        <div class="aside-menu min-h-lg-800px" data-menu-vertical="1" data-menu-scroll="1">
                                            <ul class="menu-nav">
                                                @foreach($fitur->children as $menu)
                                                    @if($menu->flag_akses == true)
                                                        @if($menu->url == '')
                                                            <li class="menu-section">
                                                                <h4 class="menu-text">{{ $menu->text }}</h4>
                                                                <i class="menu-icon ki ki-bold-more-hor icon-md"></i>
                                                            </li>
                                                        @else
                                                            <li class="menu-item {{ $menu_aktif == $menu->url ? 'menu-item-active' : '' }}">
                                                                <a href="{{ \Illuminate\Support\Facades\Route::has($menu->url) ? route($menu->url) : '#' }}" class="menu-link">
                                                                    {!! $menu->menu_icon !!}
                                                                    <span class="menu-text">{{ $menu->text }}</span>
                                                                </a>
                                                            </li>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            @include('tools._alert')
            @yield('content')
            <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
                <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <div class="text-dark order-2 order-md-1">
                        <span class="text-muted font-weight-bold mr-2">{{ date('Y') }}©</span>
                        <a class="text-dark-75 text-hover-primary">Lemon</a>
                    </div>
                    <div class="nav nav-dark order-1 order-md-2">
                        <a href="https://renandatta.com/" target="_blank" class="nav-link pr-3 pl-0">by : Renandatta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="kt_quick_user" class="offcanvas offcanvas-left p-10">
    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">
        <h3 class="font-weight-bold m-0">User Profil</h3>
        <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">
            <i class="ki ki-close icon-xs text-muted"></i>
        </a>
    </div>
    <div class="offcanvas-content pr-5 mr-n5">
        <div class="d-flex align-items-center mt-5">
            <div class="symbol symbol-100 mr-5">
                <div class="symbol-label" style="background-image: url('{{ asset('lemon.png') }}');"></div>
                <i class="symbol-badge bg-success"></i>
            </div>
            <div class="d-flex flex-column">
                <a class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary">{{ $user_aktif->nama }}</a>
                <div class="text-muted mr-2">{{ $user_aktif->user_level->nama }}</div>
                <div class="navi mt-2">
                    <a href="#" class="navi-item">
                        <span class="navi-link p-0 pb-2">
                            <i class="flaticon-clock-2 mr-1"></i>
                            <span class="navi-text text-muted text-hover-primary">Terakhir login pada : <br>{{ $user_aktif->last_login->created_at ?? '' }}</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="separator separator-dashed mt-8 mb-5"></div>
        <div class="navi navi-spacer-x-0 p-0">
            <a href="{{ route('/') }}" class="navi-item">
                <div class="navi-link">
                    <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label"><i class="flaticon-user"></i></div>
                    </div>
                    <div class="navi-text">
                        <div class="font-weight-bold">Profil</div>
                        <div class="text-muted">Informasi user profil</div>
                    </div>
                </div>
            </a>
            <a href="{{ route('/') }}" class="navi-item">
                <div class="navi-link">
                    <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label"><i class="flaticon-edit"></i></div>
                    </div>
                    <div class="navi-text">
                        <div class="font-weight-bold">Ubah Password</div>
                        <div class="text-muted">Ubah password untuk login</div>
                    </div>
                </div>
            </a>
            <a href="{{ route('logout') }}" class="navi-item">
                <div class="navi-link">
                    <div class="symbol symbol-40 bg-light mr-3">
                        <div class="symbol-label"><i class="flaticon-logout"></i></div>
                    </div>
                    <div class="navi-text">
                        <div class="font-weight-bold">Logout</div>
                        <div class="text-muted">Keluar dari sistem</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<div id="kt_scrolltop" class="scrolltop">
    <span class="svg-icon">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24" />
                <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1" />
                <path
                    d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z"
                    fill="#000000"
                    fill-rule="nonzero"
                />
            </g>
        </svg>
    </span>
</div>

@stack('modals')

<script>
    let KTAppSettings = {
        breakpoints: { sm: 576, md: 768, lg: 992, xl: 1200, xxl: 1200 },
        colors: {
            theme: {
                base: { white: "#ffffff", primary: "#1BC5BD", secondary: "#E5EAEE", success: "#1BC5BD", info: "#6993FF", warning: "#FFA800", danger: "#F64E60", light: "#F3F6F9", dark: "#212121" },
                light: { white: "#ffffff", primary: "#1BC5BD", secondary: "#ECF0F3", success: "#C9F7F5", info: "#E1E9FF", warning: "#FFF4DE", danger: "#FFE2E5", light: "#F3F6F9", dark: "#D6D6E0" },
                inverse: { white: "#ffffff", primary: "#ffffff", secondary: "#212121", success: "#ffffff", info: "#ffffff", warning: "#ffffff", danger: "#ffffff", light: "#464E5F", dark: "#ffffff" },
            },
            gray: { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" },
        },
        "font-family": "Poppins",
    };
</script>

<script src="{{ asset('assets/plugins/global/plugins.bundle.js?v=7.1.0') }}"></script>
<script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.1.0') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js?v=7.1.0') }}"></script>

<script src="{{ asset('assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js?v=7.0.8') }}"></script>
<script src="{{ asset('assets/js/pages/crud/forms/widgets/bootstrap-timepicker.js?v=7.0.8') }}"></script>
<script src="{{ asset('assets/js/autoNumeric.js') }}"></script>
<script src="{{ asset('assets/js/pages/features/miscellaneous/sweetalert2.js?v=7.1.0') }}"></script>

<script>
    $('input').attr('autocomplete', 'off');

    $('.select2').select2();
    $('.kt-selectpicker').selectpicker();
    $('.kt-timepicker').timepicker({
        showSeconds: true,
        showMeridian: false
    });

    let arrows = {
        leftArrow: '<i class="la la-angle-left"></i>',
        rightArrow: '<i class="la la-angle-right"></i>'
    };
    $('.kt-datepicker').datepicker({
        todayHighlight: true,
        orientation: "bottom left",
        templates: arrows,
        format: 'dd-mm-yyyy',
        autoclose: true
    });
    $('.kt-datepicker-month').datepicker({
        viewMode: "months",
        minViewMode: "months",
        todayHighlight: true,
        orientation: "bottom left",
        templates: arrows,
        format: 'mm-yyyy',
        autoclose: true
    });

    let $autonumeric = $('.autonumeric'),
        $autonumericDecimal = $('.autonumeric-decimal');
    $autonumeric.attr('data-a-sep','.');
    $autonumeric.attr('data-a-dec',',');
    $autonumeric.autoNumeric({mDec: '0',vMax:'9999999999999999999999999', vMin: '-99999999999999999'});
    $autonumericDecimal.attr('data-a-sep','.');
    $autonumericDecimal.attr('data-a-dec',',');
    $autonumericDecimal.autoNumeric({mDec: '2',vMax:'999'});

    function add_commas(nStr) {
        nStr += '';
        let x = nStr.split('.');
        let x1 = x[0];
        let x2 = x.length > 1 ? '.' + x[1] : '';
        let rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }
    function remove_commas(nStr) {
        nStr = nStr.replace(/\./g,'');
        return nStr;
    }
</script>
@stack('scripts')
</body>

</html>
