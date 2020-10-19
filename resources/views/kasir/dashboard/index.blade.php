@extends('layouts.main')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="subheader py-3 py-lg-8 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <h2 class="subheader-title text-dark font-weight-bold my-1 mr-3">{{ $title }}</h2>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                </div>
            </div>
        </div>

        <div class="d-flex flex-column-fluid">
            <div class="container">
                <div class="card card-custom gutter-b">
                    <div class="card-body p-0">
                        <div class="d-flex align-items-center justify-content-between card-spacer flex-grow-1">
                                    <span class="symbol symbol-circle symbol-50 symbol-light-info mr-2">
                                        <span class="symbol-label">
                                            <span class="svg-icon svg-icon-xl svg-icon-info">
                                                <!--begin::Svg Icon | path:/metronic/theme/html/demo3/dist/assets/media/svg/icons/Shopping/Cart3.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                        <path d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z" fill="#000000" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                    </span>
                            <div class="d-flex flex-column text-right">
                                <span class="text-dark-75 font-weight-bolder font-size-h3">Rp. {{ format_number($total_penjualan) }}</span>
                                <span class="text-muted font-weight-bold mt-2">Total Penjualan Hari Ini</span>
                            </div>
                        </div>
                        <div id="chart_penjualan_minggu_ini" class="card-rounded-bottom" data-color="info" style="height: 150px"></div>
                    </div>
                </div>
                <div class="card card-custom">
                    <div class="card-header border-0">
                        <h3 class="card-title font-weight-bolder text-dark">Produk Paling Banyak Terjual</h3>
                        <div class="card-toolbar">
                            <div class="dropdown dropdown-inline">
                                <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ki ki-bold-more-ver"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                    <ul class="navi">
                                        <li class="navi-item">
                                            <a href="javascript:void(0)" onclick="search_terlaris('semua')" class="navi-link">
                                                <span class="navi-text">Keseluruhan</span>
                                                <span class="navi-label check-terlaris" id="terlaris_check_semua">
                                                </span>
                                            </a>
                                            <a href="javascript:void(0)" onclick="search_terlaris('hari')" class="navi-link">
                                                <span class="navi-text">Hari Ini</span>
                                                <span class="navi-label check-terlaris" id="terlaris_check_hari">
                                                </span>
                                            </a>
                                            <a href="javascript:void(0)" onclick="search_terlaris('minggu')" class="navi-link">
                                                <span class="navi-text">Minggu Ini</span>
                                                <span class="navi-label check-terlaris" id="terlaris_check_minggu">
                                                </span>
                                            </a>
                                            <a href="javascript:void(0)" onclick="search_terlaris('bulan')" class="navi-link">
                                                <span class="navi-text">Bulan Ini</span>
                                                <span class="navi-label check-terlaris" id="terlaris_check_bulan">
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0" id="list_terlaris">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let _initChartPenjualanMingguIni = function () {
            let element = document.getElementById("chart_penjualan_minggu_ini");
            let height = parseInt(KTUtil.css(element, 'height'));
            let color = KTUtil.hasAttr(element, 'data-color') ? KTUtil.attr(element, 'data-color') : 'info';

            if (!element) {
                return;
            }

            let options = {
                series: [{
                    name: 'Penjualan',
                    data: JSON.parse(`{!! json_encode(array_column($total_minggu_ini, 'total')) !!}`)
                }],
                chart: {
                    type: 'area',
                    height: height,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    },
                    sparkline: {
                        enabled: true
                    }
                },
                plotOptions: {},
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                fill: {
                    type: 'solid',
                    opacity: 1
                },
                stroke: {
                    curve: 'smooth',
                    show: true,
                    width: 3,
                    colors: [KTAppSettings['colors']['theme']['base'][color]]
                },
                xaxis: {
                    categories: JSON.parse(`{!! json_encode(array_column($total_minggu_ini, 'tanggal')) !!}`),
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false
                    },
                    labels: {
                        show: false,
                        style: {
                            colors: KTAppSettings['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTAppSettings['font-family']
                        }
                    },
                    crosshairs: {
                        show: false,
                        position: 'front',
                        stroke: {
                            color: KTAppSettings['colors']['gray']['gray-300'],
                            width: 1,
                            dashArray: 3
                        }
                    },
                    tooltip: {
                        enabled: true,
                        formatter: undefined,
                        offsetY: 0,
                        style: {
                            fontSize: '12px',
                            fontFamily: KTAppSettings['font-family']
                        }
                    }
                },
                yaxis: {
                    min: parseFloat('{{ min(array_column($total_minggu_ini, 'total'))-10000 }}'),
                    max: parseFloat('{{ max(array_column($total_minggu_ini, 'total'))+10000 }}'),
                    labels: {
                        show: false,
                        style: {
                            colors: KTAppSettings['colors']['gray']['gray-500'],
                            fontSize: '12px',
                            fontFamily: KTAppSettings['font-family']
                        }
                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    style: {
                        fontSize: '12px',
                        fontFamily: KTAppSettings['font-family']
                    },
                    y: {
                        formatter: function (val) {
                            return "Rp. " + add_commas(val)
                        }
                    }
                },
                colors: [KTAppSettings['colors']['theme']['light'][color]],
                markers: {
                    colors: [KTAppSettings['colors']['theme']['light'][color]],
                    strokeColor: [KTAppSettings['colors']['theme']['base'][color]],
                    strokeWidth: 3
                }
            };

            let chart = new ApexCharts(element, options);
            chart.render();
        }
        _initChartPenjualanMingguIni();

        function search_terlaris(mode = 'semua') {
            let $list_terlaris = $('#list_terlaris');
            $list_terlaris.html('<div class="text-center"><i class="fa fa-spinner fa-spin fa-fw"></i> Loading</div>');
            $('.check-terlaris').html('');
            $('#terlaris_check_' + mode).html('<span class="label label-light-success label-rounded font-weight-bold"><i class="la la-check"></i></span>');
            $.post("{{ route('kasir.dashboard.produk_terlaris') }}", {
                _token: '{{ csrf_token() }}', mode
            }, (result) => {
                $list_terlaris.html(result);
            }).fail((xhr) => {
                console.log(xhr.responseText);
            });
        }
        search_terlaris();
    </script>
@endpush
