@extends('layout.main')

@push('style')
    <link rel="stylesheet" href="{{ asset('sneat/vendor/libs/apex-charts/apex-charts.css') }}" />
    <style>
        .dashboard-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .card-title {
            width: 100%;
        }

        .dashboard-card {
            width: calc(33.33% - 10px); 
            flex: 1;
        }
        
        @media (max-width: 768px) {
            .dashboard-row {
                flex-direction: column;
            }
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset('sneat/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script>
        const options = {
            chart: {
                type: 'bar'
            },
            series: [{
                name: 'Transaksi Surat',
                data: [{{ $todaySuratMasuk }}, {{ $todaySuratKeluar }}, {{ $todayDisposisiSurat }}]
            }],
            stroke: {
                curve: 'smooth',
            },
            xaxis: {
                categories: [
                    'Surat Masuk',
                    'Surat Keluar',
                    'Disposisi Surat',
                ],
            }
        }

        const chart = new ApexCharts(document.querySelector("#today-graphic"), options);
        chart.render();
    </script>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 mb-4 order-0"> 
            <div class="card mb-4">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h4 class="card-title text-primary">
                                @if(auth()->user()->role == 'admin')
                                    Halo Admin
                                @else
                                    Halo {{ auth()->user()->name }}
                                @endif
                            </h4>
                            <p class="mb-4">{{ $currentDate }}</p>
                            <p style="font-size: smaller" class="text-gray">*) Laporan Hari Ini</p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('sneat/img/cewe.png') }}" height="170" alt="View Badge User">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 order-1"> 
            <div class="dashboard-row">
                <div class="dashboard-card">
                    <x-dashboard-card-simple
                        :label="'Surat Masuk'"
                        :value="$todaySuratMasuk"
                        :daily="true"
                        color="success"
                        icon="bx-envelope"
                        :percentage="$percentageSuratMasuk"
                    />
                </div>
                <div class="dashboard-card">
                    <x-dashboard-card-simple
                        :label="'Surat Keluar'"
                        :value="$todaySuratKeluar"
                        :daily="true"
                        color="danger"
                        icon="bx-envelope"
                        :percentage="$percentageSuratKeluar"
                    />
                </div>
                <div class="dashboard-card">
                    <x-dashboard-card-simple
                        :label="'Disposisi Surat'"
                        :value="$todayDisposisiSurat"
                        :daily="true"
                        color="primary"
                        icon="bx-envelope"
                        :percentage="$percentageDisposisiSurat"
                    />
                </div>
            </div>
        </div>
    </div>
@endsection
