@extends('layout.container')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-2 mt-2 mb-2"><span class="fw-bolder">List Pemakaian Obat</h4>
        @if (Auth::guard('admin')->check())
            <button class="btn btn-primary btn-xs mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah"
                style="border-radius: 3px; font-size: 10px"><i class="bx bx-plus"></i>
                Tambah</button>
        @endif
        <button class="btn btn-secondary btn-xs mb-3 btn-cetak" data-namafile="{{ $link . '-' . date('d-m-Y H-i-s') }}"
            style="border-radius: 3px; font-size: 10px"><i class="bx bx-printer"></i>&nbsp;
            Cetak</button>
        <a href="/list-obat-tambah" class="btn btn-primary btn-xs mb-3 btn-cetak"
            style="border-radius: 3px; font-size: 10px"><i class="bx bx-plus"></i>&nbsp;
            Tambah Penggunaan Obat</a>
        <a href="/list-obat-terpakai" class="btn btn-primary btn-xs mb-3 btn-cetak"
            style="border-radius: 3px; font-size: 10px"><i class="bx bx-box"></i>&nbsp;
            List Penggunaan Obat</a>
        <div class="mb-3">
            @if (Auth::guard('admin')->check())
                <i class="text-danger">*) Obat berwarna merah masih belum memiliki batch, mohon diisi</i>
            @else
                <i class="text-danger">*) Persediaan obat yang dimliiki oleh Pelaku</i>
            @endif
        </div>
        <div class="card p-3">
            {{-- <h5 class="card-header">Striped rows</h5> --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-striped datatable_init">
                    <thead>
                        <tr>
                            <th class="align-middle">No</th>
                            <th class="align-middle">
                                Nama Obat
                                <div class="text-muted fw-light" style="font-size: 10px !important">Kode Obat - Batch</div>
                            </th>
                            <th class="align-middle">Kategori</th>
                            <th class="align-middle">Jenis Obat</th>
                            <th class="align-middle">Permintaan Terakhir</th>
                            <th class="align-middle">Stok Total</th>
                            <th class="align-middle">Harga
                                <div class="text-muted fw-light" style="font-size: 10px !important">Beli - Jual</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($result as $key => $v)
                            <tr>
                                <td style="width: 20px !important">{{ $key = $key + 1 }}</td>
                                <td>
                                    {{ $v->nama_obat }}
                                    <div style="font-size: 11px" class="text-muted">
                                        {{ $v->kode_obat }} - {{ $v->kode_batch }}</div>
                                </td>
                                <td>
                                    {{ $v->kategori_obat }}
                                </td>
                                <td>{{ $v->jenis_obat ?? '-' }}</td>
                                <td>{{ $v->created_at }}</td>
                                <td class="text-end"> {!! number_format($v->stok) !!} {{ $v->nama_satuan }}
                                </td>
                                <td>
                                    <span class="badge bg-label-secondary me-1">Rp.
                                        {{ number_format($v->harga_beli) }}</span>
                                    <span class="badge bg-label-primary me-1">Rp.
                                        {{ number_format($v->harga_jual) }}</span>
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
                        <div class="text-muted mb-2 fw-italic" style="font-size: 13px">*) Tidak boleh dikosongi</div>

                        <div class="mb-3">
                            <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
                            <input type="text" name="nama_obat" required="true" class="form-control"
                                aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kode Obat <span class="text-danger">*</span></label>
                            <input type="text" name="kode_obat" required="true" class="form-control"
                                aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Obat </label>
                            <input type="text" name="jenis_obat" class="form-control" aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori Obat <span class="text-danger">*</span></label>
                            <input type="text" name="kategori_obat" required="true" class="form-control"
                                aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Merek <span class="text-danger">*</span></label>
                            <input type="text" name="merk" required="true" class="form-control"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Harga Jual <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    <input type="text" name="harga_jual" required="true" class="form-control"
                                        aria-describedby="emailHelp">
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Harga Beli <span class="text-danger">*</span></label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    <input type="text" name="harga_beli" required="true" class="form-control"
                                        aria-describedby="emailHelp">
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
