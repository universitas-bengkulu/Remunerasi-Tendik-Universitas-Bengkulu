@extends('layouts.layout')
@section('title', 'Manajemen rubrik')
@section('login_as', 'administrator')
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
    @include('administrator/sidebar')
@endsection
@section('content')
    <section class="panel" style="margin-bottom:20px;">
        <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
            <i class="fa fa-home"></i>&nbsp; Remunerasi Tenaga Kependidikan Universitas Bengkulu
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
                                <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Berikut semua rubrik yang tersedia, data berikut didapatkan dari Sistem Informasi administrator (SIMPEG), silahkan tambahkan manual jika diperlukan !!
                            </div>
                    @endif
                </div>
                <div class="col-md-12" id="form-rubrik">
                    <hr style="width:50%;">
                    <form action="{{ route('administrator.rubrik.post') }}" method="POST">
                        {{ csrf_field() }} {{ method_field('POST') }}
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label>Nama rubrik :</label>
                                <input type="text" name="nama_rubrik" value="{{ old('nama_rubrik') }}" class="form-control @error('nama_rubrik') is-invalid @enderror" placeholder=" masukan kelas rubrik">
                                <div>
                                    @if ($errors->has('nama_rubrik'))
                                        <small class="form-text text-danger">{{ $errors->first('nama_rubrik') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Nama Kolom 1 :</label>
                                <input type="text" name="nama_kolom_1" value="{{ old('nama_kolom_1') }}" class="form-control @error('nama_kolom_1') is-invalid @enderror" placeholder=" masukan nama kolom_">
                                <div>
                                    @if ($errors->has('nama_kolom_1'))
                                        <small class="form-text text-danger">{{ $errors->first('nama_kolom_1') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label> nama_kolom_2 : </label>
                                <input type="text" name="nama_kolom_2" value="{{ old('nama_kolom_2') }}" class="form-control @error('nama_kolom_2') is-invalid @enderror" placeholder="masukan  nama_kolom_2">
                                <div>
                                    @if ($errors->has('nama_kolom_2'))
                                        <small class="form-text text-danger">{{ $errors->first('nama_kolom_2') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Kelas kolom_3 :</label>
                                <input type="text" name="nama_kolom_3" value="{{ old('nama_kolom_3') }}" class="form-control @error('nama_kolom_3') is-invalid @enderror" placeholder=" masukan kelas kolom_">
                                <div>
                                    @if ($errors->has('nama_kolom_3'))
                                        <small class="form-text text-danger">{{ $errors->first('nama_kolom_3') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Nama kolom_4 :</label>
                                <input type="text" name="nama_kolom_4" value="{{ old('nama_kolom_4') }}" class="form-control @error('nama_kolom_4') is-invalid @enderror" placeholder=" masukan nama kolom_">
                                <div>
                                    @if ($errors->has('nama_kolom_4'))
                                        <small class="form-text text-danger">{{ $errors->first('nama_kolom_4') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label> nama_kolom_5 : </label>
                                <input type="text" name="nama_kolom_5" value="{{ old('nama_kolom_5') }}" class="form-control @error('nama_kolom_5') is-invalid @enderror" placeholder="masukan  nama_kolom_5">
                                <div>
                                    @if ($errors->has('nama_kolom_5'))
                                        <small class="form-text text-danger">{{ $errors->first('nama_kolom_5') }}</small>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group col-md-4">
                                <label>Nama kolom_6 :</label>
                                <input type="text" name="nama_kolom_6" value="{{ old('nama_kolom_6') }}" class="form-control @error('nama_kolom_6') is-invalid @enderror" placeholder=" masukan nama kolom_6">
                                <div>
                                    @if ($errors->has('nama_kolom_6'))
                                        <small class="form-text text-danger">{{ $errors->first('nama_kolom_6') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label> nama_kolom_7 : </label>
                                <input type="text" name="nama_kolom_7" value="{{ old('nama_kolom_7') }}" class="form-control @error('nama_kolom_7') is-invalid @enderror" placeholder="masukan  nama_kolom_7">
                                <div>
                                    @if ($errors->has('nama_kolom_7'))
                                        <small class="form-text text-danger">{{ $errors->first('nama_kolom_7') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Kelas kolom_8 :</label>
                                <input type="text" name="nama_kolom_8" value="{{ old('nama_kolom_8') }}" class="form-control @error('nama_kolom_8') is-invalid @enderror" placeholder=" masukan kelas kolom_8">
                                <div>
                                    @if ($errors->has('nama_kolom_8'))
                                        <small class="form-text text-danger">{{ $errors->first('nama_kolom_8') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>nama kolom 9 :</label>
                                <input type="text" name="nama_kolom_9" value="{{ old('nama_kolom_9') }}" class="form-control @error('nama_kolom_9') is-invalid @enderror" placeholder=" masukan nama 9">
                                <div>
                                    @if ($errors->has('nama_rubrik'))
                                        <small class="form-text text-danger">{{ $errors->first('nama_rubrik') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Kelas kolom_10 :</label>
                                <input type="text" name="nama_kolom_10" value="{{ old('nama_kolom_10') }}" class="form-control @error('nama_kolom_10') is-invalid @enderror" placeholder=" masukan kelas kolom_10">
                                <div>
                                    @if ($errors->has('nama_kolom_10'))
                                        <small class="form-text text-danger">{{ $errors->first('nama_kolom_10') }}</small>
                                    @endif
                                </div>
                            </div>
                         
                        
                        </div>
                        <div class="col-md-12" style="text-align:center;">
                            <a onclick="batalkan()" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-close"></i>&nbsp; Batalkan</a>
                            <button type="reset" class="btn btn-warning btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Simpan rubrik</button>
                        </div>
                    </form>
                    <hr style="width:50%;">
                </div>
                <div class="col-md-12">
                    <table class="table table-striped table-bordered" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kelas rubrik</th>
                                <th>Nama rubrik</th>
                                <th>nama_9</th>
                                <th>Kelas rubrik</th>
                                <th>Nama rubrik</th>
                                <th>nama_kolom_</th>
                                <th>Kelas rubrik</th>
                                <th>Nama rubrik</th>
                                <th>nama_kolom_</th>
                                <th>Kelas rubrik</th>
                                <th>Nama rubrik</th>
                              
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($rubriks as $rubrik)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $rubrik->nama_rubrik }}</td>
                                    <td>{{ $rubrik->nama_kolom_1 }}</td>
                                    <td>{{ $rubrik->nama_kolom_2 }}</td>
                                    <td>{{ $rubrik->nama_kolom_3 }}</td>
                                    <td>{{ $rubrik->nama_kolom_4 }}</td>
                                    <td>{{ $rubrik->nama_kolom_5 }}</td>
                                    <td>{{ $rubrik->nama_kolom_6 }}</td>
                                    <td>{{ $rubrik->nama_kolom_7 }}</td>
                                    <td>{{ $rubrik->nama_kolom_8 }}</td>
                                    <td>{{ $rubrik->nama_kolom_9 }}</td>
                                    <td>{{ $rubrik->nama_kolom_10 }}</td>
                                    <td>
                                        <a onclick="editrubrik({{ $rubrik->id }})" class="btn btn-primary btn-sm" style="color:white;cursor:pointer;"><i class="fa fa-edit"></i></a>
                                        <a onclick="hapusrubrik({{ $rubrik->id }})" class="btn btn-danger btn-sm" style="color:white;cursor:pointer;"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                     <!-- Modal Ubah -->
                     <div class="modal fade" id="modalubah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action=" {{ route('administrator.rubrik.update') }} " method="POST">
                                    {{ csrf_field() }} {{ method_field('PATCH') }}
                                    <div class="modal-header">
                                        <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-suitcase"></i>&nbsp;Form Ubah Data rubrik</p>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="hidden" name="id" id="id_ubah">
                                                <div class="form-group">
                                                    <label>Nama rubrik :</label>
                                                    <input type="text" name="nama_rubrik" value="{{ old('nama_rubrik') }}" class="form-control @error('nama_rubrik') is-invalid @enderror" placeholder=" masukan kelas rubrik">
                                                    <div>
                                                        @if ($errors->has('nama_rubrik'))
                                                            <small class="form-text text-danger">{{ $errors->first('nama_rubrik') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama Kolom 1 :</label>
                                                    <input type="text" name="nama_kolom_1" value="{{ old('nama_kolom_1') }}" class="form-control @error('nama_kolom_1') is-invalid @enderror" placeholder=" masukan nama kolom_">
                                                    <div>
                                                        @if ($errors->has('nama_kolom_1'))
                                                            <small class="form-text text-danger">{{ $errors->first('nama_kolom_1') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label> nama_kolom_2 : </label>
                                                    <input type="text" name="nama_kolom_2" value="{{ old('nama_kolom_2') }}" class="form-control @error('nama_kolom_2') is-invalid @enderror" placeholder="masukan  nama_kolom_2">
                                                    <div>
                                                        @if ($errors->has('nama_kolom_2'))
                                                            <small class="form-text text-danger">{{ $errors->first('nama_kolom_2') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kelas kolom_3 :</label>
                                                    <input type="text" name="nama_kolom_3" value="{{ old('nama_kolom_3') }}" class="form-control @error('nama_kolom_3') is-invalid @enderror" placeholder=" masukan kelas kolom_">
                                                    <div>
                                                        @if ($errors->has('nama_kolom_3'))
                                                            <small class="form-text text-danger">{{ $errors->first('nama_kolom_3') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama kolom_4 :</label>
                                                    <input type="text" name="nama_kolom_4" value="{{ old('nama_kolom_4') }}" class="form-control @error('nama_kolom_4') is-invalid @enderror" placeholder=" masukan nama kolom_">
                                                    <div>
                                                        @if ($errors->has('nama_kolom_4'))
                                                            <small class="form-text text-danger">{{ $errors->first('nama_kolom_4') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label> nama_kolom_5 : </label>
                                                    <input type="text" name="nama_kolom_5" value="{{ old('nama_kolom_5') }}" class="form-control @error('nama_kolom_5') is-invalid @enderror" placeholder="masukan  nama_kolom_5">
                                                    <div>
                                                        @if ($errors->has('nama_kolom_5'))
                                                            <small class="form-text text-danger">{{ $errors->first('nama_kolom_5') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label>Nama kolom_6 :</label>
                                                    <input type="text" name="nama_kolom_6" value="{{ old('nama_kolom_6') }}" class="form-control @error('nama_kolom_6') is-invalid @enderror" placeholder=" masukan nama kolom_6">
                                                    <div>
                                                        @if ($errors->has('nama_kolom_6'))
                                                            <small class="form-text text-danger">{{ $errors->first('nama_kolom_6') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label> nama_kolom_7 : </label>
                                                    <input type="text" name="nama_kolom_7" value="{{ old('nama_kolom_7') }}" class="form-control @error('nama_kolom_7') is-invalid @enderror" placeholder="masukan  nama_kolom_7">
                                                    <div>
                                                        @if ($errors->has('nama_kolom_7'))
                                                            <small class="form-text text-danger">{{ $errors->first('nama_kolom_7') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kelas kolom_8 :</label>
                                                    <input type="text" name="nama_kolom_8" value="{{ old('nama_kolom_8') }}" class="form-control @error('nama_kolom_8') is-invalid @enderror" placeholder=" masukan kelas kolom_8">
                                                    <div>
                                                        @if ($errors->has('nama_kolom_8'))
                                                            <small class="form-text text-danger">{{ $errors->first('nama_kolom_8') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Nama 9 :</label>
                                                    <input type="text" name="nama_kolom_9" value="{{ old('nama_kolom_9') }}" class="form-control @error('nama_kolom_9') is-invalid @enderror" placeholder=" masukan nama 9">
                                                    <div>
                                                        @if ($errors->has('nama_rubrik'))
                                                            <small class="form-text text-danger">{{ $errors->first('nama_rubrik') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kelas kolom_10 :</label>
                                                    <input type="text" name="nama_kolom_10" value="{{ old('nama_kolom_10') }}" class="form-control @error('nama_kolom_10') is-invalid @enderror" placeholder=" masukan kelas kolom_10">
                                                    <div>
                                                        @if ($errors->has('nama_kolom_10'))
                                                            <small class="form-text text-danger">{{ $errors->first('nama_kolom_10') }}</small>
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
                            <form action=" {{ route('administrator.rubrik.delete') }} " method="POST">
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
        
        function editrubrik(id){
            $.ajax({
                url: "{{ url('administrator/rubrik') }}"+'/'+ id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data){
                    $('#modalubah').modal('show');
                    $('#id_ubah').val(id);
           
                    $('#nama_rubrik').val(data.nama_rubrik);
                    $('#nama_kolom_1').val(data.nama_kolom_1);
                    $('#nama_kolom_2').val(data.nama_kolom_2);
                    $('#nama_kolom_3').val(data.nama_kolom_3);
                    $('#nama_kolom_4').val(data.nama_kolom_4);
                    $('#nama_kolom_5').val(data.nama_kolom_5);
                    $('#nama_kolom_6').val(data.nama_kolom_6);
                    $('#nama_kolom_7').val(data.nama_kolom_7);
                    $('#nama_kolom_8').val(data.nama_kolom_8);
                    $('#nama_kolom_9').val(data.nama_kolom_9);
                    $('#nama_kolom_10').val(data.nama_kolom_10);

                },
                error:function(){
                    alert("Nothing Data");
                }
            });
        }

        function hapusrubrik(id){
            $('#modalhapus').modal('show');
            $('#id_hapus').val(id);
        }

    </script>
@endpush
