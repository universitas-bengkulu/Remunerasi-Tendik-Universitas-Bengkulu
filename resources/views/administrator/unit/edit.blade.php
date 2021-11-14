
@extends('layouts.layout')
@section('title', 'Dashboard')
@section('login_as', 'Administrator')
@section('user-login')
    {{ Auth::user()->nm_user }}
@endsection
@section('user-login2')
    {{ Auth::user()->nm_user }}
@endsection
@section('sidebar-menu')
    @include('backend/administrator/sidebar')
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
                   <a href="{{ route('administrator.periode') }}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-circle-left"></i>&nbsp; Kembali</a>
               </div>
               <hr style="width: 50%">
           </div>
           <form action="{{ route('administrator.periode.update',[$periode->id]) }}" method="POST">
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

                   <div class="form-status_periode col-md-4">
                    <label>Bulan</label>
                    <select name="bulan" class="form-control" id="bulan">
                        <option disabled selected>-- pilih bulan --</option>
                        <option {{ $periode->bulan == "Januari" ? 'selected' : '' }} value="Januari">Januari</option>
                        <option {{ $periode->bulan == "Februari" ? 'selected' : '' }}  value="Februari">Februari</option>
                        <option {{ $periode->bulan == "Maret" ? 'selected' : '' }} value="Maret">Maret</option>
                        <option {{ $periode->bulan == "April" ? 'selected' : '' }}  value="April">April</option>
                        <option {{ $periode->bulan == "Mei" ? 'selected' : '' }}  value="Mei">Mei</option>
                        <option {{ $periode->bulan == "Juni" ? 'selected' : '' }}  value="Juni">Juni</option>
                        <option {{ $periode->bulan == "Juli" ? 'selected' : '' }}  value="Juli">Juli</option>
                        <option {{ $periode->bulan == "Agustus" ? 'selected' : '' }}  value="Agustus">Agustus</option>
                        <option {{ $periode->bulan == "September" ? 'selected' : '' }}  value="September">September</option>
                        <option {{ $periode->bulan == "Oktober" ? 'selected' : '' }}  value="Oktober">Oktober</option>
                        <option {{ $periode->bulan == "November" ? 'selected' : '' }}  value="November">Noverber</option>
                        <option {{ $periode->bulan == "Desember" ? 'selected' : '' }}  value="Desember">Desember</option>

                    </select>
                    @error('bulan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-status_periode col-md-4">
                    <label>Tahun</label>
                    <input type="text" value="{{ $periode->tahun }}" name="tahun" min="4" max="4" id="tahun" class="form-control @error('tahun') is-invalid @enderror">
                    @error('tahun')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-status_periode col-md-4">
                    <label>Triwulan</label>
                    <select name="triwulan" class="form-control" id="triwulan">
                        <option disabled selected>-- pilih triwulan --</option>
                        <option {{ $periode->triwulan == "1" ? 'selected' : '' }}  value="1">Satu (1)</option>
                        <option {{ $periode->bulan == "2" ? 'selected' : '' }}  value="2">Dua (2)</option>
                        <option {{ $periode->bulan == "3" ? 'selected' : '' }} value="3">Tiga (3)</option>
                        <option {{ $periode->bulan == "4" ? 'selected' : '' }} value="4">Empat (4)</option>
                   

                    </select>
                    @error('bulan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                  

                    <div class="col-md-12 text-center">
                        <button type="reset" name="reset" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                        <button type="submit" name="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Simpan Target</button>
                    </div>
               </div>
            </form>
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