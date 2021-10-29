@extends('layouts.layout')
@section('title', 'Manajemen Data Tendik')
@section('login_as', 'Kepegawaian')
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
    @include('kepegawaian/sidebar')
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
            <i class="fa fa-home"></i>&nbsp;Data Administrator Remunerasi Tendik Universitas Bengkulu
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
                            <div class="alert alert-danger alert-block" id="keterangan">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Berikut adalah data administrator aplikasi remunarasi tendik universitas bengkulu, silahkan tambahkan admin baru jika dibutuhkan !!
                            </div>
                    @endif
                    <div class="alert alert-success alert-block" style="display:none;" id="berhasil">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="fa fa-success-circle"></i><strong>Berhasil :</strong> Status administrator telah diubah !!
                    </div>

                    <div class="alert alert-danger alert-block" style="display:none;" id="gagal">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="fa fa-success-circle"></i><strong>Gagal :</strong> Status administrator gagal diubah !!
                    </div>
                </div>
                <div class="col-md-12">
                    <a onclick="tambahAdmin()" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-user-plus"></i>&nbsp; Tambah Administrator</a>
                </div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="text-align:center">No</th>
                                <th style="text-align:center">Nama Admin</th>
                                <th style="text-align:center">Email</th>
                                <th style="text-align:center">Password</th>
                                <th style="text-align:center">Status Admin</th>
                                <th style="text-align:center">Ubah Status</th>
                                <th style="text-align:center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <td style="text-align:center;"> {{ $no++ }} </td>
                                    <td style="text-align:center;"> {{ $user->nm_user }} </td>
                                    <td style="text-align:center;"> {{ $user->email }} </td>
                                    <td style="text-align:center;">
                                        <a onclick="ubahPassword( {{ $user->id }} )" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-key"></i></a>
                                    </td>
                                    <td style="text-align:center;">
                                        @if ($user->status == "1")
                                            <span class="badge badge-success"><i class="fa fa-check-circle"></i>&nbsp; Aktif</span>
                                            @else
                                            <span class="badge badge-danger"><i class="fa fa-minus-circle"></i>&nbsp; Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        @if ($user->status == "1")
                                            <a onclick="nonAktifkanStatus( {{ $user->id }} )" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-thumbs-down"></i></a>
                                            @else
                                            <a onclick="aktifkanStatus( {{ $user->id }} )" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-thumbs-up"></i></a>
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        <a onclick="ubahData( {{ $user->id }} )" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-edit"></i></a>
                                        <a onclick="hapusData( {{ $user->id }} )" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <!-- Modal Ubah Password-->
                        <div class="modal fade" id="formubahpassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action=" {{ route('kepegawaian.admin.ubah_password') }} " method="POST">
                                    {{ csrf_field() }} {{ method_field('PATCH') }}
                                    <div class="modal-header">
                                        <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-key"></i>&nbsp;Form Ubah Password Administrator</p>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="hidden" name="id" id="id_password">
                                                <div class="form-group">
                                                    <label for="">Masukan Password Baru :</label>
                                                    <input type="password" name="password_baru" id="password_baru" class="form-control" placeholder="password baru">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Ulangi Password Baru :</label>
                                                    <input type="password" name="password_ulangi" id="password_ulangi" class="form-control" placeholder="ulangi password baru">
                                                    <small id="konfirmasi" style="display:none;" class="form-text text-success"><i>password sama</i></small>
                                                    <small id="konfirmasi-gagal" style="display:none;" class="form-text text-danger"><i>password tidak sama</i></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp; Batalkan</button>
                                        <button type="submit" class="btn btn-primary btn-sm" id="btn-submit" disabled><i class="fa fa-check-circle"></i>&nbsp; Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                            </div>
                        </div>
                    </table>
                    <!-- Modal Ubah -->
                    <div class="modal fade" id="modalubah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action=" {{ route('kepegawaian.admin.update') }} " method="POST">
                                {{ csrf_field() }} {{ method_field('PATCH') }}
                                <div class="modal-header">
                                    <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-key"></i>&nbsp;Form Ubah Data Administrator</p>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="id" id="id_ubah">
                                            <div class="form-group">
                                                <label for="">Nama Lengkap :</label>
                                                <input type="text" name="nm_lengkap" id="nm_lengkap" class="form-control" placeholder="nama lengkap" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="">Email :</label>
                                                <input type="email" name="email" id="email" class="form-control" placeholder="email " required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp; Batalkan</button>
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Simpan Perubahan</button>
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
                        <form action=" {{ route('kepegawaian.admin.delete') }} " method="POST">
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
            <!-- Modal Ubah -->
            <div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action=" {{ route('kepegawaian.admin.add') }} " method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="modal-header">
                            <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-key"></i>&nbsp;Form Tambah Data Administrator</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="id" id="id_ubah">
                                    <div class="form-group">
                                        <label for="">Nama Lengkap :</label>
                                        <input type="text" name="nm_user" class="form-control" placeholder="nama lengkap" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email :</label>
                                        <input type="email" name="email" class="form-control" placeholder="email " required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Password :</label>
                                        <input type="password" name="password" id="password_tambah" class="form-control" placeholder="**** " required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Ulangi Password :</label>
                                        <input type="password" name="password" id="password_tambah_ulangi" class="form-control" placeholder="**** " required>
                                        <small id="konfirmasi-tambah" style="display:none;" class="form-text text-success"><i>password sama</i></small>
                                        <small id="konfirmasi-gagal-tambah" style="display:none;" class="form-text text-danger"><i>password tidak sama</i></small>
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
        $(document).ready(function() {
            $('#table').DataTable({
                responsive : true,
            });
        } );

        function tambahAdmin(){
            $('#modaltambah').modal('show');
        }

        function ubahPassword(id){
            $('#formubahpassword').modal('show');
            $("#id_password").val(id);
        }

        $(document).ready(function(){
            $("#password_baru, #password_ulangi").keyup(function(){
                var password = $("#password_baru").val();
                var ulangi = $("#password_ulangi").val();
                if($("#password_baru").val() == $("#password_ulangi").val()){
                    $('#konfirmasi').show(100);
                    $('#konfirmasi-gagal').hide(100);
                    $('#btn-submit').attr("disabled",false);
                }
                else{
                    $('#konfirmasi').hide(100);
                    $('#konfirmasi-gagal').show(100);
                    $('#btn-submit').attr("disabled",true);
                }
            });
        });

        $(document).ready(function(){
            $("#password_tambah, #password_tambah_ulangi").keyup(function(){
                var password = $("#password_tambah").val();
                var ulangi = $("#password_tambah_ulangi").val();
                if($("#password_tambah").val() == $("#password_tambah_ulangi").val()){
                    $('#konfirmasi-tambah').show(100);
                    $('#konfirmasi-gagal-tambah').hide(100);
                    $('#btn-submit-tambah').attr("disabled",false);
                }
                else{
                    $('#konfirmasi-tambah').hide(100);
                    $('#konfirmasi-gagal-tambah').show(100);
                    $('#btn-submit-tambah').attr("disabled",true);
                }
            });
        });

        function aktifkanStatus(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            url = "{{ url('admin/manajemen_data_administrator/aktifkan_status').'/' }}"+id;
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
            url = "{{ url('admin/manajemen_data_administrator/non_aktifkan_status').'/' }}"+id;
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

        function ubahData(id){
            $.ajax({
                url: "{{ url('admin/manajemen_data_administrator') }}"+'/'+ id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    $('#modalubah').modal('show');
                    $('#id_ubah').val(id);
                    $('#nm_lengkap').val(data.nm_user);
                    $('#email').val(data.email);
                },
                error:function(){
                    alert("Nothing Data");
                }
            });
        }

        function hapusData(id){
            $('#modalhapus').modal('show');
            $('#id_hapus').val(id);
        }
    </script>
@endpush
