<!-- Modal -->
<div class="modal fade" id="modalUbahPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="{{ route('tendik.ubah_password') }}" method="POST">
            {{ csrf_field() }} {{ method_field("PATCH") }}
            <div class="modal-header">
            <p class="modal-title" id="exampleModalLabel">Ubah password login anda disini</p>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger"><strong>Perhatian: </strong> Pastikan hanya anda yang mengetahui password login yang diinputkan !!</div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Password Baru</label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="*****">
                            </div>
                            {{-- @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror --}}

                            <div class="form-group">
                                <label for="">Password Baru</label>
                                <input type="password" name="ulangi_password" id="ulangi_password" class="form-control @error('ulangi_password') is-invalid @enderror" placeholder="*****">
                            </div>
                            {{-- @error('ulangi_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror --}}
                        </div>
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-sm btn-primary">Simpan Password</button>
            </div>
        </form>
      </div>
    </div>
</div>