@extends('layouts.layout')
@section('title', 'Manajemen Data Remunerasi')
@section('login_as', 'Administrator')
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
       <div class="row">
           <div class="col-md-12">
               <table class="table table-hover table-bordered" id="table" style="width: 100%">
                   <thead>
                       <tr>
                           <th width="4%">no</th>
                           <th class="text-center">Nama Rubrik</th>
                           <th class="text-center">Periode</th>
                           <th class="text-center">Detail</th>
                       </tr>
                   </thead>
                   <tbody>
                       @php
                           $no=1;
                       @endphp
                       @foreach ($data_rubriks as $rubrik)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $rubrik->nama_rubrik }}</td>
                                <td>{{ $periode->masa_kinerja }}</td>
                                <td>
                                    <a href="{{ route('administrator.dataremun',[$rubrik->id_rubrik]) }}" class="btn btn-primary btn-sm"><i class="fa fa-info-circle"></i>&nbsp; Detail</a>
                                </td>
                            </tr>
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
    </script>

@endpush
