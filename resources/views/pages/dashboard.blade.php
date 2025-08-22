@extends('layouts.main')

<title>LIST PO IMX | Dashboard</title>

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
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6>CHART BY SPK</h6>
                        </div>
                        <div class="card-body">
                            <div id="chartBySpk"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h6>TOTAL SPK BY CATEGORY</h6>
                        </div>
                        <div class="card-body">
                            <div id="chartByCategory"></div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
        <!-- container-fluid -->
    </div>

    <script src="{{ asset('cms/assets/apexcharts.min.js') }}"></script>
    <script src="{{ asset('cms/assets/axios.min.js') }}"></script>

    <script>
        fetch("{{ route('chartByCategory') }}")
            .then(res => res.json())
            .then(data => {
                var options = {
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    series: [{
                        name: 'Jumlah SPK',
                        data: data.series
                    }],
                    xaxis: {
                        categories: data.labels
                    },
                    colors: [
                        '#1E90FF', // biru
                        '#FF4500', // oranye
                        '#32CD32', // hijau
                        '#8A2BE2', // ungu
                        '#00CED1', // cyan
                        '#A52A2A', // coklat
                        '#708090', // abu-abu
                        '#2E8B57', // hijau tua
                        '#FF8C00', // orange gelap
                        '#4682B4' // steel blue
                    ],
                    plotOptions: {
                        bar: {
                            distributed: true, // << penting biar tiap bar warnanya beda
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#chartByCategory"), options);
                chart.render();
            });


        fetch("{{ route('getPoBySpk') }}")
            .then(res => res.json())
            .then(data => {
                var options = {
                    series: data.series,
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            borderRadius: 5,
                            borderRadiusApplication: 'end'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: data.labels
                    },
                    yaxis: {
                        title: {
                            text: 'Jumlah PO'
                        }
                    },
                    fill: {
                        opacity: 1
                    }
                };

                var chart = new ApexCharts(document.querySelector("#chartBySpk"), options);
                chart.render();
            });
    </script>
@endsection
