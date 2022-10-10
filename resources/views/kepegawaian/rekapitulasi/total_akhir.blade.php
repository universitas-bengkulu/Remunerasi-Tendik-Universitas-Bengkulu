@extends('layouts.layout')
@section('title', 'Manajemen Rubrik Integritas')
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
        .tendik {
            color: #007bff !important;
            background: white;
        }

        .tendik:hover,
        .tendik:focus,
        .tendik:active {
            background-color: white !important;
            color: #007bff !important;
        }
    </style>
@endpush
@section('content')
    <section class="panel" style="margin-bottom:20px;">
        <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
            <i class="fa fa-home"></i>&nbsp;Generate Remunerasi Tenaga Kependidikan Universitas Bengkulu
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
                                        <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Data Tenaga Kependidikan <b style="text-transform:uppercase">{{ $periode_aktif->nm_periode }}</b> sudah digenerate, silahkan lanjutkan dengan klik tombol next hingga selesai !!
                                    </div>
                                    @else
                                    <div class="alert alert-danger alert-block" id="alert-generate">
                                        <strong><i class="fa fa-info-circle"></i>&nbsp;Perhatian: </strong> Silahkan Generate Data Tenaga Kependidikan Terlebih Dahulu !!
                                    </div>
                                @endif
                    @endif
                    <div class="alert alert-warning alert-block" id="alert-proses-generate" style="display:none;">
                        <strong><i class="fa fa-info-circle"></i>&nbsp;Harap Tunggu: </strong> Proses Generate Data Tenaga Kependidikan Sedang Berlangsung !!
                    </div>
                </div>
                <div class="col-md-12" >
                    <nav aria-label="...">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="{{ route('kepegawaian.rekapitulasi.persentase_absen',[$periode_id]) }}">Previous</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.rekapitulasi',[$periode_id]) }}">1</a></li>
                            <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.rekapitulasi.data_tendik',[$periode_id]) }}">2</a></li>
                            <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.rekapitulasi.total_remun',[$periode_id]) }}">3</a></li>
                            <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.rekapitulasi.integritas',[$periode_id]) }}">4</a></li>
                            <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.rekapitulasi.skp',[$periode_id]) }}">5</a></li>
                            <li class="page-item"><a class="page-link" href="{{ route('kepegawaian.rekapitulasi.persentase_absen',[$periode_id]) }}">6</a></li>
                          <li class="page-item active">
                            <span class="page-link">
                                7
                                <span class="sr-only">(current)</span>
                              </span>
                          </li>
                          <li class="page-item disabled">
                            <a class="page-link">Next</a>
                          </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-md-12">

                        <a href="{{ route('kepegawaian.rekapitulasi.generate_total_akhir',[$periode_aktif->id]) }}" id="generate" onclick="generateTendik()" class="btn btn-primary btn-sm"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Total Remunerasi</a>
                    <button class="btn btn-warning btn-sm disabled" id="proses-generate" style="display:none;color:white;cursor:pointer;"><i class="fa fa-cog fa-spin"></i>&nbsp; Generate Total Remunerasi</button>
                </div>
                <div class="col-md-12 table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No :</th>
                                <th style="text-align:center;">Nama :</th>
                                <th style="text-align:center;">Nip :</th>
                                <th style="text-align:center;">Pangkat :</th>
                                <th style="text-align:center;">Golongan :</th>
                                <th style="text-align:center;">Kelas Jabatan :</th>
                                <th style="text-align:center;">Nama Jabatan :</th>
                                <th style="text-align:center;">Remunerasi Per Bulan :</th>
                                <th style="text-align:center;">Remunerasi 30% :</th>
                                <th style="text-align:center;">Remunerasi 70% :</th>
                                <th style="text-align:center;">Jumlah Bulan :</th>
                                <th style="text-align:center;">Jumlah Remun 30% :</th>
                                <th style="text-align:center;">Jumlah Remun 70% :</th>
                                <th style="text-align:center;">Total Remun 30% + 70% :</th>
                                <th style="text-align:center;">Pajak PPH 5% dan 15% :</th>
                                <th style="text-align:center;">Laporan LHKPN/LHKASN :</th>
                                <th style="text-align:center;">Ada Sanksi Disiplin :</th>
                                <th style="text-align:center;">Potongan Nominal Potongan LHKPN/LHKASN :</th>
                                <th style="text-align:center;">Potongan Nominal Sanksi Disiplin  :</th>
                                <th style="text-align:center;">Potongan Integrias 1 Bulan  :</th>
                                <th style="text-align:center;">Nilai Capaian SKP  :</th>
                                <th style="text-align:center;">Potongan SKP 1 Bulan  :</th>
                                @if ($periode_aktif->jumlah_bulan == 1)
                                    <th style="text-align:center;">Potongan Persen Bulan 1  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 1  :</th>
                                    @elseif($periode_aktif->jumlah_bulan == 2)
                                    <th style="text-align:center;">Potongan Persen Bulan 1  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 2  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 1  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 2  :</th>
                                    @elseif($periode_aktif->jumlah_bulan == 3)
                                    <th style="text-align:center;">Potongan Persen Bulan 1  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 2  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 3  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 1  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 2  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 3  :</th>
                                    @elseif($periode_aktif->jumlah_bulan == 4)
                                    <th style="text-align:center;">Potongan Persen Bulan 1  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 2  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 3  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 4  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 1  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 2  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 3  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 4  :</th>
                                    @elseif($periode_aktif->jumlah_bulan == 5)
                                    <th style="text-align:center;">Potongan Persen Bulan 1  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 2  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 3  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 4  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 5  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 1  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 2  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 3  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 4  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 5  :</th>
                                    @elseif($periode_aktif->jumlah_bulan == 6)
                                    <th style="text-align:center;">Potongan Persen Bulan 1  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 2  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 3  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 4  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 5  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 6  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 1  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 2  :</th>
                                    <th style="text-align:center;">Potongan Persen Bulan 3  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 4  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 5  :</th>
                                    <th style="text-align:center;">Potongan Nominal Bulan 6  :</th>
                                @endif
                                <th style="text-align:center;">Potongan Absensi :</th>
                                <th style="text-align:center;">Potongan SKP :</th>
                                <th style="text-align:center;">Potongan Integritas :</th>
                                <th style="text-align:center;">Remun Diterima :</th>
                                <th style="text-align:center;">Nomor Rekening :</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($datas as $data)
                                <tr>
                                    <td> {{ $no++ }} </td>
                                    <td> {{ $data->nm_lengkap }} </td>
                                    <td> {{ $data->nip }} </td>
                                    <td> {{ $data->pangkat }} </td>
                                    <td> {{ $data->golongan }} </td>
                                    <td> {{ $data->kelas_jabatan }} </td>
                                    <td> {{ $data->nm_jabatan }} </td>
                                    <td> Rp. {{ round($data->remunerasi_per_bulan) }} </td>
                                    <td> Rp. {{ round($data->remunerasi_30) }} </td>
                                    <td> Rp. {{ round($data->remunerasi_70) }} </td>
                                    <td> {{ $data->jumlah_bulan }} </td>
                                    <td> Rp. {{ round($data->jumlah_remun_30) }} </td>
                                    <td> Rp. {{ round($data->jumlah_remun_70) }} </td>
                                    <td> Rp. {{ round($data->total_remun) }} </td>
                                    <td> Rp. {{ round($data->potongan_pph) }} </td>
                                    <td> {{ $data->laporan_lhkpn_lhkasn }} </td>
                                    <td> {{ $data->sanksi_disiplin }} </td>
                                    <td> Rp. {{ round($data->nominal_lhkpn_lhkasn) }} </td>
                                    <td> Rp. {{ round($data->nominal_sanksi_disiplin) }} </td>
                                    <td> {{ $data->potongan_integritas_satu_bulan }} </td>
                                    <td> {{ $data->nilai_skp }} </td>
                                    <td> {{ $data->potongan_skp }} </td>
                                    @if ($periode_aktif->jumlah_bulan == 1)
                                        <td>{{ $data->persen_absen_bulan_satu }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_satu) }}</td>
                                        @elseif ($periode_aktif->jumlah_bulan == 2)
                                        <td>{{ $data->persen_absen_bulan_satu }}</td>
                                        <td>{{ $data->persen_absen_bulan_dua }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_satu) }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_dua) }}</td>
                                        @elseif ($periode_aktif->jumlah_bulan == 3)
                                        <td>{{ $data->persen_absen_bulan_satu }}</td>
                                        <td>{{ $data->persen_absen_bulan_dua }}</td>
                                        <td>{{ $data->persen_absen_bulan_tiga }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_satu) }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_dua) }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_tiga) }}</td>
                                        @elseif ($periode_aktif->jumlah_bulan == 4)
                                        <td>{{ $data->persen_absen_bulan_satu }}</td>
                                        <td>{{ $data->persen_absen_bulan_dua }}</td>
                                        <td>{{ $data->persen_absen_bulan_tiga }}</td>
                                        <td>{{ $data->persen_absen_bulan_empat }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_satu) }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_dua) }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_tiga) }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_empat) }}</td>
                                        @elseif ($periode_aktif->jumlah_bulan == 5)
                                        <td>{{ $data->persen_absen_bulan_satu }}</td>
                                        <td>{{ $data->persen_absen_bulan_dua }}</td>
                                        <td>{{ $data->persen_absen_bulan_tiga }}</td>
                                        <td>{{ $data->persen_absen_bulan_empat }}</td>
                                        <td>{{ $data->persen_absen_bulan_lima }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_satu) }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_dua) }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_tiga) }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_empat) }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_lima) }}</td>
                                        @elseif ($periode_aktif->jumlah_bulan == 6)
                                        <td>{{ $data->persen_absen_bulan_satu }}</td>
                                        <td>{{ $data->persen_absen_bulan_dua }}</td>
                                        <td>{{ $data->persen_absen_bulan_tiga }}</td>
                                        <td>{{ $data->persen_absen_bulan_empat }}</td>
                                        <td>{{ $data->persen_absen_bulan_lima }}</td>
                                        <td>{{ $data->persen_absen_bulan_enam }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_satu) }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_dua) }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_tiga) }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_empat) }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_lima) }}</td>
                                        <td>Rp. {{ round($data->nominal_absen_bulan_enam) }}</td>
                                    @endif
                                    <td>Rp. {{ round($data->total_absensi) }}</td>
                                    <td>Rp. {{ round($data->total_skp) }}</td>
                                    <td>Rp. {{ round($data->total_integritas) }}</td>
                                    <td>
                                        @if ($data->total_akhir_remun == null)
                                            <a style="color: red">Total belum digenerate</a>
                                            @else
                                            Rp. {{ round($data->total_akhir_remun) }}
                                        @endif
                                    </td>
                                    <td>{{ $data->no_rekening }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- {{$datas->links("pagination::bootstrap-4") }} --}}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#table').DataTable( {
                // responsive :true,
                buttons: [
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [ 0, ':visible' ]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible',
                        modifier: {
                        order: 'current',
                        page: 'all',
                        selected: false,
        },
                    }
                },
                'colvis'
            ],
                dom:
                "<'row'<'col-md-3'l><'col-md-5'B><'col-md-4'f>>" +
                "<'row'<'col-md-12'tr>>" +
                "<'row'<'col-md-5'i><'col-md-7'p>>",
                lengthMenu:[
                    [5,10,25,50,100,-1],
                    [5,10,25,50,100,"All"]
                ]
            } );

            table.buttons().container()
                .appendTo( '#table_wrapper .col-md-5:eq(0)' );
        } );

        function generateTendik(){
            $('#alert-generate').hide(300);
            $('#alert-proses-generate').show(300);
            $('#generate').hide(300);
            $('#proses-generate').show(300);
        }
    </script>
@endpush
