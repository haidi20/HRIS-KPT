<div class="modal fade bd-example-modal-lg" id="formModal" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="titleForm"></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="id" name="id" class="form-control">

                    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="personal-tab" data-bs-toggle="tab" href="#personal"
                                role="tab" aria-controls="personal" aria-selected="true">Data Personal</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="kepegawaian-tab" data-bs-toggle="tab" href="#kepegawaian"
                                role="tab" aria-controls="kepegawaian" aria-selected="false">Data Kepegawaian</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="keluarga-tab" data-bs-toggle="tab" href="#keluarga" role="tab"
                                aria-controls="keluarga" aria-selected="false">Data Keluarga</a>
                        </li>
                        {{-- <li class="nav-item" role="presentation">
                            <a class="nav-link" id="rekening-tab" data-bs-toggle="tab" href="#rekening" role="tab"
                                aria-controls="rekening" aria-selected="false">Data Rekening</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="dokumen-tab" data-bs-toggle="tab" href="#dokumen" role="tab"
                                aria-controls="dokumen" aria-selected="false">Data Dokumen</a>
                        </li> --}}
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="personal" role="tabpanel"
                            aria-labelledby="personal-tab">
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label">NIP</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="nik" class="form-control"
                                        value="KPT0123" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label">NIK</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nik" name="nik" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-4 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nama" name="nama" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tempat_lahir" class="col-sm-4 col-form-label">Tempat Lahir</label>
                                <div class="col-sm-8">
                                    <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal_lahir" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                                <div class="col-sm-8">
                                    <input type="text" id="tanggal_lahir" name="tanggal_lahir" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telepon" class="col-sm-4 col-form-label">Telepon</label>
                                <div class="col-sm-8">
                                    <input type="text" id="telepon" name="telepon" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="agama" class="col-sm-4 col-form-label">Agama </label>
                                <div class="col-sm-8">
                                    <select id="agama" name="agama" class="select2 form-select"
                                        style="width: 100%">
                                        <option value="">Pilih Agama</option>
                                        <option value="islam">Islam
                                        </option>
                                        <option value="kristen">
                                            Kristen</option>
                                        <option value="katholik">Katholik</option>
                                        <option value="hindu">Hindu
                                        </option>
                                        <option value="budha">Budha
                                        </option>
                                        <option value="konghucu">Konghucu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-sm-4 col-form-label">Alamat</label>
                                <div class="col-sm-8">
                                    {{-- <input type="text" id="alamat" name="alamat" class="form-control"> --}}
                                    <textarea name="address" id="addreess" cols="60" rows="5" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        {{-- @if (id = 1) --}}
                        {{-- KELUARGA --}}
                        <div class="tab-pane fade" id="keluarga" role="tabpanel" aria-labelledby="keluarga-tab">
                            <div class="form-group row">
                                <label for="nama_ayah" class="col-sm-4 col-form-label">Nama Ayah</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="nama_ayah" id="nama_ayah">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="telepon_ayah" class="col-sm-4 col-form-label">Telepon Ayah</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" name="telepon_ayah"
                                        id="telepon_ayah">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nama_ibu" class="col-sm-4 col-form-label">Nama Ibu</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama_ibu" name="nama_ibu">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="telepon_ibu" class="col-sm-4 col-form-label">Telepon Ibu</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="telepon_ibu" name="telepon_ibu">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nama_saudara" class="col-sm-4 col-form-label">Nama Saudara</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama_saudara"
                                        name="nama_saudara">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="telepon_saudara" class="col-sm-4 col-form-label">Telepon Saudara</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="telepon_saudara"
                                        name="telepon_saudara">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nama_istri" class="col-sm-4 col-form-label">Nama Istri</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama_istri" name="nama_istri">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="telepon_istri" class="col-sm-4 col-form-label">Telepon Istri</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="telepon_istri"
                                        name="telepon_istri">
                                </div>
                            </div>
                        </div>

                        {{-- KEPEGAWAIAN --}}
                        <div class="tab-pane fade" id="kepegawaian" role="tabpanel"
                            aria-labelledby="kepegawaian-tab">
                            <div class="form-group row">
                                <label for="agama" class="col-sm-4 col-form-label"> Jenis Kepegawaian </label>
                                <div class="col-sm-8">
                                    <select id="agama" name="agama" class="select2 form-select" required
                                        style="width: 100%">
                                        <option value="6,1">
                                            6 - 1 (6 hari kerja 1 hari off)
                                        </option>
                                        <option value="5,2">
                                            5 - 2 (5 hari kerja 2 hari off)
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tanggal_masuk" class="col-sm-4 col-form-label">Tanggal Masuk</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control datepicker" id="tanggal_masuk"
                                        name="tanggal_masuk">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="npwp" class="col-sm-4 col-form-label">NPWP</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="npwp" name="npwp">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="keahlian" class="col-sm-4 col-form-label">Keahlian</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="keahlian" name="keahlian">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pendidikan_terakhir" class="col-sm-4 col-form-label">Pendidikan
                                    Terakhir</label>
                                <div class="col-sm-8">
                                    <select name="pendidikan_terakhir" id="pendidikan_terakhir"
                                        class="form-control select2" style="width: 100%;">
                                        <option value="">-- Pilih Pendidikan Terakhir --</option>
                                        {{-- <option value="s3" {{ $pegawai->pendidikan_terakhir == 's3' ? 'selected' : '' }}>S3
                                        </option>
                                        <option value="s2" {{ $pegawai->pendidikan_terakhir == 's2' ? 'selected' : ''
                                            }}>S2
                                        </option>
                                        <option value="s1" {{ $pegawai->pendidikan_terakhir == 's1' ? 'selected' : ''
                                            }}>S1
                                        </option>
                                        <option value="d4" {{ $pegawai->pendidikan_terakhir == 'd4' ? 'selected' : ''
                                            }}>D4
                                        </option>
                                        <option value="d3" {{ $pegawai->pendidikan_terakhir == 'd3' ? 'selected' : ''
                                            }}>D3
                                        </option>
                                        <option value="sma" {{ $pegawai->pendidikan_terakhir == 'sma' ? 'selected' : ''
                                            }}>SMA
                                        </option>
                                        <option value="smk" {{ $pegawai->pendidikan_terakhir == 'smk' ? 'selected' : ''
                                            }}>SMK
                                        </option>
                                        <option value="smp" {{ $pegawai->pendidikan_terakhir == 'smp' ? 'selected' : ''
                                            }}>SMP
                                        </option>
                                        <option value="sd" {{ $pegawai->pendidikan_terakhir == 'sd' ? 'selected' : ''
                                            }}>SD
                                        </option> --}}
                                        <option value="s3">S3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lokasi" class="col-sm-4 col-form-label">Lokasi Pegawai</label>
                                <div class="col-sm-8">
                                    <select name="lokasi" id="lokasi" class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">-- Pilih Lokasi --</option>
                                        {{-- @foreach ($lokasis as $lokasi)
                                    <option value="{{ $lokasi->id }}"
                                        <?php if ($pegawai->lokasi_id == $lokasi->id) {
                                            echo 'selected';
                                        } ?>>
                                        {{ $lokasi->nama_lokasi }}
                                        </option>
                                        @endforeach --}}
                                        <option value="aktif">CREWING</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" id="form-kapal">
                                <label for="lokasi" class="col-sm-4 col-form-label">Pilih Kapal</label>
                                <div class="col-sm-8">
                                    <select name="kapal" id="kapal" class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">-- Pilih Kapal --</option>
                                        {{-- @foreach ($kapals as $kapal)
                                    <option value="{{ $kapal->id }}"
                                        <?php if ($pegawai->kapal_id == $kapal->id) {
                                            echo 'selected';
                                        } ?>>
                                        {{ $kapal->nama_kapal }}
                                        </option>
                                        @endforeach --}}
                                        <option value="aktif">TB. SATRIA 1</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="departemen" class="col-sm-4 col-form-label">Departemen</label>
                                <div class="col-sm-8">
                                    <select name="departemen" id="departemen" class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">-- Pilih Departemen --</option>
                                        {{-- @foreach ($departemens as $departemen)
                                    <option value="{{ $departemen->id }}"
                                        <?php if ($pegawai->departemen_id == $departemen->id) {
                                            echo 'selected';
                                        } ?>>
                                        {{ $departemen->nama_departemen }}
                                        </option>
                                        @endforeach --}}
                                        <option value="aktif">HSE</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="jabatan" class="col-sm-4 col-form-label">Jabatan</label>
                                <div class="col-sm-8">
                                    <select name="jabatan" id="jabatan" class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">-- Pilih Jabatan --</option>
                                        {{-- @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}"
                                        <?php if ($pegawai->jabatan_id == $jabatan->id) {
                                            echo 'selected';
                                        } ?>>
                                        {{ $jabatan->nama_jabatan }}
                                        </option>
                                        @endforeach --}}
                                        <option value="aktif">Juru Minyak</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status_pegawai" class="col-sm-4 col-form-label">Status Kepegawaian</label>
                                <div class="col-sm-8">
                                    <select name="status_pegawai" id="status_pegawai" class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">-- Pilih Status Pegawai --</option>
                                        {{-- @foreach ($status_pegawais as $status_pegawai)
                                    <option value="{{ $status_pegawai->id }}"
                                        <?php if ($pegawai->status_pegawai_id == $status_pegawai->id) {
                                            echo 'selected';
                                        } ?>>
                                        {{ $status_pegawai->nama_status_pegawai }}
                                        </option>
                                        @endforeach --}}
                                        <option value="aktif">Permanent</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="kawin" class="col-sm-4 col-form-label">Kawin</label>
                                <div class="col-sm-8">
                                    <select name="kawin" id="kawin" class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">-- Pilih Kawin --</option>
                                        {{-- @foreach ($kawins as $kawin)
                                    <option value="{{ $kawin->id }}"
                                        <?php if ($pegawai->kawin_id == $kawin->id) {
                                            echo 'selected';
                                        } ?>>
                                        {{ $kawin->status_perkawinan }}
                                        </option>
                                        @endforeach --}}
                                        <option value="aktif">TK/3</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lokasi_pajak" class="col-sm-4 col-form-label">Lokasi Pajak</label>
                                <div class="col-sm-8">
                                    <select name="lokasi_pajak" id="lokasi_pajak" class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">-- Pilih Lokasi Pajak --</option>
                                        {{-- @foreach ($lokasi_pajaks as $lokasi_pajak)
                                    <option value="{{ $lokasi_pajak->id }}"
                                        <?php if ($pegawai->lokasi_pajak_id == $lokasi_pajak->id) {
                                            echo 'selected';
                                        } ?>>
                                        {{ $lokasi_pajak->nama_lokasi_pajak }}
                                        </option>
                                        @endforeach --}}
                                        <option value="aktif">KPP Madya Balikpapan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="status" class="col-sm-4 col-form-label">Status Pegawai</label>
                                <div class="col-sm-8">
                                    <select name="status" id="status" class="form-control select2"
                                        style="width: 100%;">
                                        <option value="">-- Pilih Status --</option>
                                        <option value="aktif">Aktif</option>
                                        <option value="keluar">Keluar</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tanggal_keluar" class="col-sm-4 col-form-label">Tanggal Keluar</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control datepicker" id="tanggal_keluar"
                                        name="tanggal_keluar" placeholder="Tanggal Keluar">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="bpjs">BPJS</label><br>
                                        <div class="form-check form-switch">
                                            <form>
                                                <label class="switch form-check-label"
                                                    title="Aktif / Non-Aktif : BPJS" for="flexSwitchCheckChecked">
                                                    <input type="checkbox" name="toggle"
                                                        class="form-check-input bpjsCheck" data-toggle="toggle"
                                                        id="flexSwitchCheckChecked" data-off="Disabled"
                                                        data-target="1" data-on="Enabled">
                                            </form>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="jkk">JKK</label><br>
                                        <div class="form-check form-switch">
                                            <form>
                                                <label class="switch form-check-label" title="Aktif / Non-Aktif : JKK"
                                                    for="flexSwitchCheckChecked">
                                                    <input type="checkbox" name="toggle"
                                                        class="form-check-input jkkCheck" data-toggle="toggle"
                                                        id="flexSwitchCheckChecked" data-off="Disabled"
                                                        data-target="2" data-on="Enabled">
                                            </form>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="jkm">JKM</label><br>
                                        <div class="form-check form-switch">
                                            <form>
                                                <label class="switch form-check-label" title="Aktif / Non-Aktif : JKM"
                                                    for="flexSwitchCheckChecked">
                                                    <input type="checkbox" name="toggle"
                                                        class="form-check-input jkmCheck" data-toggle="toggle"
                                                        id="flexSwitchCheckChecked" data-off="Disabled"
                                                        data-target="3" data-on="Enabled">
                                            </form>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="jht">JHT</label><br>
                                        <div class="form-check form-switch">
                                            <form>
                                                <label class="switch form-check-label" title="Aktif / Non-Aktif : JHT"
                                                    for="flexSwitchCheckChecked">
                                                    <input type="checkbox" name="toggle"
                                                        class="form-check-input jhtCheck" data-toggle="toggle"
                                                        id="flexSwitchCheckChecked" data-off="Disabled"
                                                        data-target="4" data-on="Enabled">
                                            </form>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="ip">IP</label><br>
                                        <div class="form-check form-switch">
                                            <form>
                                                <label class="switch form-check-label" title="Aktif / Non-Aktif : IP"
                                                    for="flexSwitchCheckChecked">
                                                    <input type="checkbox" name="toggle"
                                                        class="form-check-input ipCheck" data-toggle="toggle"
                                                        id="flexSwitchCheckChecked" data-off="Disabled"
                                                        data-target="5" data-on="Enabled">
                                            </form>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- @else --}}

                        {{-- @endif --}}
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-success">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
