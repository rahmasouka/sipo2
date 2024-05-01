@extends('layout.container')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-2 mt-2 mb-2"><span class="fw-bolder">Riwayat Stok</h4>

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
                            <th class="align-middle">Kode Batch</th>
                            <th class="align-middle">Nama Obat</th>
                            <th class="align-middle">Stok</th>
                            <th class="align-middle">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($result as $key => $v)
                            <tr>
                                <td style="width: 20px !important">{{ $key = $key + 1 }}</td>
                                <td>
                                    {{ $v->kode_batch }}
                                </td>
                                <td>
                                    {{ $v->nama_obat }}
                                    <div style="font-size: 11px" class="text-muted">
                                        {{ $v->kode_obat }}</div>
                                </td>
                                <td class="text-end">
                                    {!! $v->detail == '+'
                                        ? "<span class='badge bg-label-success me-1'>+"
                                        : "<span class='badge bg-label-danger me-1'>-" !!}
                                    {{ number_format(str_replace('-', '', $v->stok)) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $v->ket ?? '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Striped Rows -->
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
