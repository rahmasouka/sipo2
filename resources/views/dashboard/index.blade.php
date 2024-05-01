@extends('layout.container')
@section('content')
    @php
        $nama = '';
        $role = '';
        $email = '';
        $telp = '';
        if (Auth::guard('admin')->check()) {
            $nama = Auth::guard('admin')->user()->nama_admin;
            $email = Auth::guard('admin')->user()->email;
            $telp = Auth::guard('admin')->user()->telp;
            $role = 'Admin';
        } else {
            $nama = Auth::guard('pelaku')->user()->nama_pelaku;
            $email = Auth::guard('pelaku')->user()->email;
            $telp = Auth::guard('pelaku')->user()->kode_pelaku;
            $role = 'Pelaku';
        }
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Selamat Datang, {{ $nama }} 👋 </h5>
                                <p class="mb-4">
                                    Hari ini tanggal {{ date('d/m/Y') }}, selamat bekerja!
                                </p>

                                <a href="javascript:;" class="btn btn-sm btn-outline-primary">Lihat Obat</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="/assets/img/illustrations/man-with-laptop-light.png" height="140"
                                    alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="/assets/img/icons/unicons/obat.png" alt="Credit Card" class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                            <a class="dropdown-item" href="/obat">Lihat Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                                <span>Total Obat</span>
                                <h3 class="card-title text-nowrap mb-1">{{ $totalObat }}</h3>
                                <small class="text-secondary fw-medium">/pcs</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="/assets/img/icons/unicons/transaksi.png" alt="Credit Card"
                                            class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                            <a class="dropdown-item" href="/obat">Lihat Selengkapnya</a>
                                        </div>
                                    </div>
                                </div>
                                <span>Request Obat</span>
                                <h3 class="card-title text-nowrap mb-1">{{ $totalRequest }}</h3>
                                <small class="text-secondary fw-medium">Permintaan</small>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::guard('pelaku')->check())
                    <div class="col-lg-12 mb-4 order-0">
                        <div class="card">
                            <div class="d-flex align-items-end row">
                                <div class="col-sm-7">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Permintaan Obat </h5>
                                        <p class="mb-4">
                                            Lakukan permintaan obat dengan mudah melalui <span
                                                class="text-primary"><i><b>SIPO</b></i></span>
                                        </p>

                                        <a href="/lakukan-permintaan" class="btn btn-sm btn-primary">Lakukan Permintaan</a>
                                    </div>
                                </div>
                                <div class="col-sm-5 text-center text-sm-left">
                                    <div class="card-body pb-0 px-0 px-md-4">
                                        <img src="/assets/img/illustrations/request.png" height="140"
                                            alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                            data-app-light-img="illustrations/man-with-laptop-light.png" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-12 mb-4 order-0">
                        <div class="card">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-body mb-0 pb-0">
                                        <h5 class="card-title text-primary">Expired </h5>
                                        <p class="mb-2">
                                            List obat yang akan expired dalam waktu 6 bulan <b>(Total
                                                {{ $totalExpired }})</b>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="card-body pt-1">

                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <table class="table table-striped datatable_init">
                                                    <thead>
                                                        <tr>
                                                            <th class="align-middle text-center">No</th>
                                                            <th class="align-middle text-start">Nama Obat
                                                                <div class="text-muted fw-light"
                                                                    style="font-size: 10px !important">Kode Obat</div>
                                                            </th>
                                                            <th class="align-middle text-start">Kode Batch</th>
                                                            <th class="align-middle text-start">Expired</th>
                                                            <th class="align-middle text-start">Jumlah</th>
                                                            <th class="align-middle text-start">Pengadaan
                                                                <div class="text-muted fw-light"
                                                                    style="font-size: 10px !important">Tanggal - Tahun
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-border-bottom-0">
                                                        @foreach ($expired as $key => $v)
                                                            <tr>
                                                                <td style="width: 20px !important" class="text-center">
                                                                    {{ $key = $key + 1 }}
                                                                </td>
                                                                <td>{{ $v->nama_obat }} <div style="font-size: 11px"
                                                                        class="text-muted">{{ $v->kode_obat }}
                                                                    </div>
                                                                </td>
                                                                <td>{{ $v->kode_batch }}</td>
                                                                <td class="text-start"><span
                                                                        class="badge bg-label-secondary me-1">{{ date('d M Y', strtotime($v->expired)) }}</span>
                                                                </td>
                                                                <td>{{ $v->stok_batch }}</td>
                                                                <td>
                                                                    <span
                                                                        class="badge bg-label-secondary me-1">{{ date('d M Y', strtotime($v->tanggal_pengadaan)) }}</span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-4 order-0">
                        <div class="card">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card-body mb-0 pb-0">
                                        <h5 class="card-title text-primary">Stok akan habis </h5>
                                        <p class="mb-2">
                                            List obat dengan stok dibawah 20 <b>(Total
                                                {{ $totalStokKurang }})</b>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="card-body pt-1">

                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <table class="table table-striped datatable_init">
                                                    <thead>
                                                        <tr>
                                                            <th class="align-middle text-center">No</th>
                                                            <th class="align-middle text-center">Nama Obat
                                                                <div class="text-muted fw-light"
                                                                    style="font-size: 10px !important">Kode Obat</div>
                                                            </th>
                                                            <th class="align-middle text-center">Stok</th>
                                                            <th class="align-middle text-center">Harga</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-border-bottom-0">
                                                        @foreach ($stokKurang as $key => $v)
                                                            <tr>
                                                                <td style="width: 20px !important" class="text-center">
                                                                    {{ $key = $key + 1 }}
                                                                </td>
                                                                <td>{{ $v->nama_obat }} <div style="font-size: 11px"
                                                                        class="text-muted">{{ $v->kode_obat }}
                                                                    </div>
                                                                </td>
                                                                <td>{{ $v->stok_terkini }} <span style="font-size: 11px"
                                                                        class="text-muted">{{ $v->nama_satuan }}
                                                                    </span></td>
                                                                <td class="text-end">
                                                                    Rp.{{ number_format($v->harga_jual, 2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>


        </div>
    </div>
@endsection
