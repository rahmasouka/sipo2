@extends('layout.container')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-2 mt-2 mb-2"><span class="fw-bolder">{{ $title }}</h4>
        <button class="btn btn-primary btn-xs mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah"
            style="border-radius: 3px; font-size: 10px"><i class="bx bx-plus"></i>
            Tambah</button>
        <button class="btn btn-secondary btn-xs mb-3 btn-cetak" data-namafile="{{ $link . '-' . date('d-m-Y H-i-s') }}"
            style="border-radius: 3px; font-size: 10px"><i class="bx bx-printer"></i>&nbsp;
            Cetak</button>
        <div class="card p-3">
            {{-- <h5 class="card-header">Striped rows</h5> --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-striped datatable_init">
                    <thead>
                        <tr>
                            <th class="align-middle">No</th>
                            <th class="align-middle">
                                Tanggal Opname
                            </th>
                            <th class="align-middle">Jumlah Selisih</th>
                            </th>
                            <th class="align-middle">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($result as $key => $v)
                            <tr>
                                <td style="width: 20px !important">{{ $key = $key + 1 }}</td>
                                <td>
                                    {{ $v->created_at }}
                                </td>
                                <td> {!! number_format($v->stok_terkini) !!} </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <span class="dropdown-item edit-button" data-id={{ $v->obat_id }}><i
                                                    class="bx bx-edit-alt me-1"></i>
                                                Edit</span>
                                            <span class="dropdown-item edit-button" data-id={{ $v->obat_id }}><i
                                                    class="bx bx-printer-alt me-1"></i>
                                                Cetak</span> <br>
                                            <span class="dropdown-item hapus-button" data-id="{{ $v->obat_id }}"><i
                                                    class="bx bx-list me-1"></i>
                                                List</span>
                                            <span class="dropdown-item hapus-button" data-id="{{ $v->obat_id }}"><i
                                                    class="bx bx-trash me-1"></i>
                                                Hapus</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Striped Rows -->

    <!-- Modal TAMBAH-->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bolder" id="exampleModalLabel">Data Obat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/{{ $link }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="align-middle">
                                        Kode Batch
                                    </th>
                                    <th class="align-middle">
                                        Nama Obat
                                    </th>
                                    </th>
                                    <th class="align-middle">
                                        Stok Tercatat
                                    </th>
                                    <th class="align-middle">
                                        Stok Asli
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0 isianBatch">
                                <tr>
                                    <td colspan="3" class="text-end">
                                        <select name="" id="cariBatch" class="select2- form-select">
                                            @foreach ($batch as $item)
                                                <option value="{{ $item->batch_id }}" id="option_{{ $item->batch_id }}">
                                                    {{ $item->kode_batch }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td colspan="1" class="text-center">
                                        <button class="btn btn-primary btn-sm mx-auto" id="tambahBatch" type="button">
                                            <i class="bx bx-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal EDIT-->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 fw-bolder" id="exampleModalLabel">Data Obat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_edit" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="text-muted mb-2 fw-italic" style="font-size: 13px">*) Tidak boleh dikosongi</div>

                        <div class="mb-3">
                            <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
                            <input type="text" name="nama_obat" id="nama_obat" required="true" class="form-control"
                                aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kode Obat <span class="text-danger">*</span></label>
                            <input type="text" name="kode_obat" id="kode_obat" required="true" class="form-control"
                                aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Obat </label>
                            <input type="text" name="jenis_obat" id="jenis_obat" class="form-control"
                                aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori Obat <span class="text-danger">*</span></label>
                            <input type="text" name="kategori_obat" id="kategori_obat" required="true"
                                class="form-control" aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Satuan <span class="text-danger">*</span></label>
                            <select name="satuan_obat" id="satuan_obat" class="form-control">
                                <option value="">Pilih Satuan</option>
                                @foreach ($satuan as $r)
                                    <option value="{{ $r->satuan_id }}">{{ $r->nama_satuan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Merek <span class="text-danger">*</span></label>
                            <input type="text" name="merk" id="merk" required="true" class="form-control"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Harga Jual <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    <input type="text" name="harga_jual" id="harga_jual" required="true"
                                        class="form-control" aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Harga Beli <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    <input type="text" name="harga_beli" id="harga_beli" required="true"
                                        class="form-control" aria-describedby="emailHelp">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Langsung tambah batch?</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal"><i
                                class="bx bx-"></i> Tutup</button>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="bx bx-save"></i> Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('document').ready(function() {
            $('#tambahBatch').on('click', function() {
                let batchID = $('#cariBatch').val();

                if (batchID != undefined && batchID != '' && batchID != null) {
                    $.ajax({
                        url: "/api/batch/" + batchID, // The URL to send the request to
                        success: function(data) {
                            data = JSON.parse(data)
                            console.log(data);
                            let body = `
                            <tr>
                                <td>` + data.kode_batch + `</td>
                                <td>` + data.nama_obat + `</td>
                                <td>` + data.stok_terkini + `</td>
                                <td><input type="number" class="form-control"></td>
                            </tr>
                        `;
                            $('#option_' + data.batch_id).remove();
                            $('.isianBatch').prepend(body);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Handle errors (jqXHR, textStatus, and errorThrown provide details)
                        }
                    });
                } else {
                    return alert('Silahkan pilih kode batch');
                }
            });
            $('.edit-button').on('click', function() {
                $.ajax({
                    url: "/{{ $link }}/" + $(this).data('id'),
                    dataType: "json",
                    success: function(data) {
                        // console.log(data.nama_obat);
                        $('#nama_obat').val(data.nama_obat);
                        $('#kode_obat').val(data.kode_obat);
                        $('#jenis_obat').val(data.jenis_obat);
                        $('#kategori_obat').val(data.kategori_obat);
                        $('#satuan_obat').val(data.satuan_id);
                        $('#merk').val(data.merk);
                        $('#harga_jual').val(data.harga_jual);
                        $('#harga_beli').val(data.harga_beli);
                        $('#form_edit').attr('action', "/{{ $link }}/" + data.obat_id);
                        $('#modalEdit').modal('show');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error:", textStatus, errorThrown);
                    }
                });
            });
            $('.hapus-button').on('click', function() {
                Swal.fire({
                    title: "Hapus?",
                    text: "Data tidak dapat dikembalikan lagi",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Hapus",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/{{ $link }}/hapus/" + $(this).data('id'),
                            dataType: "json",
                            success: function(data) {
                                if (data) {
                                    window.location.href = "/{{ $link }}";
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
    @include('component.alerts')
@endpush
