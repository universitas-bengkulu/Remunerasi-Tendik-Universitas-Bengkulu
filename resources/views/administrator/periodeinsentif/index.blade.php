@extends('layouts.layout')
@section('title', 'Manajemen Data periode')
@section('login_as', 'administrator')
@section('user-login')
    @if (Auth::check())
    {{ Auth::user()->nama_periode }}
    @endif
@endsection
@section('user-login2')
    @if (Auth::check())
    {{ Auth::user()->nama_periode }}
    @endif
@endsection
@section('sidebar-menu')
    @include('administrator/sidebar')
@endsection
@push('styles')
    <style>
        .periode {
            color: #007bff !important;
            background: white;
        }

        .periode:hover,
        .periode:focus,
        .periode:active {
            background-color: white !important;
            color: #007bff !important;
        }
    </style>
@endpush
@section('content')
    <section class="panel" style="margin-bottom:20px;">
        <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
            <i class="fa fa-home"></i>&nbsp;Remunerasi Tenaga Kependidikan Universitas Bengkulu
        </header>
        <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
            <div class="row" style="margin-right:-15px; margin-left:-15px;">
                <div class="col-md-12">
                    @if ($message   = Session::get('success'))
                        <div class="alert alert-success alert-block" id="keterangan">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong><i class="fa fa-info-circle"></i>&nbsp;Berhasil: </strong> {{ $message }}
                        </div>
                        @else
                        <div class="alert alert-success alert-block" id="keterangan">
                            <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Berikut semua data periode yang tersedia, silahkan tambahkan manual jika diperlukan !!
                        </div>
                    @endif
                </div>
                <div class="col-md-12" style="margin-bottom:10px;">
                    <div class="btn-group">
                        <button class="btn btn-primary btn-sm " onclick="tambahperiodeinsentif()">
                          <i class="fa fa-plus"></i>&nbsp;Tambah Data periode Insentif
                        </button>
                    </div>

                
                </div>
                <div class="col-md-12 form-tambah" id="form-tambah" style="display:none;">
                    <hr style="width:50%;">
                    <form action="{{ route('administrator.periodeinsentif.post') }}" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Nama periode P3 :</label>
                                <input type="text" name="masa_kinerja" value="{{ old('masa_kinerja') }}" class="form-control @error('masa_kinerja') is-invalid @enderror" placeholder=" masukan nama periodeinsentif">
                                @error('masa_kinerja')
                                    <small class="form-text text-danger">{{ $errors->first('masa_kinerja') }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>periode_pembayaran :</label>
                                <input type="text" name="periode_pembayaran" value="{{ old('periode_pembayaran') }}" class="form-control  @error('periode_pembayaran') is-invalid @enderror" placeholder=" masukan periode_pembayaran">
                                @error('periode_pembayaran')
                                    <small class="form-text text-danger">{{ $errors->first('periode_pembayaran') }}</small>
                                @enderror
                            </div>
           
                            
                            <div class="form-group col-md-4">
                                <label>Status :</label>
                                <select name="status" class="form-control  @error('status') is-invalid @enderror">
                                    <option value="" selected disabled>-- pilih Status --</option>
                                    <option {{ old('status') == "aktif" ? 'selected' : '' }} value="aktif">Aktif</option>
                                    <option {{ old('status') == "nonaktif" ? 'selected' : '' }} value="nonaktif">Nonaktif</option>
                                </select>                                
                                @error('status')
                                    <small class="form-text text-danger">{{ $errors->first('status') }}</small>
                                @enderror
                            </div>
                        
                        </div>
                        <div class="col-md-12" style="text-align:center;">
                            <a onclick="batalkan()" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-close"></i>&nbsp; Batalkan</a>
                            <button type="reset" class="btn btn-warning btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Simpan Data periodeinsentif</button>
                        </div>
                    </form>
                    <hr style="width:50%;">
                </div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Periode P3</th>
                                <th>Periode Pembayaran</th>
                          
                                <th>Status</th>
                                <th>Ubah Status</th>

                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($periodeinsentifs as $periodeinsentif)
                                <tr>
                                    <td> {{ $no++ }} </td>
                                    <td> {{ $periodeinsentif->masa_kinerja}} </td>
                                    <td> {{ $periodeinsentif->periode_pembayaran }} </td>
   
                                    <td style="text-align:center;">
                                        @if ($periodeinsentif->status == "aktif")
                                            <span class="badge badge-success"><i class="fa fa-check-circle"></i>&nbsp; Aktif</span>
                                            @else
                                            <span class="badge badge-danger"><i class="fa fa-minus-circle"></i>&nbsp; Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        @if ($periodeinsentif->status == "aktif")
                                            <a onclick="nonAktifkanStatus( {{ $periodeinsentif->id }} )" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-thumbs-down"></i></a>
                                            @else
                                            <a onclick="aktifkanStatus( {{ $periodeinsentif->id }} )" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-thumbs-up"></i></a>
                                        @endif
                                    </td>

                                
                                    <td>
                                        <a onclick="editPeriodeinsentif({{ $periodeinsentif->id }})" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-edit"></i></a>
                                        <a onclick="hapusperiodeinsentif({{ $periodeinsentif->id }})" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- modal ubah-->
                    <div class="modal fade" id="modalubah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <p class="modal-title" style="font-size:17px;"><i class="fa fa-edit"></i>&nbsp;Form Ubah Data periodeinsentif</p>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="{{ route('administrator.periodeinsentif.update') }}" method="POST">
                                <div class="modal-body">
                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="alert alert-danger" role="alert">
                                                    <strong>Perhatian :</strong> Silahkan ubah data Tenaga Kependidikan (periodeinsentif) Jika terdapat kesalahan data !!
                                                </div>
                                            </div>
                                            <input type="hidden" name="id" id="id_ubah">
                                            <div class="form-group col-md-12">
                                                <label>Nama Periode P3 :</label>
                                                <input type="text" name="masa_kinerja" id="masa_kinerja" required class="form-control" placeholder=" masukan nama periodeinsentif">
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>periode_pembayaran :</label>
                                                <input type="date" name="periode_pembayaran" id="periode_pembayaran" required class="form-control" placeholder=" masukan periode_pembayaran">
                                            </div>
                                           
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Batalkan</button>
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp;Simpan Perubahan</button>
                                </div>
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Hapus-->
                <div class="modal fade" id="modalhapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action=" {{ route('administrator.periodeinsentif.delete') }} " method="POST">
                                {{ csrf_field() }} {{ method_field('DELETE') }}
                                <div class="modal-header">
                                    <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-key"></i>&nbsp;Form Konfirmasi Hapus Data</p>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="id" id="id_hapus">
                                            Apakah anda yakin ingin menghapus data? klik hapus jika iya !!
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp; Batalkan</button>
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Ya, Hapus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
     
      
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
            });
        } );

        function tambahperiodeinsentif(){
            $('#form-tambah').show(300);
            $('#alert-generate').hide(300);
            $('#sedang-generate').hide(300);
            $('#generate-jabatan').hide(300);
            $('#generate-password').hide(300);
        }

        function ubahPassword(id){
            $('#modalubahpassword').modal('show');
            $('#id_password').val(id);
            $('#id').val(id);
        }
        
        function batalkan(){
            $('#form-tambah').hide(300);
            $('#generate').show(300);
        }

        function generatePassword(){
            $('#modalgeneratepassword').modal('show');
        }

        $(document).ready(function(){
            $("#password, #password2").keyup(function(){
                var password = $("#password").val();
                var ulangi = $("#password2").val();
                if($("#password").val() == $("#password2").val()){
                    $('.password_sama').show(200);
                    $('.password_tidak_sama').hide(200);
                    $('#btn-submit').attr("disabled",false);
                }
                else{
                    $('.password_sama').hide(200);
                    $('.password_tidak_sama').show(200);
                    $('#btn-submit').attr("disabled",true);
                }
            });
        });

        $(document).ready(function(){
            $("#password_ubah, #password_ubah2").keyup(function(){
                var password_ubah = $("#password_ubah").val();
                var ulangi = $("#password_ubah2").val();
                if($("#password_ubah").val() == $("#password_ubah2").val()){
                    $('.password_ubah_sama').show(200);
                    $('.password_ubah_tidak_sama').hide(200);
                    $('#btn-submit-ubah').attr("disabled",false);
                }
                else{
                    $('.password_ubah_sama').hide(200);
                    $('.password_ubah_tidak_sama').show(200);
                    $('#btn-submit-ubah').attr("disabled",true);
                }
            });
        });

        function editPeriodeinsentif(id){
            $.ajax({
                url: "{{ url('administrator/periodeinsentif') }}"+'/'+ id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    
                    $('#modalubah').modal('show');
                    $('#id_ubah').val(id);
                    $('#masa_kinerja').val(data.masa_kinerja)
                    $('#periode_pembayaran').val(data.periode_pembayaran)
  
                    $('#status').val(data.status)
                  
                },
                error:function(){
                    alert("Nothing Data");
                }
            });
        }
        function aktifkanStatus(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            url = "{{ url('administrator/periodeinsentif/aktifkan_status').'/' }}"+id;
            $.ajax({
                url : url,
                type : 'PATCH',
                success : function($data){
                    $('#berhasil').show(100);
                    location.reload();
                },
                error:function(){
                    $('#gagal').show(100);
                }
            });
            return false;
        }

        function nonAktifkanStatus(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            url = "{{ url('administrator/periodeinsentif/non_aktifkan_status').'/' }}"+id;
            $.ajax({
                url : url,
                type : 'PATCH',
                success : function($data){
                    $('#berhasil').show(100);
                    location.reload();
                },
                error:function(){
                    $('#gagal').show(100);
                }
            });
            return false;
        }

        function hapusperiodeinsentif(id){
            $('#modalhapus').modal('show');
            $('#id_hapus').val(id);
        }

      
    </script>
@endpush
