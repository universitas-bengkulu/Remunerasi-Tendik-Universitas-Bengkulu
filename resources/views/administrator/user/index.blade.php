@extends('layouts.layout')
@section('title', 'Manajemen Data user')
@section('login_as', 'administrator')
@section('user-login')
    @if (Auth::check())
    {{ Auth::user()->nama_lengkap }}
    @endif
@endsection
@section('user-login2')
    @if (Auth::check())
    {{ Auth::user()->nama_lengkap }}
    @endif
@endsection
@section('sidebar-menu')
    @include('administrator/sidebar')
@endsection
@push('styles')
    <style>
        .user {
            color: #007bff !important;
            background: white;
        }

        .user:hover,
        .user:focus,
        .user:active {
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
                            <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Berikut semua data user yang tersedia, silahkan tambahkan manual jika diperlukan !!
                        </div>
                    @endif
                </div>
                <div class="col-md-12" style="margin-bottom:10px;">
                    <div class="btn-group">
                        <button class="btn btn-primary btn-sm " onclick="tambahuser()">
                          <i class="fa fa-plus"></i>&nbsp;Tambah Data user
                        </button>
                    </div>

                    {{-- <div class="btn-group">
                        <button type="button" id="generate-password" onclick="generatePassword()" class="btn btn-danger btn-sm" >
                          <i class="fa fa-refresh"></i>&nbsp;Generate Password
                        </button>
                    </div> --}}
                </div>
                <div class="col-md-12 form-tambah" id="form-tambah" style="display:none;">
                    <hr style="width:50%;">
                    <form action="{{ route('administrator.user.post') }}" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Nama Lengkap :</label>
                                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="form-control @error('nama_lengkap') is-invalid @enderror" placeholder=" masukan nama lengkap">
                                @error('nama_lengkap')
                                    <small class="form-text text-danger">{{ $errors->first('nama_lengkap') }}</small>
                                @enderror
                            </div>
                          
                            <div class="form-group col-md-4">
                                <label>email :</label>
                                <input type="text" name="email" value="{{ old('email') }}" class="form-control  @error('email') is-invalid @enderror" placeholder=" masukan email">
                                @error('email')
                                    <small class="form-text text-danger">{{ $errors->first('email') }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Password :</label>
                                <input type="text" name="password" value="{{ old('password') }}" class="form-control  @error('password') is-invalid @enderror" placeholder=" masukan password">
                                @error('password')
                                    <small class="form-text text-danger">{{ $errors->first('password') }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Nama unit :</label>
                                <select name="unit_id" class="form-control  @error('unit_id') is-invalid @enderror">
                                    <option value="" selected disabled>-- pilih nama unit --</option>
                                    @foreach ($units as $unit)
                                        <option {{ $unit->id == old('unit_id') ? 'selected' : '' }} value="{{ $unit->id }}">{{ $unit->nm_unit }}</option>
                                    @endforeach
                                </select>                                
                                @error('unit_id')
                                    <small class="form-text text-danger">{{ $errors->first('unit_id') }}</small>
                                @enderror
                            </div>
                        
                            <div class="form-group col-md-4">
                                <label>Role :</label>
                                <select name="role" class="form-control  @error('role') is-invalid @enderror">
                                    <option value="" selected disabled>-- pilih unit --</option>
                                    <option {{ old('role') == "kepegawaian" ? 'selected' : '' }} value="kepegawaian">Kepegawaian</option>
                                    <option {{ old('role') == "administrator" ? 'selected' : '' }} value="administrator">administrator</option>
                                    <option {{ old('role') == "operator" ? 'selected' : '' }} value="operator">Operator</option>
                                    <option {{ old('role') == "verifikator" ? 'selected' : '' }} value="verifikator">verifikator</option>
                                    <option {{ old('role') == "pimpinan" ? 'selected' : '' }} value="pimpinan">pimpinan</option>

                                </select>                                
                                @error('role')
                                    <small class="form-text text-danger">{{ $errors->first('role') }}</small>
                                @enderror
                            </div>
                          
                            
                          
                          
                        </div>
                        <div class="col-md-12" style="text-align:center;">
                            <a onclick="batalkan()" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-close"></i>&nbsp; Batalkan</a>
                            <button type="reset" class="btn btn-warning btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Simpan Data user</button>
                        </div>
                    </form>
                    <hr style="width:50%;">
                </div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Unit</th>
                                <th>jabatan</th>


                                <th>status</th>
                                <th>Ubah status</th>
                               
                                <th>Ubah Password</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <td> {{ $no++ }} </td>
                                    <td> {{ $user->nama_lengkap }} </td>
                                    <td> {{ $user->email }} </td>
                                    <td> {{ $user->nm_unit }} </td>
                                    <td> {{ $user->role }} </td>
                                    <td style="text-align:center;">
                                        @if ($user->status == "aktif")
                                            <span class="badge badge-success"><i class="fa fa-check-circle"></i>&nbsp; Aktif</span>
                                            @else
                                            <span class="badge badge-danger"><i class="fa fa-minus-circle"></i>&nbsp; Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        @if ($user->status == "aktif")
                                            <a onclick="nonAktifkanStatus( {{ $user->id }} )" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-thumbs-down"></i></a>
                                            @else
                                            <a onclick="aktifkanStatus( {{ $user->id }} )" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-thumbs-up"></i></a>
                                        @endif
                                    </td>

                                   
                                  
                                    <td>
                                        <a onclick="ubahPassword({{ $user->id }})" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-key"></i></a>
                                    </td>
                                    <td>
                                        <a onclick="ubahuser({{ $user->id }})" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-edit"></i></a>
                                        <a onclick="hapususer({{ $user->id }})" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-trash"></i></a>
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
                              <p class="modal-title" style="font-size:17px;"><i class="fa fa-edit"></i>&nbsp;Form Ubah Data user</p>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form action="{{ route('administrator.user.update') }}" method="POST">
                                <div class="modal-body">
                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="alert alert-danger" role="alert">
                                                    <strong>Perhatian :</strong> Silahkan ubah data Tenaga Kependidikan (user) Jika terdapat kesalahan data !!
                                                </div>
                                            </div>
                                            <input type="hidden" name="id_ubah" id="id_ubah">
                                            <div class="form-group col-md-12">
                                                <label>Nama Lengkap :</label>
                                                <input type="text" name="nama_lengkap" id="nama_lengkap" required class="form-control" placeholder=" masukan nama lengkap">
                                            </div>
                                           
                                            <div class="form-group col-md-12">
                                                <label>email :</label>
                                                <input type="text" name="email" id="email" required class="form-control" placeholder=" masukan email">
                                            </div>
                                           
                                        <div class="form-group col-md-12">
                                            <label>Nama Jabatan : </label>
                                            <select name="unit_id" id="unit_id" required class="form-control">
                                                <option value="" selected disabled>-- pilih nama unit --</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}">{{ $unit->nm_unit }}</option>
                                                @endforeach
                                            </select>                                
                                        </div>
                                       
                                        <div class="form-group col-md-12">
                                            <label>Role :</label>
                                            <select name="role" class="form-control  @error('role') is-invalid @enderror">
                                                <option value="" selected disabled>-- pilih unit --</option>
                                                <option {{ old('role') == "kepegawaian" ? 'selected' : '' }} value="kepegawaian">Kepegawaian</option>
                                                <option {{ old('role') == "administrator" ? 'selected' : '' }} value="administrator">administrator</option>
                                                <option {{ old('role') == "operator" ? 'selected' : '' }} value="operator">Operator</option>
                                                <option {{ old('role') == "verifikator" ? 'selected' : '' }} value="verifikator">verifikator</option>
                                                <option {{ old('role') == "pimpinan" ? 'selected' : '' }} value="pimpinan">pimpinan</option>
            
                                            </select>                                
                                            @error('role')
                                                <small class="form-text text-danger">{{ $errors->first('role') }}</small>
                                            @enderror
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
                            <form action=" {{ route('administrator.user.delete') }} " method="POST">
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
            <div class="modal fade" id="modalgeneratepassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action=" {{ route('administrator.user.generate_password') }} " method="POST">
                            {{ csrf_field() }} {{ method_field('POST') }}
                            <div class="modal-header">
                                <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-key"></i>&nbsp;Form Generate Password user</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-danger">
                                            <i class="fa fa-info-circle"></i>&nbsp;Form generate password untuk seluruh user aktif
                                        </div>
                                        <div class="form-group">
                                            <label for="">Masukan Password</label>
                                            <input type="password" name="password" id="password" class="form-control password">
                                        </div>

                                        <div class="form-group">
                                            <label for="">Konfirmasi Password</label>
                                            <input type="password" name="password2" id="password2" class="form-control password2">
                                        </div>
                                        <div>
                                            <a class="password_sama" style="color: green; font-size:12px; font-style:italic; display:none;"><i class="fa fa-check-circle"></i>&nbsp;Password Sama!!</a>
                                            <a class="password_tidak_sama" style="color: red; font-size:12px; font-style:italic; display:none;"><i class="fa fa-close"></i>&nbsp;Password Tidak Sama!!</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp; Batalkan</button>
                                <button type="submit" class="btn btn-primary btn-sm" id="btn-submit" disabled><i class="fa fa-check-circle"></i>&nbsp; Generate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalubahpassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action=" {{ route('administrator.user.ubah_password') }} " method="POST">
                        {{ csrf_field() }} {{ method_field('PATCH') }}
                        <div class="modal-header">
                            <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-key"></i>&nbsp;Form Ubah Password AKun user</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        <i class="fa fa-info-circle"></i>&nbsp;Form ubah password akun user
                                    </div>
                                    <input type="hidden" name="id" id="id">
                                    <div class="form-group">
                                        <label for="">Masukan Password</label>
                                        <input type="password" name="password_ubah" id="password_ubah" class="form-control password">
                                    </div>

                                    <div class="form-group">
                                        <label for="">Konfirmasi Password</label>
                                        <input type="password" name="password_ubah2" id="password_ubah2" class="form-control password2">
                                    </div>
                                    <div>
                                        <a class="password_ubah_sama" style="color: green; font-size:12px; font-style:italic; display:none;"><i class="fa fa-check-circle"></i>&nbsp;Password Sama!!</a>
                                        <a class="password_ubah_tidak_sama" style="color: red; font-size:12px; font-style:italic; display:none;"><i class="fa fa-close"></i>&nbsp;Password Tidak Sama!!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp; Batalkan</button>
                            <button type="submit" class="btn btn-primary btn-sm" id="btn-submit-ubah" disabled><i class="fa fa-check-circle"></i>&nbsp; Ubah Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
            });
        } );

        function tambahuser(){
            $('#form-tambah').show(300);
            $('#alert-generate').hide(300);
            $('#sedang-generate').hide(300);
            $('#generate-unit').hide(300);
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

        function ubahuser(id){
            $.ajax({
                url: "{{ url('administrator/user') }}"+'/'+ id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    $('#form-tambah').hide(300);
                    $('#modalubah').modal('show');
                    $('#id_ubah').val(id);
                    $('#nama_lengkap').val(data.nama_lengkap)
                 
                    $('#email').val(data.email)
                    $('#password').val(data.password)
                    $('#unit_id').val(data.unit_id)
                 
                    $('#role').val(data.role)
                 
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
            url = "{{ url('administrator/user/aktifkan_status').'/' }}"+id;
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
            url = "{{ url('administrator/user/non_aktifkan_status').'/' }}"+id;
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


        function hapususer(id){
            $('#modalhapus').modal('show');
            $('#id_hapus').val(id);
        }

        @if (count($errors) > 0)
            $('#form-tambah').show(300);
        @endif
    </script>
@endpush
