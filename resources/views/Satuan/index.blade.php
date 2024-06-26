@extends('layout.container')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-2 mt-2 mb-2"><span class="fw-bolder">Data Satuan</h4>
        <button class="btn btn-primary btn-xs mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah"
            style="border-radius: 3px; font-size: 10px"><i class="bx bx-plus"></i>
            Tambah</button>
        <button class="btn btn-secondary btn-xs mb-3 btn-cetak" data-namafile="{{ $link . '-' . date('d-m-Y H-i-s') }}"
            style="border-radius: 3px; font-size: 10px"><i class="bx bx-printer"></i>&nbsp;
            Cetak</button>
        <div class="mb-3">
            <i class="text-danger">*) Input data satuan pada form berikut ini</i>
        </div>
        <div class="card p-3">
            {{-- <h5 class="card-header">Striped rows</h5> --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-striped datatable_init">
                    <thead>
                        <tr>
                            <th class="align-middle">No</th>
                            <th class="align-middle">Nama Satuan</th>
                            <th class="align-middle text-start">Keterangan</th>
                            <th class="align-middle">
                                aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($result as $key => $v)
                            <tr>
                                <td style="width: 20px !important">{{ $key = $key + 1 }}</td>
                                <td>{{ $v->nama_satuan }}</td>
                                <td class="text-start">{{ $v->keterangan }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <span class="dropdown-item edit-button" data-id={{ $v->satuan_id }}><i
                                                    class="bx bx-edit-alt me-1"></i>
                                                Edit</span>
                                            <span class="dropdown-item hapus-button" data-id="{{ $v->satuan_id }}"><i
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
                    <h1 class="modal-title fs-5 fw-bolder" id="exampleModalLabel">Data Satuan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/{{ $link }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <div class="text-muted mb-2 fw-italic" style="font-size: 13px">*) Tidak boleh dikosongi</div>

                        <div class="mb-3">
                            <label class="form-label">Nama Satuan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_satuan" required="true" class="form-control"
                                aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan <span class="text-danger">*</span></label>
                            <input type="text" name="keterangan" required="true" class="form-control"
                                aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal"><i class="bx bx-"></i>
                            Tutup</button>
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
                    <h1 class="modal-title fs-5 fw-bolder" id="exampleModalLabel">Data Satuan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_edit" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="text-muted mb-2 fw-italic" style="font-size: 13px">*) Tidak boleh dikosongi</div>

                        <div class="mb-3">
                            <label class="form-label">Nama Satuan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_satuan" id="nama_satuan" required="true"
                                class="form-control" aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan <span class="text-danger">*</span></label>
                            <input type="text" name="keterangan" id="keterangan" required="true"
                                class="form-control" aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
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
                        $('#nama_satuan').val(data.nama_satuan);
                        $('#keterangan').val(data.keterangan);
                        $('#form_edit').attr('action', "/{{ $link }}/" + data
                            .satuan_id);
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
