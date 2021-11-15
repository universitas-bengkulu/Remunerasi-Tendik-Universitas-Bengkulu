<div class="col-md-12" style="display: none;" id="form-edit">
    <form action="{{ route('tendik.ubah_data') }}" method="POST">
        {{ csrf_field() }} {{ method_field("PATCH") }}
        <div class="row">
            <div class="form-group col-md-6">
                <label for="">Nama Lengkap</label>
                <input type="text" name="nm_lengkap" value="{{ Auth::guard('tendik')->user()->nm_lengkap }}" class="form-control">
                <div>
                    @if ($errors->has('nm_lengkap'))
                        <small class="form-text text-danger">{{ $errors->first('nm_lengkap') }}</small>
                    @endif
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="">NIP</label>
                <input type="text" name="nip" value="{{ Auth::guard('tendik')->user()->nip }}" class="form-control">
                <div>
                    @if ($errors->has('nip'))
                        <small class="form-text text-danger">{{ $errors->first('nip') }}</small>
                    @endif
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="">Pangkat</label>
                <input type="text" name="pangkat" value="{{ Auth::guard('tendik')->user()->pangkat }}" class="form-control">
                <div>
                    @if ($errors->has('pangkat'))
                        <small class="form-text text-danger">{{ $errors->first('pangkat') }}</small>
                    @endif
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="">Golongan</label>
                <input type="text" name="golongan" value="{{ Auth::guard('tendik')->user()->golongan }}" class="form-control">
                <div>
                    @if ($errors->has('golongan'))
                        <small class="form-text text-danger">{{ $errors->first('golongan') }}</small>
                    @endif
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="">Jabatan</label>
                <select name="jabatan" id="jabatan" class="form-control">
                    <option disabled selected>-- pilih jabatan --</option>
                    @foreach ($jabatans as $jabatan)
                        <option value="{{ $jabatan->id }}" {{ $jabatan->id == Auth::guard()->user()->jabatan_id ? 'selected' : '' }}>{{ $jabatan->nm_jabatan }}</option>
                    @endforeach
                </select>
                <div>
                    @if ($errors->has('jabatan'))
                        <small class="form-text text-danger">{{ $errors->first('jabatan') }}</small>
                    @endif
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="">Jenis Kepegawaian</label>
                <input type="text" name="jenis_kepegawaian" value="{{ Auth::guard('tendik')->user()->jenis_kepegawaian }}" class="form-control">
                <div>
                    @if ($errors->has('jenis_kepegawaian'))
                        <small class="form-text text-danger">{{ $errors->first('jenis_kepegawaian') }}</small>
                    @endif
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                    <option disabled selected>-- pilih jenis kelamin --</option>
                    <option value="L" {{ Auth::guard('tendik')->user()->jenis_kelamin == "L" ? 'selected' : '' }}>Laki-Laki</option>
                    <option value="P" {{ Auth::guard('tendik')->user()->jenis_kelamin == "P" ? 'selected' : '' }}>Perempuan</option>
                </select>
                <div>
                    @if ($errors->has('jenis_kelamin'))
                        <small class="form-text text-danger">{{ $errors->first('jenis_kelamin') }}</small>
                    @endif
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="">Nomor Rekening</label>
                <input type="text" name="no_rekening" value="{{ Auth::guard('tendik')->user()->no_rekening }}" class="form-control">
                <div>
                    @if ($errors->has('no_rekening'))
                        <small class="form-text text-danger">{{ $errors->first('no_rekening') }}</small>
                    @endif
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="">Nomor NPWP</label>
                <input type="text" name="no_npwp" value="{{ Auth::guard('tendik')->user()->no_npwp }}" class="form-control">
                <div>
                    @if ($errors->has('no_npwp'))
                        <small class="form-text text-danger">{{ $errors->first('no_npwp') }}</small>
                    @endif
                </div>
            </div>
            <div class="col-md-12" style="text-align: center;">
                <a onclick="batalkanEdit()" style="color: white; cursor:pointer;" class="btn btn-warning btn-sm"><i class="fa fa-arrow-left"></i>&nbsp; Batalkan</a>
                <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Simpan Perubahan</button>
                <hr style="width:50%; text-align:center;" >
            </div>
        </div>
    </form>
</div>