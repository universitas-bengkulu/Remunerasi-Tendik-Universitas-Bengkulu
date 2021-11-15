@extends('layouts.layout')
@section('title', 'Dashboard')
@section('login_as', 'Tendik')
@section('user-login')
    @if (Auth::guard('tendik')->check())
    {{ Auth::guard('tendik')->user()->nm_lengkap }}
    @endif
@endsection
@section('user-login2')
    @if (Auth::guard('tendik')->check())
    {{ Auth::guard('tendik')->user()->nm_lengkap }}
    @endif
@endsection
@section('sidebar-menu')
    @include('tendik/sidebar')
@endsection
@push('styles')
    <!-- Styles -->
    <style>
        #chartdiv {
        width: 100%;
        height: 500px;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3">
                <section class="panel">
                    <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                        <i class="fa fa-info-circle"></i>&nbsp;Informasi Penilaian
                        <span class="tools pull-right" style="margin-top:-5px;">
                        </span>
                    </header>
                    <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                        <div class="row">
                            <div class="col-lg-12 col-xs-12 col-md-12" style="padding-bottom:10px !important;">
                                <!-- small box -->
                                <div class="small-box bg-aqua" style="margin-bottom:0px;">
                                    <div class="inner">
                                    <h3></h3>

                                    <p>Potongan Absensi</p>
                                    </div>
                                    <div class="icon">
                                    <i class="fa fa-list"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xs-12 col-md-12" style="padding-bottom:10px !important;">
                                <!-- small box -->
                                <div class="small-box bg-red" style="margin-bottom:0px;">
                                    <div class="inner">
                                    <h3></h3>

                                    <p>Potongan Integritas</p>
                                    </div>
                                    <div class="icon">
                                    <i class="fa fa-list-alt"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xs-12 col-md-12" style="padding-bottom:10px !important;">
                                <!-- small box -->
                                <div class="small-box bg-yellow" style="margin-bottom:0px;">
                                    <div class="inner">
                                    <h3></h3>

                                    <p>Potongan SKP</p>
                                    </div>
                                    <div class="icon">
                                    <i class="fa fa-wpforms"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-12 col-xs-12 col-md-12" style="padding-bottom:10px !important;">
                                <!-- small box -->
                                <div class="small-box bg-green" style="margin-bottom:0px;">
                                    <div class="inner">
                                    <h3></h3>

                                    <p>Remunerasi Perbulan</p>
                                    </div>
                                    <div class="icon">
                                    <i class="fa fa-calendar"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-9">
                <section class="panel">
                    <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                        <i class="fa fa-home"></i>&nbsp;Dashboard
                        <span class="tools pull-right" style="margin-top:-5px;">
                            <a class="fa fa-chevron-down" href="javascript:;" style="float: left;margin-left: 3px;padding: 10px;text-decoration: none;"></a>
                            <a class="fa fa-times" href="javascript:;" style="float: left;margin-left: 3px;padding: 10px;text-decoration: none;"></a>
                        </span>
                    </header>
                    <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                        <div class="row">
                            <div class="col-md-12">
                                <div  style="text-align:center;">
                                    <strong>Selamat Datang di aplikasi remunerasi tenaga kependidikan <a href="https://www.unib.ac.id" target="_blank">Universitas Bengkulu</a>. Silahkan lengkapi data pribadi anda, dan lengkapi file rubrik yang dibutuhkan, serta bacalah buku panduan jika disediakan !!</strong>
                                    <p style="margin-bottom:0px;">Jangan lupa keluar setelah menggunkan aplikasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-9" style="margin-bottom:5px;">
                <section class="panel">
                    <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
                        <i class="fa fa-user"></i>&nbsp;Informasi Tenaga Kependidikan
                        <span class="tools pull-right" style="margin-top:-5px;">
                            <a class="fa fa-chevron-down" href="javascript:;" style="float: left;margin-left: 3px;padding: 10px;text-decoration: none;"></a>
                            <a class="fa fa-times" href="javascript:;" style="float: left;margin-left: 3px;padding: 10px;text-decoration: none;"></a>
                        </span>
                    </header>
                    <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom:5px;">
                                @if (empty($about->nm_lengkap) || empty($about->nip) || empty($about->nm_jabatan) || empty($about->kelas_jabatan) || empty($about->golongan) || empty($about->jenis_kelamin) || empty($about->no_rekening) || empty($about->no_npwp))
                                    <div class="alert alert-warning" role="alert">
                                        <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian</strong> Harap untuk melengkapi data anda terlebih dahulu, silahkan tekan tombol <b>Edit Data</b>. Anda tidak dapat mengupload SKP jika data belum lengkap !!
                                    </div>
                                    @else
                                    <div class="alert alert-success" role="alert">
                                        <strong><i class="fa fa-check-circle"></i>&nbsp;Selamat</strong> Data anda sudah lengkap, silahkan tekan tombol <b>Edit Data</b> jika ada kesalahan data, anda sudah dapat mengupload SKP pada menu Rubrik SKP !!
                                    </div>
                                @endif
                                @if ($error = Session::get('error'))
                                    <div class="alert alert-danger alert-block">
                                        <button type="button" class="close" data-dismiss="alert">×</button> 
                                        <strong>Gagal :</strong>{{ $error }}
                                    </div>
                                    @elseif($success = Session::get('success'))
                                    <div class="alert alert-success alert-block">
                                        <button type="button" class="close" data-dismiss="alert">×</button> 
                                        <strong>Berhasil :</strong>{{ $success }}
                                    </div>
                                @endif
                            </div>
                            @include('tendik.form_edit_data_tendik')
                            <div class="col-md-12" style="margin-bottom:5px;" id="button-data">
                                <a onclick="editData()" class="btn btn-primary btn-sm" style="color: white; cursor: pointer;"><i class="fa fa-edit"></i>&nbsp; Edit Data</a>
                                <a onclick="ubahPassword()" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-key"></i>&nbsp; Ubah Password Login</a>
                            </div>
                            <div class="col-md-12" id="table-data">
                                <table class="table">
                                    @if (!empty($about))
                                        <tr>
                                            <th>Nama Lengkap</th>
                                            <td>:</td>
                                            <td>{{ $about->nm_lengkap }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nomor Induk Pegawai</th>
                                            <td>:</td>
                                            <td>{{ $about->nip }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Jabatan</th>
                                            <td>:</td>
                                            <td>
                                                @if (!empty($about->nm_jabatan))
                                                    {{ $about->nm_jabatan }}
                                                    @else
                                                    <label class="badge badge-danger"><i class="fa fa-minus"></i></label>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Nama Jabatan</th>
                                            <td>:</td>
                                            <td>
                                                @if (!empty($about->kelas_jabatan))
                                                    {{ $about->kelas_jabatan }}
                                                    @else
                                                    <label class="badge badge-danger"><i class="fa fa-minus"></i></label>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Golongan</th>
                                            <td>:</td>
                                            <td>
                                                @if (!empty($about->golongan))
                                                    {{ $about->golongan }}
                                                    @else
                                                    <label class="badge badge-danger"><i class="fa fa-minus"></i></label>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Jenis Kelamin</th>
                                            <td>:</td>
                                            <td>
                                                @if (!empty($about->jenis_kelamin))
                                                    <label class="badge badge-primary"><i class="fa fa-male"></i>&nbsp; Laki-Laki</label>
                                                    @else
                                                    <label class="badge badge-success"><i class="fa fa-female"></i>&nbsp; Perempuan</label>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Nomor Rekening</th>
                                            <td>:</td>
                                            <td>
                                                @if (!empty($about->no_rekening))
                                                    {{ $about->no_rekening }}
                                                    @else
                                                    <label class="badge badge-danger"><i class="fa fa-minus"></i></label>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Nomor NPWP</th>
                                            <td>:</td>
                                            <td>
                                                @if (!empty($about->no_npwp))
                                                    {{ $about->no_npwp }}
                                                    @else
                                                    <label class="badge badge-danger"><i class="fa fa-minus"></i></label>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            @include('tendik.form_ubah_password')
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function ubahPassword(){
            $('#modalUbahPassword').modal('show');
        }

        function editData(){
            $('#form-edit').show(300);
            $('#table-data').hide(300);
            $('#button-data').hide(300);
        }

        function batalkanEdit(){
            $('#form-edit').hide(300);
            $('#table-data').show(300);
            $('#button-data').show(300);
        }
    </script>
@endpush