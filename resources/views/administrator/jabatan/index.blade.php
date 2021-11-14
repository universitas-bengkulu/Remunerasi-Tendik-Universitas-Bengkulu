
@extends('layouts.layout')
@section('title', 'Dashboard')
@section('login_as', 'Administrator')
@section('user-login')
    {{ Auth::user()->nm_user }}
@endsection
@section('user-login2')
    {{ Auth::user()->nm_user }}
@endsection
@section('sidebar-menu')
    @include('administrator/sidebar')
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
            <i class="fa fa-tasks"></i>&nbsp; jabatan 
        </header>
        
        <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
           
            <div class="col-md-12">
                <a onclick="tambahjabatan()" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-user-plus"></i>&nbsp; Tambah jabatan</a>
            </div>
           <div class="row">
               <div class="col-md-12 table-responsive">
                   <table class="table table-hover table-bordered" id="table">
                       <thead>
                           <tr>
                               <th style="text-align:center">No</th>
                               <th style="text-align:center">Nama jabatan</th>
                               <th style="text-align:center">remunerasi</th>
                              
                               <th style="text-align:center" colspan="2">aksi</th>
                           </tr>
                       </thead>
                       <tbody>
                           @php
                               $no=1;
                           @endphp
                           @foreach ($jabatans as $jabatan)
                               <tr>
                                   <td>{{ $no++ }}</td>
                                   <td>{{ $jabatan->nm_jabatan }}</td>
                                   <td style="text-align:center" >Rp. {{ $jabatan->remunerasi }}</td>
                                   
                                   <td style="text-align:center;">
                                    <a href="{{ route('administrator.jabatan.update',[$jabatan->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                   
                                </td>
                                <td style="text-align:center;">
                                    <a onclick="hapusjabatan( {{ $jabatan->id }} )" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-trash"></i></a>
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
                    <form action=" {{ route('administrator.jabatan.delete') }} " method="POST">
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
                <form action=" {{ route('administrator.jabatan.add') }} " method="POST">
                    {{ csrf_field() }} {{ method_field('POST') }}
                    <div class="modal-header">
                        <p style="font-size:15px; font-weight:bold;" class="modal-title"><i class="fa fa-clock-o"></i>&nbsp;Form Tambah Data jabatan</p>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" id="id_ubah">
                                <div class="form-group">
                                    <label for="" >Nama jabatan  <a style="color:red"></a></label>
                                    <input type="text" name="nm_jabatan" value="{{ old('nm_jabatan') }}" class="form-control @error('nm_jabatan') is-invalid @enderror" placeholder="nama jabatan">
                                    <div>
                                        @if ($errors->has('nm_jabatan'))
                                            <small class="form-text text-danger">{{ $errors->first('nm_jabatan') }}</small>
                                        @endif
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="" >Remunerasi <a style="color:red"></a></label>
                                    <input type="number" name="remunerasi" value="{{ old('remunerasi') }}" class="form-control @error('remunerasi') is-invalid @enderror" placeholder="remunerasi">
                                    <div>
                                        @if ($errors->has('remunerasi'))
                                            <small class="form-text text-danger">{{ $errors->first('remunerasi') }}</small>
                                        @endif
                                    </div>

                                </div>
                               
                                
                            {{-- <div class="row">
                                <div class="col-md-12">
                        <label>tingkatan</label>
                        <select name="tingkatan" id="" class="form-control @error('tingkatan') is-invalid @enderror">
                            <option disabled selected>-- pilih tingkatan --</option>
                            <option value="universitas">Universitas</option>
                            <option value="lembaga">Lembaga</option>
                            <option value="fakultas">Fakultas</option>

                        </select>
                        @error('tingkatan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div> --}}
                             
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

    function tambahjabatan(){
        $('#modaltambah').modal('show');
    }

    // function aktifkanStatus(id){
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     url = "{{ url('administrator/jabatan/aktifkan_status').'/' }}"+id;
    //     $.ajax({
    //         url : url,
    //         type : 'PATCH',
    //         success : function($data){
    //             $('#berhasil').show(100);
    //             location.reload();
    //         },
    //         error:function(){
    //             $('#gagal').show(100);
    //         }
    //     });
    //     return false;
    // }

    // function nonAktifkanStatus(id){
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     url = "{{ url('administrator/jabatan/non_aktifkan_status').'/' }}"+id;
    //     $.ajax({
    //         url : url,
    //         type : 'PATCH',
    //         success : function($data){
    //             $('#berhasil').show(100);
    //             location.reload();
    //         },
    //         error:function(){
    //             $('#gagal').show(100);
    //         }
    //     });
    //     return false;
    // }

    function hapusjabatan(id){
        $('#modalhapus').modal('show');
        $('#id_hapus').val(id);
    }

    @if (count($errors) > 0)
        $("#modaltambah").modal({"backdrop": "static"});
    @endif
</script>
@endpush