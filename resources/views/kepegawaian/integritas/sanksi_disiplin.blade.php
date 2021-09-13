@extends('layouts.layout')
@section('title', 'Manajemen Rubrik Integritas')
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
            <i class="fa fa-home"></i>&nbsp;Rubrik Integritas Remunerasi Tendik Universitas Bengkulu
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
                                        <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Data Potongan Sanksi Disiplin <b style="text-transform:uppercase">{{ $periode_aktif->nm_periode }}</b> sudah digenerate, silahkan lanjutkan dengan klik tombol next hingga selesai !!
                                    </div>
                                    @else
                                    <div class="alert alert-danger alert-block" id="alert-generate">
                                        <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Silahkan Generate Potongan Sanksi Disiplin Terlebih Dahulu. Jika ada Sanksi Disiplin yang tidak sesuai silahkan diupdate terlebih dahulu sebelum di generate !!
                                    </div>
                                @endif
                    @endif
                    <div class="alert alert-warning alert-block" id="alert-proses-generate" style="display:none;">
                        <strong><i class="fa fa-info-circle"></i>&nbsp;Harap Tunggu: </strong> Proses Generate Potongan Sanksi Disiplin Sedang Berlangsung !!
                    </div>
                </div>
                <div class="col-md-12" >
                    @php
                        $periode_id = $periode_aktif->id;
                    @endphp
                    <nav aria-label="...">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="{{ route('kepegawaian.r_integritas.lhkpn_lhkasn',[$periode_id]) }}">Previous</a>
                            </li>
                          <li class="page-item">
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_integritas',[$periode_id]) }}">1</a></li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_integritas.remun_30',[$periode_id]) }}">2</a></li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_integritas.remun_70',[$periode_id]) }}">3</a></li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_integritas.total_remun',[$periode_id]) }}">4</a></li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_integritas.pajak_pph',[$periode_id]) }}">5</a></li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_integritas.lhkpn_lhkasn',[$periode_id]) }}">6</a></li>
                          <li class="page-item active">
                            <span class="page-link">
                                7
                                <span class="sr-only">(current)</span>
                              </span>
                          </li>
                          </li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_integritas.integritas_satu_bulan',[$periode_id]) }}">8</a></li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_integritas.total_integritas',[$periode_id]) }}">9</a></li>
                          <li class="page-item">
                            <a class="page-link" href="{{ route('kepegawaian.r_integritas.integritas_satu_bulan',[$periode_id]) }}">Next</a>
                          </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-12">
                    @if ($a == "sudah")
                        <button class="btn btn-primary btn-sm disabled"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Potongan Sanksi Disiplin</button>
                        @else
                        <a href="{{ route('kepegawaian.r_integritas.generate_sanksi_disiplin',[$periode_id]) }}" id="generate" onclick="generateTendik()" class="btn btn-primary btn-sm"><i class="fa fa-cog fa-spin"></i>&nbsp;Generate Potongan Sanksi Disiplin</a>
                    @endif
                    <button class="btn btn-warning btn-sm disabled" id="proses-generate" style="display:none;color:white;cursor:pointer;"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Potongan Sanksi Disiplin</button>
                </div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered table-hover" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Sanksi Disiplin</th>
                                <th>Update Laporan</th>
                                <th>Potongan Sanksi Disiplin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($datas as $data)
                                @php
                                    $periode_id_update = Crypt::encrypt($data->periode_id);
                                @endphp
                                <tr>
                                    <td> {{ $no++ }} </td>
                                    <td> {{ $data->nm_lengkap }} </td>
                                    <form action="{{ route('kepegawaian.r_integritas.update_data_sanksi_disiplin',[$data->id]) }}" method="POST">
                                        {{ csrf_field() }} {{ method_field('PATCH') }}
                                        <input type="hidden" name="periode_id" value="{{ $periode_id_update }}">
                                        <td>
                                            <select name="sanksi_disiplin" class="form-control" style="width:100px;">
                                                <option value="tidak"
                                                    @if ($data->sanksi_disiplin == "tidak")
                                                        selected
                                                    @endif
                                                >Tidak</option>
                                                <option value="ada"
                                                    @if ($data->sanksi_disiplin == "ada")
                                                        selected
                                                    @endif
                                                >Ada</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Update</button>
                                        </td>
                                    </form>
                                    <td>
                                        Rp.{{ number_format($data->potongan_sanksi_disiplin) }},-
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
