@extends('layouts.layout')
@section('title', 'Manajemen Jabatan')
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
            <i class="fa fa-home"></i>&nbsp;Remunerasi Tenaga Kependidikan Universitas Bengkulu
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
                            <div class="alert alert-success alert-block" id="keterangan">
                                <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Berikut semua Jabatan yang tersedia, data berikut didapatkan dari Sistem Informasi Kepegawaian (SIMPEG), silahkan tambahkan manual jika diperlukan !!
                            </div>
                    @endif
                </div>
                <div class="col-md-12" id="form-jabatan">
                    <hr style="width:50%;">
                    <form action="{{ route('kepegawaian.jabatan.post') }}" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Kelas Jabatan :</label>
                                <input type="text" name="kelas_jabatan" value="{{ old('kelas_jabatan') }}" class="form-control @error('kelas_jabatan') is-invalid @enderror" placeholder=" masukan kelas jabatan">
                                <div>
                                    @if ($errors->has('kelas_jabatan'))
                                        <small class="form-text text-danger">{{ $errors->first('kelas_jabatan') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Nama Jabatan :</label>
                                <input type="text" name="nm_jabatan" value="{{ old('nm_jabatan') }}" class="form-control @error('nm_jabatan') is-invalid @enderror" placeholder=" masukan nama jabatan">
                                <div>
                                    @if ($errors->has('nm_jabatan'))
                                        <small class="form-text text-danger">{{ $errors->first('nm_jabatan') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Nilai Remunerasi : <a style="color:red">*dalam rupiah</a></label>
                                <input type="text" name="remunerasi" value="{{ old('remunerasi') }}" class="form-control @error('remunerasi') is-invalid @enderror" placeholder="masukan nilai remunerasi">
                                <div>
                                    @if ($errors->has('remunerasi'))
                                        <small class="form-text text-danger">{{ $errors->first('remunerasi') }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="text-align:center;">
                            <a onclick="batalkan()" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-close"></i>&nbsp; Batalkan</a>
                            <button type="reset" class="btn btn-warning btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Simpan Jabatan</button>
                        </div>
                    </form>
                    <hr style="width:50%;">
                </div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kelas Jabatan</th>
                                <th>Nama Jabatan</th>
                                <th>Remunerasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($jabatans as $jabatan)
                                <tr>
                                    <td> {{ $no++ }} </td>
                                    <td> {{ $jabatan->kelas_jabatan }} </td>
                                    <td> {{ $jabatan->nm_jabatan }} </td>
                                    <td> Rp.{{ number_format($jabatan->remunerasi,2) }} </td>
                                    <td>
                                        <a onclick="editJabatan({{ $jabatan->id }})" class="btn btn-primary btn-sm" style="color:white;cursor:pointer;"><i class="fa fa-edit"></i></a>
                                        <a onclick="hapusJabatan({{ $jabatan->id }})" class="btn btn-danger btn-sm" style="color:white;cursor:pointer;"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Modal Ubah -->
                    <div class="modal fade" id="modalubah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action=" {{ route('kepegawaian.jabatan.update') }} " method="POST">
                                    {{ csrf_field() }} {{ method_field('PATCH') }}
                                    <div class="modal-header">
                                        <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-suitcase"></i>&nbsp;Form Ubah Data Jabatan</p>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="hidden" name="id" id="id_ubah">
                                                <div class="form-group">
                                                    <label for="">Kelas Jabatan :</label>
                                                    <input type="text" name="kelas_jabatan_edit" id="kelas_jabatan" class="form-control @error('kelas_jabatan') is-invalid @enderror" required placeholder="masukan kelas jabatan">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Nama Jabatan :</label>
                                                    <input type="text" name="nm_jabatan_edit" id="nm_jabatan" class="form-control @error('nm_jabatan') is-invalid @enderror" required placeholder="masukan nama jabatan">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Nominal Remunerasi :</label>
                                                    <input type="text" name="remunerasi_edit" id="remunerasi" class="form-control @error('remunerasi') is-invalid @enderror" required placeholder="masukan nominal remunerasi">
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
                            <form action=" {{ route('kepegawaian.jabatan.delete') }} " method="POST">
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
        
        function editJabatan(id){
            $.ajax({
                url: "{{ url('kepegawaian/manajemen_jabatan') }}"+'/'+ id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    $('#modalubah').modal('show');
                    $('#id_ubah').val(id);
                    $('#kelas_jabatan').val(data.kelas_jabatan);
                    $('#nm_jabatan').val(data.nm_jabatan);
                    $('#remunerasi').val(data.remunerasi);
                },
                error:function(){
                    alert("Nothing Data");
                }
            });
        }

        function hapusJabatan(id){
            $('#modalhapus').modal('show');
            $('#id_hapus').val(id);
        }

    </script>
@endpush
