@extends('layout.container')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-2 mt-2 mb-2"><span class="fw-bolder">{{ $title }}</h4>

        <div class="card p-3 mb-3">
            <h5>Detail</h5>
            <table>
                <tr>
                    <td><b>Peminta</b></td>
                    <td>:</td>
                    <td><b>{{ $ditel->nama_pelaku ?? '-' }}</b></td>
                </tr>
                <tr>
                    <td>Tanggal Permintaan</td>
                    <td>:</td>
                    <td>{{ $ditel->created_at }}</td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>:</td>
                    <td><a href="{{ $ditel->surat_permintaan }}" class=""><i class="bx bx-download"></i>
                            Unduh</a></td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>:</td>
                    <td>{{ $ditel->keterangan ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Status Permintaan</td>
                    <td>:</td>
                    <td>{{ $ditel->status_permintaan ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="card p-3">
            {{-- <h5 class="card-header">Striped rows</h5> --}}
            <h5>List Obat</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped datatable_init">
                    <thead>
                        <tr>
                            <th class="align-middle text-center">No</th>
                            <th class="align-middle text-center">
                                Kode Batch
                            </th>
                            <th class="align-middle text-center">Nama Obat
                                <div class="text-muted fw-light" style="font-size: 10px !important">Kode</div>

                            </th>
                            <th class="align-middle text-center text-center">Jumlah Permintaan
                            </th>
                            <th class="align-middle text-center">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($result as $key => $v)
                            <tr>
                                <td style="width: 20px !important">{{ $key = $key + 1 }}</td>
                                <td>
                                    {{ $v->kode_batch }}
                                </td>
                                <td> {{ $v->nama_obat }}
                                    <div class="text-muted fw-light" style="font-size: 10px !important">
                                        {{ $v->kode_obat }}</div>
                                </td>
                                <td class="text-end"> {{ $v->jumlah_permintaan }}
                                    <span class="text-muted fw-light" style="font-size: 10px !important">
                                        {{ $v->nama_satuan }}</span>
                                </td>
                                <td class="text-start">
                                    {{ $v->keterangan }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if (Auth::guard('admin')->check())
            <h4 class="py-2 mt-4 mb-2"><span class="fw-bolder">Tindak Lanjuti Permintaan</h4>

            <div class="card p-3 mb-3">
                <form action="/permintaan-obat/tindak-lanjut" method="post">
                    <input type="hidden" name="permintaan_id" value="{{ $ditel->permintaan_id }}">
                    @csrf
                    <div class="mb-3">
                        <label for="">Status</label>
                        <select name="status_permintaan" class="form-select"
                            {{ $ditel->status_permintaan == 'Diterima' ? 'disabled readonly' : '' }}>
                            <option value="Pending" {{ $ditel->status_permintaan == 'Pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="Ditolak" {{ $ditel->status_permintaan == 'Ditolak' ? 'selected' : '' }}>Ditolak
                            </option>
                            <option value="Diterima" {{ $ditel->status_permintaan == 'Diterima' ? 'selected' : '' }}>
                                Diterima
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Catatan</label>
                        <textarea name="keterangan_admin" id="" cols="30" rows="3" class="form-control"
                            {{ $ditel->status_permintaan == 'Diterima' ? 'disabled readonly' : '' }}>{{ $ditel->keterangan_admin ?? '-' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <button {{ $ditel->status_permintaan == 'Diterima' ? 'disabled readonly' : '' }} type="submit"
                            class="btn btn-sm btn-primary float-end" onclick="return confirm('Apakah Anda yakin?')"><i
                                class="bx bx-save"></i>
                            Simpan</button>
                    </div>
                </form>
            </div>
        @endif
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
                                <td>` + data.nama_obat + `</td>
                                <td>` + data.stok_terkini + `</td>
                                <td><input type="number" class="form-control" name="stok_setelah[]"></td>
                                <input type="hidden" name="batch_id[]" value="` + data.batch_id + `">
                                <input type="hidden" name="stok_awal[]" value="` + data.stok_terkini + `">
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
                            $('.isianBatch').prepend(body);
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
