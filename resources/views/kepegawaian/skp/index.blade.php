@extends('layouts.layout')
@section('title', 'Manajemen Rubrik SKP')
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
@section('content')
    <section class="panel" style="margin-bottom:20px;">
        <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
            <i class="fa fa-home"></i>&nbsp;Rubrik Capaian SKP Remunerasi Tendik Universitas Bengkulu
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
                            @if ($jumlah_tendik == $jumlah_skp)
                                <div class="alert alert-succwss alert-block" id="keterangan">
                                    <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Semua Tenaga Kependidikan Sudah Mengirimkan File dan Nilai SKP !!
                                </div>
                                @else
                                <div class="alert alert-danger alert-block" id="keterangan">
                                    <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Baru {{ $jumlah_skp }} / {{ $jumlah_tendik }} Tenaga Kependidikan yang mengirimkan file dan nilai SKP !!
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
                            @php
                                $periode_id = $periode_aktif->id;
                            @endphp
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_skp.generate',[$periode_id]) }}">2</a></li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_skp.generate_nominal',[$periode_id]) }}">3</a></li>
                          <li class="page-item">
                            <a class="page-link" href="{{ route('kepegawaian.r_skp.generate',[$periode_id],[$periode_id]) }}">Next</a>
                          </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-12">
                    <div style="margin-bottom:10px;">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a class="nav-item nav-link active" data-toggle="tab" href="#nav-skp"><i class="fa fa-book"></i>&nbsp;Menunggu Verifikasi</a></li>
                            <li><a class="nav-item nav-link" data-toggle="tab" href="#nav-verified"><i class="fa fa-list-alt"></i>&nbsp;Sudah Verifikasi</a></li>
                        </ul>
                    </div>
                    
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-skp" role="tabpanel" aria-labelledby="nav-honor-tab">
                            <div class="row">
                                <div class="col-md-12" style="margin-top:10px;">
                                    <table class="table table-striped table-bordered" id="table" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nip</th>
                                                <th>Nama Lengkap</th>
                                                <th>Nilai Skp</th>
                                                <th>Periode</th>
                                                <th>Downlod File</th>
                                                <th>Status</th>
                                                <th>Verifikasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no=1;
                                            @endphp
                                            @foreach ($skps as $skp)
                                                <tr>
                                                    <td> {{ $no++ }} </td>
                                                    <td> {{ $skp->nip }} </td>
                                                    <td> {{ $skp->nm_lengkap }} </td>
                                                    <td> {{ $skp->nilai_skp }} </td>
                                                    <td> {{ $skp->nm_periode }} </td>
                                                    <td>
                                                        <a href="{{ asset('storage/'.$skp->path) }}" download="file_skp{{ $skp->nip }}"><i class="fa fa-download"></i>&nbsp; download file skp</a>
                                                    </td>
                                                    <td>
                                                        @if ($skp->status == "0")
                                                            <label class="badge badge-warning" style="color:white;"><i class="fa fa-clock-o"></i>&nbsp; Belum Dikirimkan</label>
                                                            @elseif($skp->status == "1")
                                                            <label class="badge badge-info" style="color:white;"><i class="fa fa-clock-o"></i>&nbsp; Menunggu Verifikasi</label>
                                                            @elseif($skp->status == "2")
                                                            <label class="badge badge-success" style="color:white;"><i class="fa fa-clock-o"></i>&nbsp; Disetujui</label>
                                                        @endif
                                                    </td>
                                                    <td style="text-align:center;">
                                                        @if ($skp->status == "1")
                                                            <a onclick="verifikasi({{ $skp->id }})" class="btn btn-primary btn-sm" style="color:white;cursor:pointer;"><i class="fa fa-check-circle"></i></a>
                                                            @else
                                                            <button class="btn btn-primary btn-sm disabled" style="color:white;cursor:pointer;"><i class="fa fa-check-circle"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="nav-verified" role="tabpanel" aria-labelledby="nav-honor-tab">
                            <div class="row">
                                <div class="col-md-12" style="margin-top:10px;">
                                    <table class="table table-striped table-bordered" id="table" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nip</th>
                                                <th>Nama Lengkap</th>
                                                <th>Nilai Skp</th>
                                                <th>Periode</th>
                                                <th>Downlod File</th>
                                                <th>Status</th>
                                                <th>Verifikasi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no=1;
                                            @endphp
                                            @foreach ($verifieds as $skp)
                                                <tr>
                                                    <td> {{ $no++ }} </td>
                                                    <td> {{ $skp->nip }} </td>
                                                    <td> {{ $skp->nm_lengkap }} </td>
                                                    <td> {{ $skp->nilai_skp }} </td>
                                                    <td> {{ $skp->nm_periode }} </td>
                                                    <td>
                                                        <a href="{{ asset('storage/'.$skp->path) }}" download="{{ $skp->path }}"><i class="fa fa-download"></i>&nbsp; download file skp</a>
                                                    </td>
                                                    <td>
                                                        @if ($skp->status == "0")
                                                            <label class="badge badge-warning" style="color:white;"><i class="fa fa-clock-o"></i>&nbsp; Belum Dikirimkan</label>
                                                            @elseif($skp->status == "1")
                                                            <label class="badge badge-info" style="color:white;"><i class="fa fa-clock-o"></i>&nbsp; Menunggu Verifikasi</label>
                                                            @elseif($skp->status == "2")
                                                            <label class="badge badge-success" style="color:white;"><i class="fa fa-clock-o"></i>&nbsp; Disetujui</label>
                                                            @else
                                                            <label class="badge badge-danger" style="color:white;"><i class="fa fa-clock-o"></i>&nbsp; Ditolak</label>
                                                        @endif
                                                    </td>
                                                    <td style="text-align:center;">
                                                        @if ($skp->status == "0")
                                                            <a onclick="verifikasi({{ $skp->id }})" class="btn btn-primary btn-sm" style="color:white;cursor:pointer;"><i class="fa fa-check-circle"></i></a>
                                                            @else
                                                            <button class="btn btn-primary btn-sm disabled" style="color:white;cursor:pointer;"><i class="fa fa-check-circle"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Verifikasi -->
                    <div class="modal fade" id="modalubah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md" role="document">
                            <div class="modal-content">
                                <form action=" {{ route('kepegawaian.r_skp.verifikasi') }} " method="POST">
                                    {{ csrf_field() }} {{ method_field('PATCH') }}
                                    <div class="modal-header">
                                        <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-suitcase"></i>&nbsp;Form Verifikasi Data Rubrik SKP</p>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div>
                                                <input type="hidden" name="id" id="">
                                                <div class="form-group col-md-12">
                                                    <label>Nilai SKP : <a style="color:red">*harap masukan angka, gunakan titik (.) sebagai pengganti koma</a></label>
                                                    <input type="text" pattern="[0-9]+([,\.][0-9]+)?" name="nilai_skp" class="form-control" placeholder=" masukan nilai skp">
                                                    <div>
                                                        @if ($errors->has('nilai_skp'))
                                                            <small class="form-text text-danger">{{ $errors->first('nilai_skp') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>FIle SKP : <a style="color:red">*file pdf</a></label>
                                                    <input type="file" name="file_skp" class="form-control">
                                                    <div>
                                                        @if ($errors->has('file_skp'))
                                                            <small class="form-text text-danger">{{ $errors->first('file_skp') }}</small>
                                                        @endif
                                                    </div>
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

        function verifikasi(id){
            $('#modalverifikasi').modal('show');
            $('#id_verifikasi').val(id);
        }

        $(document).ready(function(){
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                localStorage.setItem('activeTab', $(e.target).attr('href'));
            });
            var activeTab = localStorage.getItem('activeTab');
            if(activeTab){
                $('#myTab a[href="' + activeTab + '"]').tab('show');
            }
        });

        function

        @if (count($errors)>0)
            $("#modalubah").modal({"backdrop": "static"});
        @endif
    </script>
@endpush
