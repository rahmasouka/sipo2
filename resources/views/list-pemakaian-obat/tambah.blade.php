@extends('layout.container')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-2 mt-2 mb-2"><span class="fw-bolder">List Pemakaian Obat</h4>
        @if (Auth::guard('admin')->check())
            <button class="btn btn-primary btn-xs mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah"
                style="border-radius: 3px; font-size: 10px"><i class="bx bx-plus"></i>
                Tambah</button>
        @endif

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
                <form action="/list-obat-tambah" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-body mb-4">
                        <div class="mb-4">
                            <h6><b>Tambah Pemakaian Obat Harian</b></h6>
                            <div class="mb-3">
                                <label for="pelaku">Pelaku</label>
                                <div class="input-group">
                                    <input type="text" disabled readonly class="form-control"
                                        value="{{ Auth::guard('pelaku')->user()->nama_pelaku }}">
                                    <input type="hidden" name="pelaku_id"
                                        value="{{ Auth::guard('pelaku')->user()->pelaku_id }}">
                                </div>
                            </div>

                        </div>
                        <h6><b>List Obat</b></h6>
                        <table style="width: 100%">
                            <tr>
                                <td colspan="3">
                                    <select name="" id="cariBatch" class="select2- form-select">
                                        <option value="" disabled>Pilih Batch</option>
                                        @foreach ($result as $item)
                                            <option value="{{ $item->batch_id }}" id="option_{{ $item->batch_id }}">
                                                {{ $item->kode_batch }} ({{ $item->nama_obat }}, stok:
                                                {{ $item->stok }})
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td colspan="1" class="text-center">
                                    <button class="btn btn-success btn-sm mx-auto" id="tambahBatch" type="button">
                                        <i class="bx bx-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        </table>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="align-middle">
                                        Kode Batch <span class="text-danger">*</span>
                                    </th>
                                    <th class="align-middle">
                                        Nama Obat <span class="text-danger">*</span>
                                        <div class="text-muted fw-light" style="font-size: 10px !important">Kode | Stok
                                        </div>
                                    </th>
                                    <th class="align-middle">
                                        Jumlah Penggunaan <span class="text-danger">*</span>
                                    </th>
                                    <th class="align-middle">
                                        Catatan
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0 isianBatch">

                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--/ Striped Rows -->
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
                            $('.simpan-row').remove();
                            let body = `
                    <tr class="row-` + data.kode_batch + `">
                        <td>` + data.kode_batch + `</td>
                        <td>` + data.nama_obat + ` 
                        <div class="text-muted fw-light" style="font-size: 10px !important">` + data
                                .kode_obat + ` | ` + data.stok_terkini + `</div></td>
                        <td><input type="number" class="form-control" name="jumlah_penggunaan[]"></td>
                        <td><textarea type="number" class="form-control" name="catatan[]">-</textarea></td>
                        <input type="hidden" name="batch_id[]" value="` + data.batch_id + `">
                    </tr>
                    <tr class="simpan-row">
                        <td colspan="4" class="text-end">
                            <button class="btn btn-sm btn-primary" type="submit"
                                onclick="return confirm('Apakah anda yakin data yang Anda masukkan telah benar secara keseluruhan?')"><i
                                    class="bx bx-save"></i> Simpan</button>
                        </td>
                    </tr>
                `;

                            $('#option_' + data.batch_id).remove();
                            $('.isianBatch').append(body);
                            $('#cariBatch').val('');
                            $('#cariBatch option[value=""]').prop('selected', true);

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
