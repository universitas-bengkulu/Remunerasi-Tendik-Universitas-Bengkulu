@extends('layouts.layout')
@section('title', 'Manajemen Jabatan')
@section('login_as', 'Tendik')
@section('user-login')
    @if (Auth::guard('tendik')->check())
    {{ Auth::guard('tendik')->user()->nm_lengkap }}
    @endif
@endsection
@section('user-login2')
    @if (Auth::guard('tendik')->check())
    {{ Auth::guard('tendik')->user()->nm_lengkap }}
    @endif
@endsection
@section('sidebar-menu')
    @include('tendik/sidebar')
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
                    @endif
                    @if (count($skps)<1)
                        <div class="alert alert-danger alert-block" id="keterangan">
                            <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> File SKP Periode saat ini belum ditambahkan !! <br>
                            @if (is_null($status))
                                Anda belum dapat menambahkan file skp, silahkan hubungi operator kepegawaian
                            @endif
                        </div>
                        @else
                        <div class="alert alert-success alert-block" id="keterangan">
                            <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> File SKP Periode saat ini sudah ditambahkan, jika file ditolak, silahkan upload ulang file anda !!
                        </div>
                    @endif
                </div>
                {{-- <div class="col-md-12">
                    @if (count($sudah)  <1)
                        <a onclick="tambahSkp()" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-file-pdf-o"></i>&nbsp; Tambah File SKP</a>
                        @else
                        <button class="btn btn-primary btn-sm disabled" style="color:white; cursor:pointer;"><i class="fa fa-file-pdf-o"></i>&nbsp; Tambah File SKP</button>
                    @endif
                </div> --}}
                @if (!is_null($status))
                    @if (!is_null($sekarang))
                        <div class="col-md-12">
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>Perhatian :</strong> Anda Hanya Boleh Memasukan Satu File Per Periode
                            </div>
                        </div>
                    @else
                    <div class="col-md-12" id="form-skp">
                        <p style="text-align:center;">Silahkan tambahkan file skp anda pada form dibawah ini !</p>
                        <hr style="width:50%;">
                        <form action="{{ route('tendik.r_skp.post',[Auth::guard('tendik')->user()->id]) }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }} {{ method_field('PATCH') }}
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Nilai SKP : <a style="color:red">*harap masukan angka, gunakan titik (.) sebagai pengganti koma</a></label>
                                    <input type="text" pattern="[0-9]+([,\.][0-9]+)?" name="nilai_skp" class="form-control @error('nilai_skp') is-invalid @enderror" placeholder=" masukan nilai skp">
                                    <div>
                                        @if ($errors->has('nilai_skp'))
                                            <small class="form-text text-danger">{{ $errors->first('nilai_skp') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>FIle SKP : </label>
                                    <input type="file" name="path" class="form-control @error('path') is-invalid @enderror">
                                    <div>
                                        @if ($errors->has('path'))
                                            <small class="form-text text-danger">{{ $errors->first('path') }}</small>
                                        @endif
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-12" style="text-align:center;">
                                {{-- <a onclick="batalkan()" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-close"></i>&nbsp; Batalkan</a> --}}
                                <button type="reset" class="btn btn-warning btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Simpan Data</button>
                            </div>
                        </form>
                        <hr style="width:50%;">
                        @foreach ($skps as $skp)
                            @if ($skp->status == "3")
                                <p style="text-transform: uppercase; color:red; text-align:center;">Skp {{ $skp->nm_periode }} ditolak, silahkan upload file skp yang baru</p>
                            @endif
                        @endforeach
                    </div>
                    @endif
                @endif
                <div class="col-md-12">
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
                                <th>Kirimkan</th>
                                <th>Aksi</th>
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
                                        <a class="btn btn-primary btn-sm" href="{{ asset('upload/file_skp/'.$periode->slug.'/'.$skp->path) }}" download="{{ $skp->path }}"><i class="fa fa-download"></i>&nbsp; Download</a>

                                    </td>
                                    <td>
                                        @if ($skp->status == "menunggu")
                                            <label class="badge badge-warning" style="color:white;"><i class="fa fa-clock-o"></i>&nbsp; Belum Dikirimkan</label>
                                            @elseif($skp->status == "terkirim")
                                            <label class="badge badge-info" style="color:white;"><i class="fa fa-clock-o"></i>&nbsp; Sudah Dikirimkan</label>
                                            @elseif($skp->status == "berhasil")
                                            <label class="badge badge-success" style="color:white;"><i class="fa fa-clock-o"></i>&nbsp; SKP disetujui</label>
                                            @else
                                            <label class="badge badge-danger" style="color:white;"><i class="fa fa-clock-o"></i>&nbsp; SKP ditolak</label>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($skp->status == "menunggu")
                                            <a href="{{ route('tendik.r_skp.kirimkan',[$skp->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-right"></i></a>
                                            @else
                                            <button  class="btn btn-primary btn-sm disabled"><i class="fa fa-arrow-right"></i></button>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($skp->status != "menunggu")
                                            <button class="btn btn-primary btn-sm disabled" style="color:white;cursor:pointer;"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-danger btn-sm disabled" style="color:white;cursor:pointer;"><i class="fa fa-trash"></i></button>
                                            @else
                                            <a onclick="hapusSkp({{ $skp->id }})" class="btn btn-danger btn-sm" style="color:white;cursor:pointer;"><i class="fa fa-trash"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Modal Ubah -->
                    <div class="modal fade" id="modalubah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md" role="document">
                            <div class="modal-content">
                                <form action=" {{ route('tendik.r_skp.update') }} " method="POST" enctype="multipart/form-data">
                                    {{ csrf_field() }} {{ method_field('PATCH') }}
                                    <div class="modal-header">
                                        <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-suitcase"></i>&nbsp;Form Ubah Data Rubrik SKP</p>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="hidden" name="id" id="id_ubah">
                                                <div class="form-group col-md-12">
                                                    <label>Nilai SKP : <a style="color:red">*harap masukan angka, gunakan titik (.) sebagai pengganti koma</a></label>
                                                    <input type="text" id="nilai_skp" name="nilai_skp" class="form-control" placeholder=" masukan nilai skp">
                                                    <div>
                                                        @if ($errors->has('nilai_skp'))
                                                            <small class="form-text text-danger">{{ $errors->first('nilai_skp') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>FIle SKP : <a style="color:red">*file pdf</a></label>
                                                    <input type="file" name="path_edit" style="padding-bottom:20px;" class="form-control">
                                                    <div>
                                                        @if ($errors->has('path_edit'))
                                                            <small class="form-text text-danger">{{ $errors->first('path_edit') }}</small>
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
                <!-- Modal Hapus-->
                <div class="modal fade modal-danger" id="modalhapus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action=" {{ route('tendik.r_skp.delete') }} " method="POST">
                                {{ csrf_field() }} {{ method_field('DELETE') }}
                                <div class="modal-header">
                                    <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-trash"></i>&nbsp;Form Konfirmasi Hapus Data</p>
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
                                    <button type="button" style="border: 1px solid #fff;background: transparent;color: #fff;" class="btn btn-sm btn-outline pull-left" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp; Batalkan</button>
                                    <button type="submit" style="border: 1px solid #fff;background: transparent;color: #fff;" class="btn btn-sm btn-outline"><i class="fa fa-check-circle"></i>&nbsp; Ya, Hapus</button>
                                </div>
                            </form>
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
            $('#table').DataTable({
                responsive : true,
            });
        } );

        function tambahSkp(){
            $('#form-skp').show(300);
        }

        function batalkan(){
            $('#form-skp').show(300);
        }
        
        function ubahSkp(id){
            $.ajax({
                url: "{{ url('tendik/manajemen_rubrik_capaian_skp') }}"+'/'+ id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    $('#modalubah').modal('show');
                    $('#id_ubah').val(id);
                    $('#nilai_skp').val(data.nilai_skp);
                },
                error:function(){
                    alert("Nothing Data");
                }
            });
        }

        function hapusSkp(id){
            $('#modalhapus').modal('show');
            $('#id_hapus').val(id);
        }

        @if ($errors->has('path_edit') > 0)
            $("#modalubah").modal({"backdrop": "static"});
        @endif
    </script>
@endpush
