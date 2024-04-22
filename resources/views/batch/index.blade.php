@extends('layout.container')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-2 mt-2 mb-2"><span class="fw-bolder">Data Batch Obat</h4>
        <button class="btn btn-primary btn-xs mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah"
            style="border-radius: 3px; font-size: 10px"><i class="bx bx-plus"></i>
            Tambah</button>
        <button class="btn btn-secondary btn-xs mb-3" style="border-radius: 3px; font-size: 10px"><i
                class="bx bx-printer"></i>&nbsp;
            Cetak</button>
        <div class="mb-3">
            <i class="text-danger">*) Obat berwarna merah masih belum memiliki batch, mohon diisi</i>
        </div>
        <div class="card p-3">
            {{-- <h5 class="card-header">Striped rows</h5> --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-striped datatable_init">
                    <thead>
                        <tr>
                            <th class="align-middle text-start">No</th>
                            <th class="align-middle text-start">Nama Obat
                                <div class="text-muted fw-light" style="font-size: 10px !important">Kode Obat</div>
                            </th>
                            <th class="align-middle text-start">Kode Batch</th>
                            <th class="align-middle text-start">Expired</th>
                            <th class="align-middle text-start">Jenis</th>
                            <th class="align-middle text-start">Keterangan</th>
                            <th class="align-middle text-start">Pengadaan
                                <div class="text-muted fw-light" style="font-size: 10px !important">Tanggal - Tahun</div>
                            </th>
                            <th class="align-middle">
                                aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($result as $key => $v)
                            <tr>
                                <td style="width: 20px !important">{{ $key = $key + 1 }}</td>
                                <td>{{ $v->nama_obat }} <div style="font-size: 11px" class="text-muted">{{ $v->kode_obat }}
                                    </div>
                                </td>
                                <td>{{ $v->kode_batch }}</td>
                                <td class="text-start"><span
                                        class="badge bg-label-secondary me-1">{{ date('d M Y', strtotime($v->expired)) }}</span>
                                </td>
                                <td>{{ $v->jenis }}</td>
                                <td>{{ $v->keterangan }}</td>
                                <td>
                                    <span
                                        class="badge bg-label-secondary me-1">{{ date('d M Y', strtotime($v->tanggal_pengadaan)) }}</span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <span class="dropdown-item edit-button" data-id={{ $v->batch_id }}><i
                                                    class="bx bx-edit-alt me-1"></i>
                                                Edit</span>
                                            <span class="dropdown-item hapus-button" data-id="{{ $v->batch_id }}"><i
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
                    <h1 class="modal-title fs-5 fw-bolder" id="exampleModalLabel">Data Batch Obat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/{{ $link }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="text-muted mb-2 fw-italic" style="font-size: 13px">*) Tidak boleh dikosongi</div>

                        <div class="mb-3">
                            <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
                            <select name="nama_obat" class="form-control">
                                <option value="">Pilih Obat</option>
                                @foreach ($obat as $r)
                                    <option value="{{ $r->obat_id }}">{{ $r->nama_obat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kode Batch <span class="text-danger">*</span></label>
                            <input type="text" name="kode_batch" required="true" class="form-control"
                                aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Expired </label>
                            <input type="date" name="expired" class="form-control" aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis <span class="text-danger">*</span></label>
                            <input type="text" name="jenis" required="true" class="form-control"
                                aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan <span class="text-danger">*</span></label>
                            <textarea type="text" name="keterangan" required="true" class="form-control" aria-describedby="emailHelp"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pengadaan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pengadaan" required="true" class="form-control"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tahun Pengadaan <span class="text-danger">*</span></label>
                            <input type="number" name="tahun_pengadaan" required="true" class="form-control"
                                aria-describedby="emailHelp">
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
                    <h1 class="modal-title fs-5 fw-bolder" id="exampleModalLabel">Data Batch Obat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_edit" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="text-muted mb-2 fw-italic" style="font-size: 13px">*) Tidak boleh dikosongi</div>

                        <div class="mb-3">
                            <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
                            <select name="nama_obat" id="nama_obat" class="form-control">
                                <option value="">Pilih Obat</option>
                                @foreach ($obat as $r)
                                    <option value="{{ $r->obat_id }}">{{ $r->nama_obat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kode Batch <span class="text-danger">*</span></label>
                            <input type="text" name="kode_batch" id="kode_batch" required="true"
                                class="form-control" aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Expired </label>
                            <input type="date" name="expired" id="expired" class="form-control"
                                aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis <span class="text-danger">*</span></label>
                            <input type="text" name="jenis" id="jenis" required="true" class="form-control"
                                aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan <span class="text-danger">*</span></label>
                            <textarea type="text" name="keterangan" id="keterangan" required="true" class="form-control"
                                aria-describedby="emailHelp"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pengadaan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pengadaan" id="tanggal_pengadaan" required="true"
                                class="form-control" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tahun Pengadaan <span class="text-danger">*</span></label>
                            <input type="number" name="tahun_pengadaan" id="tahun_pengadaan" required="true"
                                class="form-control" aria-describedby="emailHelp">
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
                        $('#nama_obat').val(data.obat_id);
                        $('#kode_batch').val(data.kode_batch);
                        $('#expired').val(data.expired);
                        $('#jenis').val(data.jenis);
                        $('#keterangan').val(data.keterangan);
                        $('#tanggal_pengadaan').val(data.tanggal_pengadaan);
                        $('#tahun_pengadaan').val(data.tahun_pengadaan);
                        $('#form_edit').attr('action', "/{{ $link }}/" + data
                            .batch_id);
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
