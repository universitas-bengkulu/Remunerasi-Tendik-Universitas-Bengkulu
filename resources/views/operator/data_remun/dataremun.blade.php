@extends('layouts.layout')
@section('title', 'Manajemen Data Remunerasi')
@section('login_as', 'Operator')
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
    @include('operator/sidebar')
@endsection
@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        a.disabled {
            pointer-events: none;
            cursor: default;
        }
        .loader {
            border: 10px solid #dfe1e2; /* Light grey */
            border-top: 10px solid rgb(22, 22, 134);
            border-bottom: 10px solid rgb(22, 22, 134);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        td.details-control::before {
            content: "\f055 ";
            color: #007bff;
            padding-right: 5px;
            font-size: 1.3em;
            font-family: "FontAwesome";
            cursor: pointer;
        }
        tr.shown td.details-control::before {
            content: "\f056";
            color:red;
            padding-right: 5px;
            font-family: "FontAwesome";
        }
    </style>
@endpush
@section('content')
<section class="panel" style="margin-bottom:20px;">
    <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
        <i class="fa fa-tasks"></i>&nbsp;Manajemen Data Remunerasi Insentif Universitas Bengkulu
    </header>
    <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
        <form action="{{ route('operator.dataremun.store') }}" method="POST" id="test_form" enctype="multipart/form-data">
            @csrf @method('POST')
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-primary alert-block">
                        <i class="fa fa-info-circle"></i>&nbsp; Silahkan tambahkan isian rubrik baru jika diperlukan.
                    </div>
                </div>
                <input type="hidden" name="id_file" id="id_file" value="">
                <div class="col-md-6 form-group">
                    <label for="id_rubrik">Nama Rubrik</label>
                    <select name="id_rubrik" id="id_rubrik" class="form-control @error('id_rubrik') is-invalid @enderror">
                        <option value="0">-- Pilih nama rubrik --</option>
                        @foreach ($data_rubriks as $rubrik)
                            <option value="{{$rubrik->id}}" {{ $rubrik->id==old('id_rubrik')? 'selected':'' }} >{{ $rubrik->nama_rubrik }}</option>
                        @endforeach
                    </select>
                    @error('id_rubrik')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label for="no_sk">Nomor SK</label>
                    <input type="text" name="no_sk" id="no_sk"  class="form-control @error('no_sk') is-invalid @enderror" value="{{ old('no_sk') }}">
                    @error('no_sk')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 mt-2 form-group">
                    <label for="id_periode">Periode</label>
                    <select name="id_periode" id="id_periode" class="form-control @error('id_periode') is-invalid @enderror">
                        <option value="{{ $periode->id }}"></option>
                    </select>
                    @error('id_periode')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 mt-2 form-group">
                    <label for="file_isian">Upload file</label>
                    <input type="file" name="file_isian" id="file_isian" class="form-control @error('file_isian') is-invalid @enderror">
                    @error('file_isian')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="alert alert-dismissible mt-3 d-none col-12" id="alert_file" role="alert">
                    <span id="tampil_file"></span>
                    <button type="button" class="close" id="alert_hapusfile">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="progress_wrapper" class="col-md-12 d-none mt-2">
                    <div class="progress">
                        <div id="progress" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemax="100" aria-valuemin="0">0%</div>
                    </div>
                </div>
                <div id="alert_wrapper"></div>
                <div id="isian_kolom" class="form-row col-md-12">
                </div>
                <div class="loader d-none"></div>
                <div class="col-md-12 text-center mt-3">
                    <button type="reset" name="reset" id="ulangi" class="btn btn-warning btn-sm" style="color: white"><i class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                    <button type="submit" name="submit" id="simpan" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                </div>
            </div>
        </form>
       <div class="row">
           <div class="col-md-12">
               <table class="table table-hover table-bordered" id="table">
                   <thead>
                       <tr>
                           <th width="4%">no</th>
                           <th class="text-center">Nama Rubrik</th>
                           <th class="text-center">Nomor SK</th>
                           <th class="text-center">unit</th>
                           <th class="text-center">File</th>
                           <th class="text-center">Periode</th>
                           <th class="text-center">Status</th>
                           <th class="text-center">Ubah Status</th>
                           <th class="text-center">Aksi</th>
                       </tr>
                   </thead>
                   <tbody>
                       @php
                           $no=1;
                       @endphp
                       @foreach ($rubriks as $rubrik)
                            @foreach ($rubrik->isianrubrik as $isian_rubrik)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $isian_rubrik->rubrik->nama_rubrik }}</td>
                                        <td>{{ $isian_rubrik->nomor_sk }}</td>
                                        <td class="text-center">{{ $isian_rubrik->nm_unit }}</td>
                                        <td class="text-center"><a href="{{ route('operator.dataremun.download',$isian_rubrik->file_upload) }}"  class="btn btn-primary"><i class="fa fa-download"></i></a></td>
                                        <td>{{ $isian_rubrik->periode->masa_kinerja }}</td>
                                        <td class="text-center" width="10%">
                                            @if ($isian_rubrik->status_validasi=='nonaktif')
                                                <h6><span class="badge badge-warning"><i class="fa fa-exclamation-circle"></i> &nbsp; Belum dikirim</span></h6>
                                            @elseif ($isian_rubrik->status_validasi=='aktif')
                                                <h6><span class="badge badge-info"><i class="fa fa-clock-o"></i> &nbsp; Menunggu Verifikasi</span></h6>
                                            @elseif($isian_rubrik->status_validasi=="terverifikasi")
                                                <h6><span class="badge badge-success"><i class="fa fa-check"></i> &nbsp; Terverifikasi</span></h6>
                                            @else
                                                <h6><span class="badge badge-danger"><i class="fa fa-check"></i> &nbsp; Terverifikasi</span></h6>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($isian_rubrik->status_validasi=='nonaktif')
                                                <form action="{{ route('operator.dataremun.status',$isian_rubrik->id) }}" class="selesai_form" method="POST">
                                                    @csrf @method('PUT')
                                                    <button type="submit" class="btn btn-success btn-sm data_selesai" data-detail="{{ $isian_rubrik->detailisianrubrik->count() }}"><i class="fa fa-check"></i>&nbsp; Selesai</button>
                                                </form>
                                            @else
                                                <h6><span class="badge badge-success"><i class="fa fa-check-circle-o"></i></span></h6>
                                            @endif
                                        </td> 
                                        <td class="text-center">
                                            <form action="{{ route('operator.dataremun.destroy',$isian_rubrik->id) }}" class="hapus_form" method="POST">
                                                <a href="{{ route('operator.detailrubrik',$isian_rubrik->id) }}"  class="btn btn-primary btn-sm text-center"><i class="fa fa-info-circle"></i></a>
                                                <a href="{{ route('operator.dataremun.edit',$isian_rubrik->id) }}" class="btn btn-warning btn-sm @if ($isian_rubrik->status_validasi!='nonaktif') disabled @endif"><i class="fa fa-pencil-square-o"></i></a>
                                                @csrf @method('delete')
                                                <button type="submit" class="btn btn-danger btn-sm hapus_data"  @if ($isian_rubrik->status_validasi!='nonaktif') disabled @endif><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                            @endforeach
                       @endforeach
                   </tbody>
               </table>
           </div>
       </div>
    </div>
