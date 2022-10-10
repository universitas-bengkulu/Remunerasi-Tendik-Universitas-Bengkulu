@extends('layouts.layout')
@section('title', 'Manajemen Rubrik Absensi')
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
            <i class="fa fa-home"></i>&nbsp;Generate Remunerasi Tenaga Kependidikan Universitas Bengkulu
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
                                @if ($a == "sudah")
                                    <div class="alert alert-success alert-block">
                                        <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Rubrik Absensi <b style="text-transform:uppercase">{{ $periode_aktif->nm_periode }}</b> sudah digenerate, silahkan lanjutkan dengan klik tombol next hingga selesai !!
                                    </div>
                                    @else
                                    <div class="alert alert-danger alert-block" id="alert-generate">
                                        <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Silahkan Generate Rubrik Absensi Terlebih Dahulu !!
                                    </div>
                                @endif
                    @endif
                    <div class="alert alert-warning alert-block" id="alert-proses-generate" style="display:none;">
                        <strong><i class="fa fa-info-circle"></i>&nbsp;Harap Tunggu: </strong> Proses Generate Rubrik Absensi Sedang Berlangsung !!
                    </div>
                </div>
                <div class="col-md-12" >
                    <nav aria-label="...">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="{{ route('kepegawaian.rekapitulasi.skp',[$periode_id]) }}">Previous</a>
                            </li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.rekapitulasi',[$periode_id]) }}">1</a></li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.rekapitulasi.data_tendik',[$periode_id]) }}">2</a></li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.rekapitulasi.total_remun',[$periode_id]) }}">3</a></li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.rekapitulasi.integritas',[$periode_id]) }}">4</a></li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.rekapitulasi.skp',[$periode_id]) }}">5</a></li>
                          <li class="page-item active">
                            <span class="page-link">
                                6
                                <span class="sr-only">(current)</span>
                              </span>
                          </li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.rekapitulasi.total_akhir_remun',[$periode_id]) }}">7</a></li>
                          <li class="page-item">
                            <a class="page-link" href="{{ route('kepegawaian.rekapitulasi.total_akhir_remun',[$periode_id]) }}">Next</a>
                          </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-12">

                        <a href="{{ route('kepegawaian.rekapitulasi.generate_absensi',[$periode_id]) }}" id="generate" onclick="generateTendik()" class="btn btn-primary btn-sm"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Rubrik Absensi</a>
                    <button class="btn btn-warning btn-sm disabled" id="proses-generate" style="display:none;color:white;cursor:pointer;"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Rubrik Absensi</button>
                </div>
                <div class="col-md-12 table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No</th>
                                <th style="text-align:center;">Nama</th>
                                @if ($periode_aktif->jumlah_bulan == 1)
                                    <th style="text-align:center;">% Absen Bulan Satu</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Satu</th>
                                @endif
                                @if ($periode_aktif->jumlah_bulan == 2)
                                    <th style="text-align:center;">% Absen Bulan Satu</th>
                                    <th style="text-align:center;">% Absen Bulan Dua</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Satu</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Dua</th>
                                @endif
                                @if ($periode_aktif->jumlah_bulan == 3)
                                    <th style="text-align:center;">% Absen Bulan Satu</th>
                                    <th style="text-align:center;">% Absen Bulan Dua</th>
                                    <th style="text-align:center;">% Absen Bulan Tiga</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Satu</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Dua</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Tiga</th>
                                @endif
                                @if ($periode_aktif->jumlah_bulan == 4)
                                    <th style="text-align:center;">% Absen Bulan Satu</th>
                                    <th style="text-align:center;">% Absen Bulan Dua</th>
                                    <th style="text-align:center;">% Absen Bulan Tiga</th>
                                    <th style="text-align:center;">% Absen Bulan Empat</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Satu</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Dua</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Tiga</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Empat</th>
                                @endif
                                @if ($periode_aktif->jumlah_bulan == 5)
                                    <th style="text-align:center;">% Absen Bulan Satu</th>
                                    <th style="text-align:center;">% Absen Bulan Dua</th>
                                    <th style="text-align:center;">% Absen Bulan Tiga</th>
                                    <th style="text-align:center;">% Absen Bulan Empat</th>
                                    <th style="text-align:center;">% Absen Bulan Lima</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Satu</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Dua</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Tiga</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Empat</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Lima</th>
                                @endif
                                @if ($periode_aktif->jumlah_bulan == 6)
                                    <th style="text-align:center;">% Absen Bulan Satu</th>
                                    <th style="text-align:center;">% Absen Bulan Dua</th>
                                    <th style="text-align:center;">% Absen Bulan Tiga</th>
                                    <th style="text-align:center;">% Absen Bulan Empat</th>
                                    <th style="text-align:center;">% Absen Bulan Lima</th>
                                    <th style="text-align:center;">% Absen Bulan Enam</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Satu</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Dua</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Tiga</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Empat</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Lima</th>
                                    <th style="text-align:center;">Nominal Absensi Bulan Enam</th>
                                @endif
                                <th style="text-align:center;">Total Potongan Absensi Kehadiran {{ $periode_aktif->jumlah_bulan }} Bulan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($datas as $key=> $data)
                                <tr>
                                    <td>{{ $datas->firstItem() + $key }}</td>
                                    <td> {{ $data->nm_lengkap }} </td>
                                    @if ($periode_aktif->jumlah_bulan == 1)
                                        <td>{!! is_null($data->persen_absen_bulan_satu) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_satu !!}</td>

                                        <td>{!! is_null($data->nominal_absen_bulan_satu) ? '<span class="badge badge-danger">-</span>' : $data->nominal_absen_bulan_satu !!}</td>
                                    @endif
                                    @if ($periode_aktif->jumlah_bulan == 2)
                                        <td>{!! is_null($data->persen_absen_bulan_satu) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_satu !!}</td>
                                        <td>{!! is_null($data->persen_absen_bulan_dua) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_dua !!}</td>

                                        <td>{!! is_null($data->nominal_absen_bulan_satu) ? '<span class="badge badge-danger">-</span>' : $data->nominal_absen_bulan_satu !!}</td>
                                        <td>{!! is_null($data->nominal_absen_bulan_dua) ? '<span class="badge badge-danger">-</span>' : $data->nominal_absen_bulan_dua !!}</td>
                                    @endif
                                    @if ($periode_aktif->jumlah_bulan == 3)
                                        <td>{!! is_null($data->persen_absen_bulan_satu) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_satu !!}</td>
                                        <td>{!! is_null($data->persen_absen_bulan_dua) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_dua !!}</td>
                                        <td>{!! is_null($data->persen_absen_bulan_tiga) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_tiga !!}</td>

                                        <td>{!! is_null($data->nominal_absen_bulan_satu) ? '<span class="badge badge-danger">-</span>' : $data->nominal_absen_bulan_satu !!}</td>
                                        <td>{!! is_null($data->nominal_absen_bulan_dua) ? '<span class="badge badge-danger">-</span>' : $data->nominal_absen_bulan_dua !!}</td>
                                        <td>{!! is_null($data->nominal_absen_bulan_tiga) ? '<span class="badge badge-danger">-</span>' : $data->nominal_absen_bulan_tiga !!}</td>
                                    @endif
                                    @if ($periode_aktif->jumlah_bulan == 4)
                                        <td>{!! is_null($data->persen_absen_bulan_satu) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_satu !!}</td>
                                        <td>{!! is_null($data->persen_absen_bulan_dua) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_dua !!}</td>
                                        <td>{!! is_null($data->persen_absen_bulan_tiga) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_tiga !!}</td>
                                        <td>{!! is_null($data->persen_absen_bulan_empat) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_empat !!}</td>

                                        <td>{!! is_null($data->nominal_absen_bulan_satu) ? '<span class="badge badge-danger">-</span>' : $data->nominal_absen_bulan_satu !!}</td>
                                        <td>{!! is_null($data->nominal_absen_bulan_dua) ? '<span class="badge badge-danger">-</span>' : $data->nominal_absen_bulan_dua !!}</td>
                                        <td>{!! is_null($data->nominal_absen_bulan_tiga) ? '<span class="badge badge-danger">-</span>' : $data->nominal_absen_bulan_tiga !!}</td>
                                        <td>{!! is_null($data->nominal_absen_bulan_empat) ? '<span class="badge badge-danger">-</span>' : $data->nominal_absen_bulan_empat !!}</td>
                                    @endif

                                    @if ($periode_aktif->jumlah_bulan == 5)
                                        <td>{!! is_null($data->persen_absen_bulan_satu) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_satu !!}</td>
                                        <td>{!! is_null($data->persen_absen_bulan_dua) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_dua !!}</td>
                                        <td>{!! is_null($data->persen_absen_bulan_tiga) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_tiga !!}</td>
                                        <td>{!! is_null($data->persen_absen_bulan_empat) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_empat !!}</td>
                                        <td>{!! is_null($data->persen_absen_bulan_lima) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_lima !!}</td>

                                        <td>{!! is_null($data->nominal_absen_bulan_satu) ? '<span class="badge badge-danger">-</span>' : $data->nominal_absen_bulan_satu !!}</td>
                                        <td>{!! is_null($data->nominal_absen_bulan_dua) ? '<span class="badge badge-danger">-</span>' : $data->nominal_absen_bulan_dua !!}</td>
                                        <td>{!! is_null($data->nominal_absen_bulan_tiga) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_tiga !!}</td>
                                        <td>{!! is_null($data->nominal_absen_bulan_empat) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_empat !!}</td>
                                        <td>{!! is_null($data->nominal_absen_bulan_lima) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_lima !!}</td>
                                    @endif

                                    @if ($periode_aktif->jumlah_bulan == 6)
                                        <td>{!! is_null($data->persen_absen_bulan_satu) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_satu !!}</td>
                                        <td>{!! is_null($data->persen_absen_bulan_dua) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_dua !!}</td>
                                        <td>{!! is_null($data->persen_absen_bulan_tiga) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_tiga !!}</td>
                                        <td>{!! is_null($data->persen_absen_bulan_empat) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_empat !!}</td>
                                        <td>{!! is_null($data->persen_absen_bulan_lima) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_lima !!}</td>
                                        <td>{!! is_null($data->persen_absen_bulan_enam) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_enam !!}</td>

                                        <td>{!! is_null($data->nominal_absen_bulan_satu) ? '<span class="badge badge-danger">-</span>' : $data->nominal_absen_bulan_satu !!}</td>
                                        <td>{!! is_null($data->nominal_absen_bulan_dua) ? '<span class="badge badge-danger">-</span>' : $data->nominal_absen_bulan_dua !!}</td>
                                        <td>{!! is_null($data->nominal_absen_bulan_tiga) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_tiga !!}</td>
                                        <td>{!! is_null($data->nominal_absen_bulan_enam) ? '<span class="badge badge-danger">-</span>' : $data->persen_absen_bulan_enam !!}</td>
                                    @endif
                                    <td>{!! is_null($data->total_absensi) ? '<span class="badge badge-danger">-</span>' : $data->total_absensi !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$datas->links("pagination::bootstrap-4") }}
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
