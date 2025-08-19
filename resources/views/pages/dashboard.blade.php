@extends('layouts.main')

<title>LIST SEWA | Dashboard</title>

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-4 col-md-4">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Toko</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value"
                                            data-target="{{ $toko }}">{{ $toko }}</span>
                                    </h4>
                                </div>

                            </div>
                            <div class="text-nowrap">
                                <span class="badge bg-danger-subtle text-danger">Total Toko</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Kontrak AC</span>
                                    <h4 class="mb-3">
                                        <span class="counter-value"
                                            data-target="{{ $contracts }}">{{ $contracts }}</span>
                                    </h4>
                                </div>

                            </div>
                            <div class="text-nowrap">
                                <span class="badge bg-success-subtle text-success">Transaksi / Masukan Kontrak AC</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4">
                    <div class="card card-h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <span class="text-muted mb-3 lh-1 d-block text-truncate">Total</span>
                                    <h4 class="mb-3">
                                        <span style="font-size: 21px">{{ formatRupiah($laporan) }}</span>
                                    </h4>
                                </div>

                            </div>
                            <div class="text-nowrap">
                                <span class="badge bg-primary-subtle text-primary">Laporan / Total</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div id="chart"></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div id="Spk"></div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div id="NilaiSpk"></div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div id="chartKF"></div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div id="chartKFTotal"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('cms/assets/apexcharts.min.js') }}"></script>
    <script src="{{ asset('cms/assets/axios.min.js') }}"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            axios.get('/api/contracts-chart')
                .then(response => {
                    const data = response.data.data;

                    var options = {
                        series: [data.DK, data.J, data.LJ],
                        chart: {
                            type: 'pie',
                            height: 350
                        },
                        labels: ['DK', 'J', 'LJ'],
                        title: {
                            text: 'Grafik Kontrak',
                            align: 'center',
                            margin: 20,
                            offsetX: 0,
                            offsetY: 0,
                            floating: false,
                            style: {
                                fontSize: '14px',
                                fontWeight: 'bold',
                                fontFamily: undefined,
                                color: '#ACACAC'
                            },
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    width: 200
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }]
                    };

                    var chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();
                })
                .catch(error => {
                    console.error(error);
                });


            // start
            var options = {
                series: [{
                    name: 'Total Laporan',
                    data: @json($yearlyTotalsSpk) // The yearly totals data
                }],
                chart: {
                    type: 'line',
                    height: 350
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    // Generate the range of years from 2017 to the current year dynamically
                    categories: @json(range($startYear, $currentYear))
                },
                tooltip: {
                    x: {
                        format: 'yyyy' // Year format
                    },
                    y: {
                        formatter: function(val) {
                            return val.toLocaleString();
                        }
                    }
                },
                annotations: {
                    points: [{
                        x: new Date().getFullYear().toString(), // Example point for the current year
                        y: null,
                        marker: {
                            size: 8,
                            fillColor: '#FF0000',
                            strokeColor: '#FF0000',
                            radius: 2,
                            cssClass: 'apexcharts-custom-tooltip'
                        },
                        label: {
                            borderColor: '#FF0000',
                            offsetY: 0,
                            style: {
                                color: '#fff',
                                background: '#FF0000',
                                border: '1px solid #FF0000'
                            },
                            text: 'Puncak Total SPK',
                            orientation: 'horizontal'
                        }
                    }]
                },
                title: {
                    text: 'Grafik Total SPK',
                    align: 'center',
                    style: {
                        color: '#ACACAC',
                        margin: '20px'
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#Spk"), options);
            chart.render();

            // finish


            // start
            var options = {
                series: [{
                    name: 'Total Laporan',
                    data: @json($yearlyTotals) // Use the yearly totals
                }],
                chart: {
                    type: 'area',
                    height: 350
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                xaxis: {
                    categories: [2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025],
                },
                tooltip: {
                    x: {
                        format: 'yyyy'
                    },
                    y: {
                        formatter: function(val) {
                            return "Rp. " + val.toLocaleString()
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.9,
                        stops: [0, 90, 100]
                    }
                },
                title: {
                    text: 'Grafik Total Pendapatan', // Dynamic title
                    align: 'center',
                    style: {
                        color: '#ACACAC',
                        margin: '20px'
                    }
                },
            };

            var chart = new ApexCharts(document.querySelector("#NilaiSpk"), options);
            chart.render();

            // finish

            // start
            axios.get('/api/getKFChartData')
                .then(function(response) {
                    const kfData = response.data.data;
                    const seriesData = {
                        KF_15: [],
                        KF_20: [],
                        KF_23: [],
                        KF_26: [],
                        KF_34: [],
                        KF_50: [],
                        KF_70: [],
                        KF_100: [],
                        KF_120: [],
                        SD_70: [],
                        SD_90: [],
                        DB_60: [],
                        DB_80: [],
                        DB_100: [],
                        DB_150: [],
                        DB_200: []
                    };

                    kfData.forEach(item => {
                        seriesData.KF_15.push(item.KF_15);
                        seriesData.KF_20.push(item.KF_20);
                        seriesData.KF_23.push(item.KF_23);
                        seriesData.KF_26.push(item.KF_26);
                        seriesData.KF_34.push(item.KF_34);
                        seriesData.KF_50.push(item.KF_50);
                        seriesData.KF_70.push(item.KF_70);
                        seriesData.KF_100.push(item.KF_100);
                        seriesData.KF_120.push(item.KF_120);
                        seriesData.SD_70.push(item.SD_70);
                        seriesData.SD_90.push(item.SD_90);
                        seriesData.DB_60.push(item.DB_60);
                        seriesData.DB_80.push(item.DB_80);
                        seriesData.DB_100.push(item.DB_100);
                        seriesData.DB_150.push(item.DB_150);
                        seriesData.DB_200.push(item.DB_200);
                    });

                    // Map years for the x-axis
                    const years = kfData.map(item => item.year);

                    var options = {
                        series: [{
                            name: 'KF-15',
                            data: seriesData.KF_15,
                            color: '#007bff'
                        }, {
                            name: 'KF-20',
                            data: seriesData.KF_20,
                            color: '#28a745'
                        }, {
                            name: 'KF-23',
                            data: seriesData.KF_23,
                            color: '#17a2b8'
                        }, {
                            name: 'KF-26',
                            data: seriesData.KF_26,
                            color: '#6f42c1'
                        }, {
                            name: 'KF-34',
                            data: seriesData.KF_34,
                            color: '#dc3545'
                        }, {
                            name: 'KF-50',
                            data: seriesData.KF_50,
                            color: '#ffc107'
                        }, {
                            name: 'KF-70',
                            data: seriesData.KF_70,
                            color: '#20c997'
                        }, {
                            name: 'KF-100',
                            data: seriesData.KF_100,
                            color: '#4f5d95'
                        }, {
                            name: 'KF-120',
                            data: seriesData.KF_120,
                            color: '#ff69b4'
                        }, {
                            name: 'SD-70',
                            data: seriesData.SD_70,
                            color: '#008080'
                        }, {
                            name: 'SD-90',
                            data: seriesData.SD_90,
                            color: '#6B7280'
                        }, {
                            name: 'DB-60',
                            data: seriesData.DB_60,
                            color: '#d3d3d3'
                        }, {
                            name: 'DB-80',
                            data: seriesData.DB_80,
                            color: '#a3acf2'
                        }, {
                            name: 'DB-100',
                            data: seriesData.DB_100,
                            color: '#ffd700'
                        }, {
                            name: 'DB-150',
                            data: seriesData.DB_150,
                            color: '#3a3d41'
                        }, {
                            name: 'DB-200',
                            data: seriesData.DB_200,
                            color: '#e83e8c'
                        }],
                        chart: {
                            type: 'bar',
                            height: 350,
                            stacked: true,
                        },
                        xaxis: {
                            categories: years, // Use years instead of months
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '70%',
                                endingShape: 'rounded'
                            },
                        },
                        title: {
                            text: 'Grafik PK', // Update title dynamically
                            align: 'center',
                            margin: 20,
                            style: {
                                fontSize: '14px',
                                fontWeight: 'bold',
                                color: '#ACACAC'
                            },
                        },
                    };

                    var chart = new ApexCharts(document.querySelector("#chartKF"), options);
                    chart.render();
                })
                .catch(function(error) {
                    console.error(error);
            });

            // finish

            // start
            axios.get('/api/countKFTotal')
                .then(function(response) {
                    const kfTotals = response.data.data;

                    var options = {
                        series: [{
                            name: 'Total',
                            data: [
                                kfTotals.KF_15_Total, kfTotals.KF_20_Total, kfTotals
                                .KF_23_Total, kfTotals.KF_26_Total,
                                kfTotals.KF_34_Total, kfTotals.KF_50_Total, kfTotals
                                .KF_70_Total, kfTotals.KF_100_Total,
                                kfTotals.KF_120_Total, kfTotals.SD_70_Total, kfTotals
                                .SD_90_Total, kfTotals
                                .SD_120_Total, kfTotals.DB_60_Total,
                                kfTotals.DB_80_Total, kfTotals.DB_100_Total, kfTotals
                                .DB_150_Total, kfTotals.DB_200_Total
                            ]
                        }],
                        chart: {
                            height: 350,
                            type: 'bar',
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 10,
                                dataLabels: {
                                    position: 'top',
                                },
                            }
                        },

                        dataLabels: {
                            enabled: true,
                            formatter: function(val) {
                                return val
                            },
                            offsetY: -20,
                            style: {
                                fontSize: '12px',
                                colors: ["#304758"]
                            }
                        },

                        xaxis: {
                            categories: ['KF-15', 'KF-20', 'KF-23', 'KF-26', 'KF-34', 'KF-50', 'KF-70',
                                'KF-100',
                                'KF-120', 'SD-70', 'SD-90', 'SD-120', 'DB-60', 'DB-80', 'DB-100',
                                'DB-150', 'DB-200'
                            ],
                            position: 'top',
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            crosshairs: {
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        colorFrom: '#D8E3F0',
                                        colorTo: '#BED1E6',
                                        stops: [0, 100],
                                        opacityFrom: 0.4,
                                        opacityTo: 0.5,
                                    }
                                }
                            },
                            tooltip: {
                                enabled: true,
                            }
                        },
                        yaxis: {
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false,
                            },
                            labels: {
                                show: false,
                                formatter: function(val) {
                                    return val
                                }
                            }

                        },
                        title: {
                            text: 'Grafik Total PK',
                            floating: true,
                            offsetY: 330,
                            align: 'center',
                            style: {
                                color: '#ACACAC'
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#chartKFTotal"), options);
                    chart.render();
                })
                .catch(function(error) {
                    console.error(error);
                });

            // finish
        });
    </script>
@endsection
