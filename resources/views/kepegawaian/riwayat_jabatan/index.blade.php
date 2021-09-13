@extends('layouts.layout')
@section('title', 'Manajemen Riwayat Jabatan')
@section('login_as', 'Kepegawaian')
@section('user-login')
    @if (Auth::check())
    {{ Auth::user()->nm_user }}
    @endif
@endsection
@section('user-login2')
    @if (Auth::check())
    {{ Auth::user()->nm_user }}
    @endif
@endsection
@section('sidebar-menu')
    @include('kepegawaian/sidebar')
@endsection
@push('styles')
    <style>
        .tendik {
            color: #007bff !important;
            background: white;
        }

        .tendik:hover,
        .tendik:focus,
        .tendik:active {
            background-color: white !important;
            color: #007bff !important;
        }
    </style>
@endpush
@section('content')
    <section class="panel" style="margin-bottom:20px;">
        <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
            <i class="fa fa-home"></i>&nbsp;Riwayat Jabatan Remunerasi Tendik Universitas Bengkulu
        </header>
        <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
            <div class="row" style="margin-right:-15px; margin-left:-15px;">
                <div class="col-md-12">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                            <strong>Berhasil :</strong>{{ $message }}
                        </div>
                        @elseif ($message = Session::get('error'))
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>Gagal :</strong>{{ $message }}
                            </div>
                            @else
                                @if (count($riwayats)>0)
                                    <div class="alert alert-success alert-block">
                                        <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Data riwayat jabatan <b style="text-transform:uppercase">{{ $periode_aktif->nm_periode }}</b> sudah digenerate !!
                                    </div>
                                    @else
                                    <div class="alert alert-danger alert-block" id="alert-generate">
                                        <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Data riwayat jabatan <b style="text-transform:uppercase">{{ $periode_aktif->nm_periode }}</b> belum digenerate !!
                                    </div>
                                @endif
                    @endif
                    <div class="alert alert-warning alert-block" id="alert-proses-generate" style="display:none;">
                        <strong><i class="fa fa-info-circle"></i>&nbsp;Harap Tunggu: </strong> Proses Generate Riwayat Jabatan Sedang Berlangsung !!
                    </div>
                </div>
                <div class="col-md-12">
                    @if (count($riwayats)>0)
                        <button class="btn btn-primary btn-sm disabled"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Riwayat Jabatan</button>
                        @else
                        <a href="{{ route('kepegawaian.r_jabatan.generate_riwayat',[$periode_aktif->id]) }}" id="generate" onclick="generateTendik()" class="btn btn-primary btn-sm"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Riwayat Jabatan</a>
                    @endif
                    <button class="btn btn-warning btn-sm disabled" id="proses-generate" style="display:none;color:white;cursor:pointer;"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Riwayat Jabatan</button>
                </div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No</th>
                                <th style="text-align:center;">Nama Lengkap</th>
                                <th style="text-align:center;">Nama Periode</th>
                                <th style="text-align:center;">Jabatan</th>
                                <th style="text-align:center;">Pangkat</th>
                                <th style="text-align:center;">Golongan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($riwayats as $riwayat)
                                <tr>
                                    <td> {{ $no++ }} </td>
                                    <td style="text-align:center"> {{ $riwayat->nm_lengkap }} </td>
                                    <td style="text-align:center"> {{ $riwayat->nm_periode }} </td>
                                    <td style="text-align:center">
                                        @if ($riwayat->nm_jabatan  == null)
                                            <label class="badge badge-danger"><i class="fa fa-minus"></i></label>
                                            @else
                                            {{ $riwayat->nm_jabatan }}
                                        @endif
                                    </td>
                                    <td style="text-align:center"> {{ $riwayat->pangkat }} </td>
                                    <td style="text-align:center"> {{ $riwayat->golongan }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $("table[id^='table']").DataTable({
                responsive : true,
            });
        } );

        function generateTendik(){
            $('#alert-generate').hide(300);
            $('#alert-proses-generate').show(300);
            $('#generate').hide(300);
            $('#proses-generate').show(300);
        }
    </script>
@endpush
