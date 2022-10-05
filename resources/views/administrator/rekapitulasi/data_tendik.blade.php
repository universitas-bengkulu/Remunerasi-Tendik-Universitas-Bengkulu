@extends('layouts.layout')
@section('title', 'Manajemen Rubrik Integritas')
@section('login_as', 'Administrator')
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
            <i class="fa fa-home"></i>&nbsp; Remunerasi Tenaga Kependidikan Universitas Bengkulu
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
                                @if (count($datas)>0)
                                    <div class="alert alert-success alert-block">
                                        <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Data Tenaga Kependidikan <b style="text-transform:uppercase">{{ $periode_aktif->nm_periode }}</b> sudah digenerate, silahkan lanjutkan dengan klik tombol next hingga selesai !!
                                    </div>
                                    @else
                                    <div class="alert alert-danger alert-block" id="alert-generate">
                                        <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Silahkan Generate Data Tenaga Kependidikan Terlebih Dahulu !!
                                    </div>
                                @endif
                    @endif
                    <div class="alert alert-warning alert-block" id="alert-proses-generate" style="display:none;">
                        <strong><i class="fa fa-info-circle"></i>&nbsp;Harap Tunggu: </strong> Proses Generate Data Tenaga Kependidikan Sedang Berlangsung !!
                    </div>
                </div>
                <div class="col-md-12" >
                    <nav aria-label="...">
                        <ul class="pagination">
                          <li class="page-item">
                            <a class="page-link" href="{{ route('administrator.rekapitulasi',[$periode_id]) }}">Previous</a>
                          </li>
                          <li class="page-item"><a class="page-link" href="{{ route('administrator.rekapitulasi',[$periode_id]) }}">1</a></li>
                          <li class="page-item active">
                            <span class="page-link">
                                2
                                <span class="sr-only">(current)</span>
                              </span>
                          </li>
                          <li class="page-item"><a class="page-link" href="{{ route('administrator.rekapitulasi.total_remun',[$periode_id]) }}">3</a></li>
                          <li class="page-item disabled"><a class="page-link" href="{{ route('administrator.rekapitulasi.integritas',[$periode_id]) }}">4</a></li>
                          <li class="page-item disabled"><a class="page-link" href="{{ route('administrator.rekapitulasi.skp',[$periode_id]) }}">5</a></li>
                          <li class="page-item disabled"><a class="page-link" href="{{ route('administrator.rekapitulasi.persentase_absen',[$periode_id]) }}">6</a></li>
                          <li class="page-item disabled"><a class="page-link" href="{{ route('administrator.rekapitulasi.total_remun',[$periode_id]) }}">7</a></li>
                          <li class="page-item">
                            <a class="page-link" href="{{ route('administrator.rekapitulasi.total_remun',[$periode_id]) }}">Next</a>
                          </li>
                        </ul>
                    </nav>
                </div>
                {{-- <div class="col-md-12">
                    @if (count($datas)>0)
                        <button class="btn btn-primary btn-sm disabled"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Data Tenaga Kependidikan</button>
                        @else
                        <a href="{{ route('administrator.rekapitulasi.generate_data_tendik',[$periode_aktif->id]) }}" id="generate" onclick="generateTendik()" class="btn btn-primary btn-sm"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Data Tenaga Kependidikan</a>
                    @endif
                    <button class="btn btn-warning btn-sm disabled" id="proses-generate" style="display:none;color:white;cursor:pointer;"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Data Tenaga Kependidikan</button>
                </div> --}}
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No</th>
                                <th style="text-align:center;">Nama Lengkap</th>
                                <th style="text-align:center;">Nip</th>
                                <th style="text-align:center;">Pangkat</th>
                                <th style="text-align:center;">Golongan</th>
                                <th style="text-align:center;">Kelas Jabatan</th>
                                <th style="text-align:center;">Nama Jabatan</th>
                                <th style="text-align:center;">Remunerasi Per Bulan</th>
                                <th style="text-align:center;">Jumlah Bulan</th>
                                <th style="text-align:center;">No Rekening</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($datas as $data)
                                <tr>
                                    <td> {{ $no++ }} </td>
                                    <td> {{ $data->nm_lengkap }} </td>
                                    <td> {{ $data->nip }} </td>
                                    <td> {{ $data->pangkat }} </td>
                                    <td> {{ $data->golongan }} </td>
                                    <td style="text-align:center;">
                                        @if ($data->kelas_jabatan == null)
                                            <label class="badge badge-danger"><i class="fa fa-minus"></i></label>
                                            @else
                                            {{ $data->kelas_jabatan }}
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        @if ($data->nm_jabatan == null)
                                            <label class="badge badge-danger"><i class="fa fa-minus"></i></label>
                                            @else
                                            {{ $data->nm_jabatan }}
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        @if ($data->remunerasi_per_bulan == null)
                                            <label class="badge badge-danger"><i class="fa fa-minus"></i></label>
                                            @else
                                            Rp.{{ number_format($data->remunerasi_per_bulan) }},-
                                        @endif
                                    </td>
                                    <td> {{ $data->jumlah_bulan }} </td>
                                    <td style="text-align:center;">
                                        @if ($data->no_rekening == null)
                                            <label class="badge badge-danger"><i class="fa fa-minus"></i></label>
                                            @else
                                            {{ $data->no_rekening }}
                                        @endif
                                    </td>
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


        function generateTendik(){
            $('#alert-generate').hide(300);
            $('#alert-proses-generate').show(300);
            $('#generate').hide(300);
            $('#proses-generate').show(300);
        }
    </script>
@endpush
