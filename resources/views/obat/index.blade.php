@extends('layout.container')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">SIPO /</span> Obat</h4>

        <div class="card">
            {{-- <h5 class="card-header">Striped rows</h5> --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="align-middle">No</th>
                            <th class="align-middle">
                                Nama Obat
                                <div class="text-muted fw-light" style="font-size: 10px !important">Satuan/Kode</div>
                            </th>
                            <th class="align-middle">Kategori</th>
                            <th class="align-middle">Jenis Obat</th>
                            <th class="align-middle">Merk</th>
                            <th class="align-middle">Stok Terkini</th>
                            <th class="align-middle">Harga
                                <div class="text-muted fw-light" style="font-size: 10px !important">Beli - Jual</div>
                            </th>
                            <th class="align-middle">
                                aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <td style="width: 20px !important">1</td>
                            <td>Nama Obat</td>
                            <td>
                                Kategori
                            </td>
                            <td>Jenis Obat</td>
                            <td>Kalbe</td>
                            <td><i class="bx bxs-info-circle"></i> 2.390 </td>
                            <td>
                                <span class="badge bg-label-secondary me-1">Rp. 20.000</span>
                                <span class="badge bg-label-primary me-1">Rp. 20.000</span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="bx bx-edit-alt me-1"></i>
                                            Edit</a>
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                            Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Striped Rows -->
@endsection
