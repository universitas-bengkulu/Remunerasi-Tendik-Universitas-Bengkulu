@extends('layouts.layout')
@section('title', 'Detail Isian Rubrik')
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
            <i class="fa fa-tasks"></i>&nbsp;Manajemen Data Remunerasi Insentif Universitas Bengkulu
        </header>
        <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
            <form action="{{ route('operator.detail_isian.store',[$rubrik_id,$isian_id]) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('POST')
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-primary alert-block">
                            <i class="fa fa-info-circle"></i>&nbsp; Silahkan tambahkan detail isian rubrik baru jika diperlukan.
                        </div>
                    </div>
                    <input type="hidden" value="" id="nm_tendik" name="nm_tendik">
                    <input type="hidden" name="isian_id" value="{{ $isian_id }}">
                    <input type="hidden" name="rubrik_id" value="{{ $rubrik_id }}">
                    <div class="col-md-6">
                       <div class="form-group">
                            <label>Tenaga Kependidikan (Tendik)</label>
                            <select name="tendik" class="form-control @error('tendik') is-invalid @enderror">
                                <option value="">-- Pilih Tendik --</option>
                                @foreach ($tendiks as $tendik)
                                        <option value="{{ $tendik->id }}">{{ $tendik->nm_lengkap }} - ({{ $tendik->nm_jabatan }})</option>
                                @endforeach
                            </select>
                            @error('tendik')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                       </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label>Rate Remun <a style="color: red">(Rp)</a></label>
                            <input type="text" name="rate_remun" id="rate_remun" oninput="this.value = this.value.replace(/[^0-9]/g, '');" aria-describedby="basic-addon1" class="form-control @error('rate_remun') is-invalid @enderror">
                            @error('rate_remun')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" cols="30" rows="3"></textarea>
                        @error('keterangan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-12 text-center mt-3">
                       <a href="{{ route('operator.dataremun',[$rubrik_id]) }}" class="btn btn-danger btn-sm"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                        <button type="reset" name="reset" class="btn btn-warning btn-sm ulangi"><i class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                        <button type="submit" name="submit" class="btn btn-primary btn-sm edit"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                    </div>
                </div>
            </form>
        
            <hr>
           <div class="row">
               <div class="col-md-8">
                   <table class="table table-hover table-bordered" id="table">
                       <thead>
                           <tr>
                               <th class="text-center" width="4%">No</th>
                               <th class="text-center">NIP</th>
                               <th class="text-center">Nama</th>
                               <th class="text-center">Rate Remun</th>
                               <th class="text-center">Keterangan</th>
                                <th class="text-center">Aksi</th>
                           </tr>
                       </thead>
                       <tbody>
                           @php
                               $no=1;
                           @endphp
                           @foreach ($detail as $detail)
                                <tr>
                                    <td >{{ $no++."." }}</td>
                                    <td>{{ $detail->nip }}</td>
                                    <td>{{ $detail->nm_tendik }}</td>
                                    {{-- <td>{{ $dosen->dsnNip }}</td>
                                    <td>{{ $dosen->dsnNama }}</td> --}}
                                    <td>Rp {{ number_format($detail->rate_remun,0,',','.') }}</td>
                                    <td>{!! $detail->keterangan !!}</td>
                                        <td class="text-center">
                                            <form action="{{ route('operator.detail_isian.destroy',[$rubrik_id,$isian_id]) }}" id="hapus_form" method="POST">
                                                @csrf @method('DELETE')
                                                <input type="hidden" name="detail_id" value="{{ $detail->detail_isian_id }}">
                                                <button type="submit" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
               <div class="col-md-4">
                   <table class="table table-hover table-bordered" id="rubrik">
                       <thead>
                           <tr>
                               <th class="text-center">Nama Kolom Rubrik</th>
                               <th class="text-center">Isi Kolom Rubrik</th>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach ($isian as $key => $data)
                                <tr>
                                    @if ($data && str_contains($key,'isian'))
                                        @php
                                            $str = preg_replace('/[^0-9.]+/', '', $key);
                                        @endphp
                                        <th class="text-center">{{ $rubriks['nama_kolom_'.$str]}}</th>
                                        <td class="text-center">{{ $data }}</td>
                                    @endif
                                </tr>
                            @endforeach
                       </tbody>
                   </table>
               </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Detail Rubrik</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('operator.detail_isian.update ',$isian_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id_detail" id="id_detail">
                        <div class="col-md-6">
                            <label>NIP</label>
                            <input type="text" name="nip" id="nip_edit" class="form-control @error('nip') is-invalid @enderror" disabled>
                            @error('nip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label>Nama</label>
                            <input type="text" name="nama" id="nama_edit" class="form-control @error('nama') is-invalid @enderror" disabled>
                            @error('nama')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mt-2">
                            <label>Rate Remun</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                                </div>
                                <input type="text" name="rate_remun" id="rate_remun_edit" oninput="this.value = this.value.replace(/[^0-9]/g, '');" aria-describedby="basic-addon1" class="form-control @error('rate_remun') is-invalid @enderror">
                                @error('rate_remun')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan_edit" ></textarea>
                            @error('keterangan')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">batalkan</button>
                          <button type="submit" class="btn btn-warning">Ubah Data</button>
                        </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            //data table
            $('#detail_rubrik').addClass('current-page');
            var table=$("table[id^='table']").DataTable({
                responsive : true,
                "ordering": true,
            });
            $('#table tbody').on( 'click', 'tr', function () {
                var data= table.row( this ).data();
                console.log(data);
                $("#nip_edit").val(data[1]).change();
                $("#nama_edit").val(data[2]).change();
                data[3]=data[3].replace(/\./gi,'');
                data[3]=data[3].replace(/Rp /gi,'');
                $('#rate_remun_edit').val(data[3]);
                data[4]=data[4].replace('<br>','');
                $('#keterangan_edit').html(data[4]);
            } );
            $('.edit_btn').click(function (e) {
                e.preventDefault();
                var id_detail=$(this).data('id');
                $('#id_detail').val(id_detail);
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#fakultas').change(function (e) {
                let kodefak=$(this).val();
                var op=" ";
                $('#prodi').find('option').not(':first').remove();
                $('#dosen').find('option').not(':first').remove();
                $.ajax({
                    type: "POST",
                    url: "{{ route('operator.detail_isian.prodi') }}",
                    data: {'kodeFak':kodefak,'_token':$('meta[name="csrf-token"]').attr('content')},
                    success: function (response) {
                        $.each(response, function(index, value) {
                                console.log(value);
                            $.each(value,function(index2, value2){
                                op+='<option value="'+value2['prodiKode']+'">'+value2['prodiNamaResmi']+'</option>';
                            })
                        })
                        $('#prodi').append(op);
                    },
                    error :function(err){
                        console.error(err);
                    }
                });
                e.preventDefault();
            });
            $('#prodi').change(function (e) {
                let kodeprodi=$(this).val();
                var op=" ";
                $('#dosen').find('option').not(':first').remove();
                $.ajax({
                    type: "POST",
                    url: "{{ route('operator.detail_isian.dosen') }}",
                    data: {'kodeprodi':kodeprodi,'_token':$('meta[name="csrf-token"]').attr('content')},
                    success: function (response) {
                        $.each(response, function(index, value) {
                            $.each(value,function(index2, value2){
                                $.each(value2['dosen'],function(index3,value3){
                                    if(value3['pegawai']['pegIsAktif']==1){
                                        $('#nm_tendik_add').val(value3['pegawai']['pegNama']);
                                        op+='<option value="'+value3['pegawai']['pegNip']+'">'+value3['pegawai']['pegNama']+'</option>';
                                    }
                                })
                            })
                        })
                        $('#dosen').append(op);
                    },
                    error :function(err){
                        console.error(err);
                    }
                });
                e.preventDefault();
            });
            $('#dosen').change(function(){
                var nama=$( "#dosen option:selected" ).text();
                $('#nm_tendik').val(nama);
            });

            $('#prodi').change(function(){
                var nama=$( "#prodi option:selected" ).text();
                $('#nama_prodi').val(nama);
            });
        } );

    </script>

@endpush
