@extends('layout.container')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-2 mt-2 mb-2"><span class="fw-bolder">Data User Admin</h4>
        <button class="btn btn-primary btn-xs mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah"
            style="border-radius: 3px; font-size: 10px"><i class="bx bx-plus"></i>
            Tambah</button>

        <div class="row">
            @foreach ($result as $key => $v)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $v->nama_admin }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Administrator</h6>
                            <div class="font-weight-bold"><i class="bx bx-envelope"></i> {{ $v->email }}</div>
                            <div class="font-weight-bold"><i class="bx bx-phone"></i> {{ $v->telp }}</div>
                            <p class="card-text mt-3">
                            <div style="font-size: 12px"><b>Keterangan</b></div>
                            {!! $v->role ?? '-' !!}</p>
                            <div class="text-end">
                                <span class="btn btn-sm btn-primary edit-button" data-id={{ $v->admin_id }}><i
                                        class="bx bx-edit-alt me-1"></i>
                                    Edit</span>
                                <span class="btn btn-sm btn-danger hapus-button" data-id="{{ $v->admin_id }}"><i
                                        class="bx bx-trash me-1"></i>
                                    Hapus</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @if (count($result) < 1)
                <div class="mx-auto text-center py-3 shadow-sm" style="background-color: #fff; border-radius: 10px">Tidak
                    ada
                    data
                </div>
            @endif
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
                            <label class="form-label">Nama Admin <span class="text-danger">*</span></label>
                            <input type="text" name="nama_admin" required="true" class="form-control"
                                aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="text" name="email" required="true" class="form-control"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required="true" class="form-control"
                                aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telp <span class="text-danger">*</span></label>
                            <input type="text" name="telp" required="true" class="form-control"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan </label>
                            <textarea name="role" class="form-control keterangan" cols="30" rows="3"></textarea>
                            <div class="form-text text-end keterangan-limit"><b><span class="hitung">0</span>/255</b>
                            </div>
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
                            <label class="form-label">Nama Admin <span class="text-danger">*</span></label>
                            <input type="text" name="nama_admin" id="nama_admin" required="true"
                                class="form-control" aria-describedby="emailHelp">
                            {{-- <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="text" name="email" id="email" required="true" class="form-control"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password </label>
                            <input type="password" name="password" id="password" class="form-control"
                                aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">Kosongi jika tidak ingin mengubah password.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telp <span class="text-danger">*</span></label>
                            <input type="text" name="telp" id="telp" required="true" class="form-control"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan </label>
                            <textarea name="role" class="form-control keterangan" id="role" cols="30" rows="3"></textarea>
                            <div id="" class="form-text text-end keterangan-limit"><b><span
                                        class="hitung">0</span>/255</b>
                            </div>
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
            $('.keterangan').on('input paste', function() {
                let isi = $(this).val();
                // alert(isi.length);
                if (isi.length > 255) {
                    $('.keterangan-limit').addClass('text-danger');
                    return $(this).val(isi.slice(0, 255));
                }
                $('.keterangan-limit').removeClass('text-danger');
                $('.hitung').html(isi.length);
            })
            $('.edit-button').on('click', function() {
                $.ajax({
                    url: "/{{ $link }}/" + $(this).data('id'),
                    dataType: "json",
                    success: function(data) {
                        // console.log(data.nama_obat);
                        $('#nama_admin').val(data.nama_admin);
                        $('#email').val(data.email);
                        $('#telp').val(data.telp);
                        $('#role').val(data.role);
                        $('#form_edit').attr('action', "/{{ $link }}/" + data
                            .admin_id);
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
