@extends('layouts.layout')
@section('title', 'Manajemen Rubrik datasu')
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
@section('content')
    <section class="panel" style="margin-bottom:20px;">
        <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
            <i class="fa fa-home"></i>&nbsp;Rubrik absensi Remunerasi Tendik Universitas Bengkulu
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
                                    <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Nominal potongan bulan 4  <b style="text-transform:uppercase">{{ $periode_aktif->nm_periode }}</b> sudah digenerate !!
                                </div>
                                @else
                                <div class="alert alert-danger alert-block">
                                    <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Silahkan Generate Potongan absensi Bulan Empat Terlebih Dahulu !!
                                </div>
                            @endif
                    @endif
                </div>
                <div class="col-md-12">
                    <nav aria-label="...">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_2',[$periode_id]) }}">Previous</a>
                              </li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_absensi',[$periode_id]) }}">1</a></li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_1',[$periode_id]) }}">2</a></li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_2',[$periode_id]) }}">3</a></li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_3',[$periode_id]) }}">4</a></li>

                          <li class="page-item active">
                            <span class="page-link">
                                5
                                <span class="sr-only">(current)</span>
                              </span>
                          </li>
                          @if ($periode_aktif->jumlah_bulan == "5")
                                <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_5',[$periode_id]) }}">6</a></li>
                                @elseif($periode_aktif->jumlah_bulan == "6")
                                <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_5',[$periode_id]) }}">6</a></li>
                                <li class="page-item disabled"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_6',[$periode_id]) }}">7</a></li>
                          @endif
                          <li class="page-item disabled">
                            <a class="page-link " href="">Next</a>
                          </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-12">
                    @if ($a == "sudah")
                        <button class="btn btn-primary btn-sm disabled"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Nominal Potongan Bulan Empat</button>
                        @else
                        <a href="{{ route('kepegawaian.r_absensi.generate_potongan_bulan_empat',[$periode_id]) }}" onclick="geneerateTendik()" class="btn btn-primary btn-sm"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Nominal Potongan Bulan Empat</a>
                    @endif
                </div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No</th>
                                <th style="text-align:center;">Nama Lengkap</th>
                                <th style="text-align:center">Remunerasi</th>
                                <th style="text-align:center">Persentase Potongan Bulan Tiga</th>
                                <th style="text-align:center">Nominal Potongan Bulan Tiga</th>
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
                                    <td style="text-align:center;">
                                        @if ($data->remunerasi == null)
                                            <label class="badge badge-danger"><i class="fa fa-minus"></i></label>
                                            @else
                                            Rp.{{ number_format($data->remunerasi) }},-
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        {{ $data->potongan_bulan_4 }}%
                                    </td>
                                    <td style="text-align:center;">
                                        Rp.{{ number_format($data->nominal_bulan_4) }},-
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

    </script>
@endpush
