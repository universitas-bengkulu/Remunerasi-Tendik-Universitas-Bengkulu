@extends('layouts.layout')
@section('title', 'Manajemen Rubrik SKP')
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
                            @if ($a == "sudah")
                                <div class="alert alert-success alert-block">
                                    <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Data Potongan Capaian SKP <b style="text-transform:uppercase">{{ $periode_aktif->nm_periode }}</b> sudah digenerate, silahkan lanjutkan dengan klik tombol next hingga selesai !!
                                </div>
                                @else
                                <div class="alert alert-danger alert-block" id="alert-generate">
                                    <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Silahkan Generate Potongan Capaian SKP Terlebih Dahulu. Jika ada Sanksi Disiplin yang tidak sesuai silahkan diupdate terlebih dahulu sebelum di generate !!
                                </div>
                            @endif
                    @endif
                </div>
                <div class="col-md-12">
                    <nav aria-label="...">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="{{ route('kepegawaian.r_skp',[$periode_id]) }}">Previous</a>
                            </li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_skp',[$periode_id]) }}">1</a></li>
                          <li class="page-item active">
                            <span class="page-link">
                                2
                                <span class="sr-only">(current)</span>
                              </span>
                          </li>
                          <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.r_skp.generate_nominal',[$periode_id]) }}">3</a></li>
                          <li class="page-item">
                            <a class="page-link" href="{{ route('kepegawaian.r_skp.generate_nominal',[$periode_id]) }}">Next</a>
                          </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-12">
                    @if ($a == "sudah")
                        <button class="btn btn-primary btn-sm disabled"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Potongan SKP</button>
                        @else
                        <a href="{{ route('kepegawaian.r_skp.generate_submit',[$periode_id]) }}" id="generate" onclick="generateTendik()" class="btn btn-primary btn-sm"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Potongan SKP</a>
                    @endif
                    <button class="btn btn-warning btn-sm disabled" id="proses-generate" style="display:none;color:white;cursor:pointer;"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Potongan SKP</button>
                </div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nip</th>
                                <th>Nama Lengkap</th>
                                <th>Nilai SKP</th>
                                <th>Potongan SKP (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($datas as $skp)
                                <tr>
                                    <td> {{ $no++ }} </td>
                                    <td> {{ $skp->nip }} </td>
                                    <td> {{ $skp->nm_lengkap }} </td>
                                    <td>
                                        @if (empty($skp->nilai_skp))
                                            <a style="color:red">belum mengupload nilai & file skp</a>
                                            @else
                                            {{ $skp->nilai_skp }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($skp->potongan_skp == null)
                                            <label class="badge badge-danger"><i class="fa fa-minus"></i></label>
                                            @else
                                            {{ $skp->potongan_skp }}%
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Modal Verifikasi -->
                    <div class="modal fade" id="modalverifikasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <div class="col-md-12">
                                                <input type="hidden" name="id" id="id_verifikasi">
                                                <div class="form-group col-md-12">
                                                    <label>Verifikasi Data Rubrik SKP :</label>
                                                    <select name="verifikasi" id="verifikasi" class="form-control">
                                                        <option value="" disabled selected>-- pilih opsi verifikasi --</option>
                                                        <option value="2">Setujui</option>
                                                        <option value="0">Tidak Setujui</option>
                                                    </select>
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
    </script>
@endpush
