@extends('layouts.layout')
@section('title', 'Manajemen Rubrik Absensu')
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
            <i class="fa fa-home"></i>&nbsp;Rubrik Absensi Remunerasi Tendik Universitas Bengkulu
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
                                @if (count($absensis)>0)
                                    <div class="alert alert-success alert-block">
                                        <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Data tendik <b style="text-transform:uppercase">{{ $periode_aktif->nm_periode }}</b> sudah digenerate, silahkan update potongan per orang (tendik) !!
                                    </div>
                                    @else
                                    <div class="alert alert-danger alert-block">
                                        <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Silahkan Generate Data Tendik Terlebih Dahulu !!
                                    </div>
                                @endif
                    @endif
                </div>
                <div class="col-md-12">
                    <nav aria-label="...">
                        <ul class="pagination">
                          <li class="page-item disabled">
                            <span class="page-link">Previous</span>
                          </li>

                          <li class="page-item active">
                            <span class="page-link">
                                1
                                <span class="sr-only">(current)</span>
                              </span>
                          </li>
                          @if ($periode_aktif->jumlah_bulan == "2")
                              <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_1',[$periode_aktif->id]) }}">2</a></li>
                              <li class="page-item disabled"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_2',[$periode_aktif->id]) }}">3</a></li>
                              @elseif($periode_aktif->jumlah_bulan == "3")
                              <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_1',[$periode_aktif->id]) }}">2</a></li>
                              <li class="page-item disabled"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_2',[$periode_aktif->id]) }}">3</a></li>
                              <li class="page-item disabled"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_3',[$periode_aktif->id]) }}">4</a></li>
                              @elseif($periode_aktif->jumlah_bulan == "4")
                              <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_1',[$periode_aktif->id]) }}">2</a></li>
                              <li class="page-item disabled"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_2',[$periode_aktif->id]) }}">3</a></li>
                              <li class="page-item disabled"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_3',[$periode_aktif->id]) }}">4</a></li>
                              <li class="page-item disabled"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_4',[$periode_aktif->id]) }}">5</a></li>
                              @elseif($periode_aktif->jumlah_bulan == "5")
                              <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_1',[$periode_aktif->id]) }}">2</a></li>
                              <li class="page-item disabled"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_2',[$periode_aktif->id]) }}">3</a></li>
                              <li class="page-item disabled"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_3',[$periode_aktif->id]) }}">4</a></li>
                              <li class="page-item disabled"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_4',[$periode_aktif->id]) }}">5</a></li>
                              <li class="page-item disabled"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_5',[$periode_aktif->id]) }}">6</a></li>
                              @elseif($periode_aktif->jumlah_bulan == "6")
                              <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_1',[$periode_aktif->id]) }}">2</a></li>
                              <li class="page-item disabled"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_2',[$periode_aktif->id]) }}">3</a></li>
                              <li class="page-item disabled"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_3',[$periode_aktif->id]) }}">4</a></li>
                              <li class="page-item disabled"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_4',[$periode_aktif->id]) }}">5</a></li>
                              <li class="page-item disabled"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_5',[$periode_aktif->id]) }}">6</a></li>
                              <li class="page-item disabled"><a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_6',[$periode_aktif->id]) }}">7</a></li>

                          @endif
                          <li class="page-item">
                            <a class="page-link" href="{{ route('kepegawaian.r_absensi.potongan_bulan_1',[$periode_aktif->id]) }}">Next</a>
                          </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-12">
                    @if (count($absensis)>0)
                        <button class="btn btn-primary btn-sm disabled"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Data Tendik</button>
                        @else
                        <a href="{{ route('kepegawaian.r_absensi.generate_tendik',$periode_aktif->id) }}" onclick="geneerateTendik()" class="btn btn-primary btn-sm"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Data Tendik</a>
                    @endif
                </div>
                <div class="col-md-12">
                    <form class="form-inline" method="GET">
                        <div class="form-group mb-2">
                            <label for="filter" class="col-sm-2 col-form-label">Filter</label>
                            <input type="text" class="form-control" id="filter" name="filter" placeholder="Nama/Nip..." value="{{$filter}}">
                        </div>
                        <button type="submit" class="btn btn-default mb-2">Filter</button>
                    </form>
                    <table class="table table-striped table-bordered table-hover" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="text-align:center;" rowspan="2">No</th>
                                <th style="text-align:center;" rowspan="2">Nip</th>
                                <th style="text-align:center;" rowspan="2">Nama Lengkap</th>
                                @if ($periode_aktif->jumlah_bulan == "3")
                                    <th style="text-align:center;" colspan="3">Potongan <a style="color:red;">(%)</a></th>
                                        @elseif($periode_aktif->jumlah_bulan == "2")
                                        <th style="text-align:center;" colspan="2">Potongan <a style="color:red;">(%)</a></th>
                                        @elseif($periode_aktif->jumlah_bulan == "4")
                                        <th style="text-align:center;" colspan="4">Potongan <a style="color:red;">(%)</a></th>
                                        @elseif($periode_aktif->jumlah_bulan == "5")
                                        <th style="text-align:center;" colspan="5">Potongan <a style="color:red;">(%)</a></th>
                                        @elseif($periode_aktif->jumlah_bulan == "6")
                                        <th style="text-align:center;" colspan="6">Potongan <a style="color:red;">(%)</a></th>
                                        @else
                                        <th style="text-align:center;" colspan="1">Potongan <a style="color:red;">(%)</a></th>
                                @endif
                                <th style="text-align:center" rowspan="2">Update Potongan</th>
                            </tr>
                            <tr>
                                @if ($periode_aktif->jumlah_bulan == "3")
                                    <th style="text-align:center;">Bulan 1</th>
                                    <th style="text-align:center;">Bulan 2</th>
                                    <th style="text-align:center;">Bulan 3</th>
                                        @elseif($periode_aktif->jumlah_bulan == "2")
                                        <th style="text-align:center;">Bulan 1</th>
                                        <th style="text-align:center;">Bulan 2</th>
                                        @elseif($periode_aktif->jumlah_bulan == "4")
                                        <th style="text-align:center;">Bulan 1</th>
                                        <th style="text-align:center;">Bulan 2</th>
                                        <th style="text-align:center;">Bulan 3</th>
                                        <th style="text-align:center;">Bulan 4</th>
                                        @elseif($periode_aktif->jumlah_bulan == "5")
                                        <th style="text-align:center;">Bulan 1</th>
                                        <th style="text-align:center;">Bulan 2</th>
                                        <th style="text-align:center;">Bulan 3</th>
                                        <th style="text-align:center;">Bulan 4</th>
                                        <th style="text-align:center;">Bulan 5</th>
                                        @elseif($periode_aktif->jumlah_bulan == "6")
                                        <th style="text-align:center;">Bulan 1</th>
                                        <th style="text-align:center;">Bulan 2</th>
                                        <th style="text-align:center;">Bulan 3</th>
                                        <th style="text-align:center;">Bulan 4</th>
                                        <th style="text-align:center;">Bulan 5</th>
                                        <th style="text-align:center;">Bulan 6</th>
                                            @else
                                            <th style="text-align:center;">Bulan 1</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($absensis as $key => $absen)
                                <tr>
                                    <td> {{ $absensis->firstItem() + $key }} </td>
                                    <td> {{ $absen->nip }} </td>
                                    <td> {{ $absen->nm_lengkap }} </td>
                                    @if ($periode_aktif->jumlah_bulan == "3")
                                        <form action="{{ route('kepegawaian.r_absensi.update_potongan',[$absen->id,$periode_aktif->id]) }}" method="POST">
                                            {{ csrf_field() }} {{ method_field('PATCH') }}
                                            {{-- <input type="hidden" name="periode_id" value="{{ $absen->periode_id }}"> --}}
                                            <td>
                                                <input type="text" name="potongan_bulan_1" class="form-control" value="{{ $absen->potongan_bulan_1 }}">
                                            </td>
                                            <td>
                                                <input type="text" name="potongan_bulan_2" class="form-control" value="{{ $absen->potongan_bulan_2 }}">
                                            </td>
                                            <td>
                                                <input type="text" name="potongan_bulan_3" class="form-control" value="{{ $absen->potongan_bulan_3 }}">
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Update</button>
                                            </td>
                                        </form>
                                        @elseif($periode_aktif->jumlah_bulan == "2")
                                            <form action="{{ route('kepegawaian.r_absensi.update_potongan',[$absen->id,$absen->periode_id]) }}" method="POST">
                                                {{ csrf_field() }} {{ method_field('PATCH') }}
                                                {{-- <input type="hidden" name="periode_id" value="{{ $absen->periode_id }}"> --}}
                                                <td>
                                                    <input type="text" name="potongan_bulan_1" class="form-control" value="{{ $absen->potongan_bulan_1 }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="potongan_bulan_2" class="form-control" value="{{ $absen->potongan_bulan_2 }}">
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Update</button>
                                                </td>
                                            </form>
                                            @elseif($periode_aktif->jumlah_bulan == "4")
                                            <form action="{{ route('kepegawaian.r_absensi.update_potongan',[$absen->id,$periode_aktif->id]) }}" method="POST">
                                                {{ csrf_field() }} {{ method_field('PATCH') }}
                                                {{-- <input type="hidden" name="periode_id" value="{{ $absen->periode_id }}"> --}}
                                                <td>
                                                    <input type="text" name="potongan_bulan_1" class="form-control" value="{{ $absen->potongan_bulan_1 }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="potongan_bulan_2" class="form-control" value="{{ $absen->potongan_bulan_2 }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="potongan_bulan_3" class="form-control" value="{{ $absen->potongan_bulan_3 }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="potongan_bulan_4" class="form-control" value="{{ $absen->potongan_bulan_4 }}">
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Update</button>
                                                </td>
                                            </form>
                                            @elseif($periode_aktif->jumlah_bulan == "5")
                                            <form action="{{ route('kepegawaian.r_absensi.update_potongan',[$absen->id,$periode_aktif->id]) }}" method="POST">
                                                {{ csrf_field() }} {{ method_field('PATCH') }}
                                                {{-- <input type="hidden" name="periode_id" value="{{ $absen->periode_id }}"> --}}
                                                <td>
                                                    <input type="text" name="potongan_bulan_1" class="form-control" value="{{ $absen->potongan_bulan_1 }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="potongan_bulan_2" class="form-control" value="{{ $absen->potongan_bulan_2 }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="potongan_bulan_3" class="form-control" value="{{ $absen->potongan_bulan_3 }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="potongan_bulan_4" class="form-control" value="{{ $absen->potongan_bulan_4 }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="potongan_bulan_5" class="form-control" value="{{ $absen->potongan_bulan_5 }}">
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Update</button>
                                                </td>
                                            </form>
                                            @elseif($periode_aktif->jumlah_bulan == "6")
                                            <form action="{{ route('kepegawaian.r_absensi.update_potongan',[$absen->id,$periode_aktif->id]) }}" method="POST">
                                                {{ csrf_field() }} {{ method_field('PATCH') }}
                                                {{-- <input type="hidden" name="periode_id" value="{{ $absen->periode_id }}"> --}}
                                                <td>
                                                    <input type="text" name="potongan_bulan_1" class="form-control" value="{{ $absen->potongan_bulan_1 }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="potongan_bulan_2" class="form-control" value="{{ $absen->potongan_bulan_2 }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="potongan_bulan_3" class="form-control" value="{{ $absen->potongan_bulan_3 }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="potongan_bulan_4" class="form-control" value="{{ $absen->potongan_bulan_4 }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="potongan_bulan_5" class="form-control" value="{{ $absen->potongan_bulan_5 }}">
                                                </td>
                                                <td>
                                                    <input type="text" name="potongan_bulan_6" class="form-control" value="{{ $absen->potongan_bulan_6 }}">
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Update</button>
                                                </td>
                                            </form>
                                                @else
                                                <form action="{{ route('kepegawaian.r_absensi.update_potongan',[$absen->id,$periode_aktif->id]) }}" method="POST">
                                                    {{ csrf_field() }} {{ method_field('PATCH') }}
                                                    {{-- <input type="hidden" name="periode_id" value="{{ $absen->periode_id }}"> --}}
                                                    <td>
                                                        <input type="text" name="potongan_bulan_1" class="form-control" value="{{ $absen->potongan_bulan_1 }}">
                                                    </td>
                                                    <td>
                                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Update</button>
                                                    </td>
                                                </form>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$absensis->links("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>

    </script>
@endpush
