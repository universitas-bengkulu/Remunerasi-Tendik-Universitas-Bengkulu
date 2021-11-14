
@extends('layouts.layout')
@section('title', 'Dashboard')
@section('login_as', 'Administrator')
@section('user-login')
    {{ Auth::user()->nama_lengkap }}
@endsection
@section('user-login2')
    {{ Auth::user()->nama_lengkap }}
@endsection
@section('sidebar-menu')
    @include('administrator/sidebar')
@endsection

@push('styles')
<style>
    #detail:hover{
        text-decoration: underline !important;
        cursor: pointer !important;
        color:teal;
    }
    #selengkapnya{
        color:#5A738E;
        text-decoration:none;
        cursor:pointer;
    }
    #selengkapnya:hover{
        color:#007bff;
    }
</style>
@endpush
@section('content')
    <section class="panel" style="margin-bottom:20px;">
        <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
            <i class="fa fa-bullseye"></i>&nbsp;Parameter Target E-Marketing (Tambah Target)
        </header>
        <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
           <div class="row">
               <div class="col-md-12">
                <div class="alert alert-info-new  alert-block">
                    <i class="fa fa-info-circle"></i>&nbsp; <strong>Perhatian :</strong> Harap perhatian beberapa hal berikut sebelum anda mengubah data target
                    <ol>
                        <li>Harap untuk mengubah target yang sesuai dan benar</li>
                        <li>Anda dapat mengubah target selama status target belum diusulkan</li>
                    </ol>
                   
                </div>
               </div>
               <div class="col-md-12">
                   <a href="{{ route('administrator.periodeinsentif') }}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
               </div>
               <hr style="width: 50%">
           </div>
           <form action="{{ route('administrator.periodeinsentif.update',[$periodeinsentif->id]) }}" method="POST">
                {{ csrf_field() }} {{ method_field('PATCH') }}
               <div class="row">
                   <div class="col-md-12">
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger-new  alert-block">
                            <strong>Perhatian </strong>{{ $message }}
                        </div>
                    @endif
                       @if ($errors->any())
                           <div class="alert alert-danger">
                               <strong>Perhatian : </strong>Harap Untuk Mengisi Semua Formulir
                           </div>
                       @endif
                   </div>

                   <div class="form-group">
                    <label for="">Nama Periode : <a style="color:red">*contoh: periode januari - maret 2019</a></label>
                    <input type="text" name="masa_kinerja" value="{{ old('masa_kinerja') }}" class="form-control @error('masa_kinerja') is-invalid @enderror" placeholder="nama periode">
                    <div>
                        @if ($errors->has('masa_kinerja'))
                            <small class="form-text text-danger">{{ $errors->first('masa_kinerja') }}</small>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Periode Pembayaran:</label>
                    <input type="text" name="periode_pembayaran" value="{{ old('periode_pembayaran') }}" class="form-control @error('periode_pembayaran') is-invalid @enderror" placeholder="periode pembayaran ">
                    <div>
                        @if ($errors->has('periode_pembayaran'))
                            <small class="form-text text-danger">{{ $errors->first('periode_pembayaran') }}</small>
                        @endif
                    </div>
                </div>
         
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp; Batalkan</button>
        <button type="submit" class="btn btn-primary btn-sm" id="btn-submit-tambah"><i class="fa fa-check-circle"></i>&nbsp; Simpan Data</button>
    </div>
</form>
</div>
</div>
</div>
</div>
</section>
                  

       
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#kategori').change(function(){
                var kategori = $('#kategori').val();
                if(kategori == "new"){
                    $('#newtarget').show();
                    $('#oldtarget').hide();
                }
                else{
                    $('#oldtarget').show();
                    $('#newtarget').hide();
                }
            });
        });
    </script>
@endpush