</section>
@endsection

@push('scripts')

    <script type="text/javascript">
        var table=$("table[id^='table']").DataTable({
            responsive : true,
            "ordering": true,
        });

        $('#id_rubrik').change(function () {
            let id=$(this).val();
            $('.loader').removeClass('d-none');
            $('.form_isian').remove();
            $.ajax({
                url: "{{ url('operator/detail_rubrik') }}"+'/'+ id + "/kolum_rubrik",
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    let no=1;
                    $.each(data, function(index, value) {
                        if(value){
                            if(index.includes("nama_kolom")){
                                let angka=parseInt(index.match(/\d/g).join(''));
                                let hidden=`<input type="hidden" name="isian_angka[]" value="isian_`+angka+`">`
                                let isian_kolom='';
                                if(angka>=1 && angka<=4){
                                    isian_kolom=`<div class="col-md-6 mt-2 form_isian">
                                        <label for="nama_kolom_`+angka+`">`+value+`</label>
                                        <input type="text" name="nama_kolom[`+angka+`]" id="nama_kolom_`+angka+`" required class="form-control @error('nama_kolom[`+angka+`]') is-invalid @enderror" value="{{ old('nama_kolom_`+angka+`') }}">
                                        @error('nama_kolom[`+angka+`]')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>`
                                }
                                else if(angka>=5 && angka<=8){
                                    isian_kolom=`<div class="col-md-6 mt-2 form_isian">
                                        <label for="nama_kolom_`+angka+`">`+value+`</label>
                                        <input type="number" name="nama_kolom[`+angka+`]" id="nama_kolom_`+angka+`" required class="form-control @error('nama_kolom[`+angka+`]') is-invalid @enderror" value="{{ old('nama_kolom_`+angka+`') }}">
                                        @error('nama_kolom[`+angka+`]')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>`
                                }
                                else if(angka>=9 && angka<=10){
                                    isian_kolom=`<div class="col-md-6 mt-2 form_isian">
                                        <label for="nama_kolom_`+angka+`">`+value+`</label>
                                        <input type="date" name="nama_kolom[`+angka+`]" id="nama_kolom_`+angka+`" required class="form-control @error('nama_kolom[`+angka+`]') is-invalid @enderror" value="{{ old('nama_kolom_`+angka+`') }}">
                                        @error('nama_kolom[`+angka+`]')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>`
                                }
                                $('#isian_kolom').append(hidden);
                                $('#isian_kolom').append(isian_kolom);
                            }
                        }
                    });
                    $('.loader').addClass('d-none');
                },
                error:function(){
                    $('.loader').addClass('d-none');
                }
            });
        });

        $(document).ready(function(){
            $("#test_form").validate({
                messages:{
                    id_rubrik:"Mohon pilih Rubrik",
                    no_sk :"Nomor SK tidak boleh Kosong",
                    id_periode:"Mohon pilih Periode",
                    "nama_kolom[]":"Tidak boleh Kosong",

                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>

@endpush
