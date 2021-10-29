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
                            @elseif ($message   = Session::get('error'))
                            <div class="alert alert-danger alert-block" >
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong><i class="fa fa-info-circle"></i>&nbsp;Gagal: </strong> {{ $message }}
                            </div>
                        @else
                            @if (count($periodes)>0)
                                <div class="alert alert-success alert-block" id="keterangan-berhasil">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Berikut adalah data periode remunerasi, silahkan tambahkan dan aktifkan jika memasuki periode remunerasi yang baru !!
                                </div>
                                @else
                                <div class="alert alert-danger alert-block" id="keterangan-gagal">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Tidak ada periode aktif, silahkan tambahkan dan aktifkan jika memasuki periode remunerasi yang baru !!
                                </div>
                                
                            @endif
                    @endif
                    

                    <div class="alert alert-danger alert-block" style="display:none;" id="gagal">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <i class="fa fa-success-circle"></i><strong>Gagal :</strong> Status administrator gagal diubah !!
                    </div>
                </div>
                <div class="col-md-12">
                    <a onclick="tambahPeriode()" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-user-plus"></i>&nbsp; Tambah Periode</a>
                </div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="text-align:center">No</th>
                                <th style="text-align:center">Nama Periode</th>
                                <th style="text-align:center">Tanggal Awal</th>
                                <th style="text-align:center">Tanggal Akhir</th>
                                <th style="text-align:center">Jumlah Bulan</th>
                                <th style="text-align:center">Status Periode</th>
                                <th style="text-align:center">Ubah Status</th>
                                <th style="text-align:center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($periodes as $periode)
                                <tr>
                                    <td style="text-align:center;"> {{ $no++ }} </td>
                                    <td style="text-align:center;"> {{ $periode->nm_periode }} </td>
                                    <td style="text-align:center;"> {{ $periode->tanggal_awal }} </td>
                                    <td style="text-align:center;"> {{ $periode->tanggal_akhir }} </td>
                                    <td style="text-align:center;"> {{ $periode->jumlah_bulan }} Bulan </td>
                                    <td style="text-align:center;">
                                        @if ($periode->status == "aktif")
                                            <span class="badge badge-success"><i class="fa fa-check-circle"></i>&nbsp; Aktif</span>
                                            @else
                                            <span class="badge badge-danger"><i class="fa fa-minus-circle"></i>&nbsp; Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        @if ($periode->status == "1")
                                            <a onclick="nonAktifkanStatus( {{ $periode->id }} )" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-thumbs-down"></i></a>
                                            @else
                                            <a onclick="aktifkanStatus( {{ $periode->id }} )" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-thumbs-up"></i></a>
                                        @endif
                                    </td>
                                    <td style="text-align:center;">
                                        <a onclick="hapusPeriode( {{ $periode->id }} )" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Modal Hapus-->
                <div class="modal fade" id="modalhapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action=" {{ route('kepegawaian.periode.delete') }} " method="POST">
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
            <!-- Modal Tambah -->
            <div class="modal fade" id="modaltambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action=" {{ route('kepegawaian.periode.add') }} " method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="modal-header">
                            <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-clock-o"></i>&nbsp;Form Tambah Data Periode</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="id" id="id_ubah">
                                    <div class="form-group">
                                        <label for="">Nama Periode : <a style="color:red">*contoh: periode januari - maret 2019</a></label>
                                        <input type="text" name="nm_periode" value="{{ old('nm_periode') }}" class="form-control @error('nm_periode') is-invalid @enderror" placeholder="nama periode">
                                        <div>
                                            @if ($errors->has('nm_periode'))
                                                <small class="form-text text-danger">{{ $errors->first('nm_periode') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tanggal Awal :</label>
                                        <input type="date" name="tanggal_awal" value="{{ old('tanggal_awal') }}" class="form-control @error('tanggal_awal') is-invalid @enderror" placeholder="tanggal awal ">
                                        <div>
                                            @if ($errors->has('tanggal_awal'))
                                                <small class="form-text text-danger">{{ $errors->first('tanggal_awal') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tanggal Akhir :</label>
                                        <input type="date" name="tanggal_akhir" value="{{ old('tanggal_akhir') }}" class="form-control @error('tanggal_akhir') is-invalid @enderror" placeholder="tanggal akhir ">
                                        <div>
                                            @if ($errors->has('tanggal_akhir'))
                                                <small class="form-text text-danger">{{ $errors->first('tanggal_akhir') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Jumlah Bulan :</label>
                                        <input type="text" name="jumlah_bulan" value="{{ old('jumlah_bulan') }}" class="form-control @error('jumlah_bulan') is-invalid @enderror" placeholder="jumlah bulan ">
                                        <div>
                                            @if ($errors->has('jumlah_bulan'))
                                                <small class="form-text text-danger">{{ $errors->first('jumlah_bulan') }}</small>
                                            @endif
                                        </div>
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

        function tambahPeriode(){
            $('#modaltambah').modal('show');
        }

        function aktifkanStatus(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            url = "{{ url('kepegawaian/periode/aktifkan_status').'/' }}"+id;
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
            url = "{{ url('kepegawaian/periode/non_aktifkan_status').'/' }}"+id;
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

        function hapusPeriode(id){
            $('#modalhapus').modal('show');
            $('#id_hapus').val(id);
        }

        @if (count($errors) > 0)
            $("#modaltambah").modal({"backdrop": "static"});
        @endif
    </script>
@endpush
