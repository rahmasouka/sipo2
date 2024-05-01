@extends('layout.container')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-2 mt-2 mb-2"><span class="fw-bolder">Setting Website</h4>
        <div class="mb-3">
        </div>
        <div class="card p-3">
            <form action="/home/setting-save" method="post">
                @csrf

                <input type="hidden" value="{{ $result->setting_id }}" name="setting_id">
                <div class="row">
                    <div class="col-12">
                        <h5 class="font-weight-bold">Customer Service</h5>
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">Nama Customer Service</label>
                        <input type="text" name="cs_nama" id="cs_nama" required="true" class="form-control"
                            aria-describedby="emailHelp" value="{{ $result->cs_nama }}">
                        <div class="mt-2 text-muted" style="font-size: 12px;">Nama admin yang dapat dihubungi</div>
                    </div>
                    <div class="mb-3 col-6">
                        <label class="form-label">Nomor WA CS </label>
                        <input type="text" name="cs_wa" id="cs_wa" class="form-control"
                            aria-describedby="emailHelp" placeholder="eg: 081234567890" value="{{ $result->cs_wa }}">
                        <div class="mt-2 text-muted" style="font-size: 12px;">Pastikan nomor HP telah terdaftar di WhatsApp
                            dan
                            dapat dihubungi</div>
                    </div>
                    <div class="col-12 mt-3">
                        <h5 class="font-weight-bold">Web App</h5>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">App Version </label>
                        <input type="text" name="app_ver" id="app_ver" class="form-control"
                            value="{{ $result->app_ver }}" aria-describedby="emailHelp">
                        <div class="mt-2 text-muted" style="font-size: 12px;">Versi website, akan muncul di halaman login
                            dan
                            footer website </div>
                    </div>
                    {{-- <div class="mb-3">
                        <label class="form-label">Notifikasi (email/wa) </label>
                        <select type="date" name="notif_toggle" id="notif_toggle" class="form-control"
                            aria-describedby="emailHelp">
                            <option value="On" {{ $result->notif_toggle == 'On' ? 'selected' : '' }}>Aktif</option>
                            <option value="Off" style="color: red !important;"
                                {{ $result->notif_toggle == 'Off' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        <div class="mt-2 text-muted" style="font-size: 12px;">Jika off maka website tidak mengirimkan notif
                            apapun kepada pengguna </div>
                    </div> --}}
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary float-end mb-3" data-bs-toggle="modal"
                        onclick="return confirm('Apakah anda yakin data telah terisi dengan benar?')"
                        data-bs-target="#modalTambah" style="border-radius: 3px; font-size: 10px"><i
                            class="bx bxs-save"></i>&nbsp;
                        Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
