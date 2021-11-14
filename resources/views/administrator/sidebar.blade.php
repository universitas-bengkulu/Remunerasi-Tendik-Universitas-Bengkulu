@php
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
    use App\Models\PeriodeInsentif;
    $periode_aktif = PeriodeInsentif::where('status','aktif')->select('slug')->firstOrFail();
@endphp
<li>
    <a class={{ count($periode_aktif)<1 ? "noclick"  : 'click'}} href=" {{ route('administrator.dashboard') }} "><i class="fa fa-home"></i>Dashboard</a>
</li>
<li><a><i class="fa fa-newspaper-o"></i> Periode <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu" style="display: none">
        
        <li>  <a href=" {{ route('administrator.periode') }} "><i class="fa fa-calendar"></i>Periode Remunerasi</a></li>
            <li> <a href=" {{ route('administrator.periodeinsentif') }} "><i class="fa fa-calendar"></i>Periode p3 Remunerasi</a></li>
       
    </ul>
</li>
<li>
  
</li>
<li>
   
</li>
<li>
    <a href=" {{ route('administrator.unit') }} "><i class="fa fa-building"></i>Unit</a>
</li>
<li>

</li>
<li><a><i class="fa fa-newspaper-o"></i> Rubrik <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu" style="display: none">
        
        <li><a href=" {{ route('administrator.rubrik') }} "><i class="fa fa-book"></i> Rubrik</a></li>
        <li><a href=" {{ route('administrator.isianrubrik') }} "><i class="fa fa-user"></i>Isian Rubrik</a></li>  
        <li><a href=" {{ route('administrator.detailisianrubrik') }} "><i class="fa fa-book"></i>Detail Isian Rubrik</a></li>
       
    </ul>
</li>
<li>
    <a href=" {{ route('administrator.jabatan') }} "><i class="fa fa-user"></i>Jabatan</a>
   
</li>
<li>
    <a href=" {{ route('administrator.penggunarubrik') }} "><i class="fa fa-user"></i>Pengguna Rubrik</a>
   
</li>
<li>
    <a href=" {{ route('administrator.user') }} "><i class="fa fa-user"></i>User</a>
</li>
<li>
    <a href=" {{ route('administrator.tendik') }} "><i class="fa fa-user"></i>Tendik</a>
</li>
<li>
    <a href=" {{ route('administrator.user') }} "><i class="fa fa-book"></i>Laporan</a>
</li>
{{-- <li>
    <a class={{ count($periode_aktif)<1 ? "noclick"  : 'click'}} href=" {{ route('administrator.jabatan') }} "><i class="fa fa-briefcase"></i>Manajemen Jabatan</a>
</li> --}}

<li style="padding-left:2px;">
    <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
        <i class="fa fa-power-off text-danger"></i>{{__('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>

@push('styles')
    <style>
        .noclick       {
            pointer-events: none;
            cursor: context-menu;
            background-color: #ed5249;
        }

        .default{
            cursor: default;
        }

        .set_active{
            border-right: 5px solid #1ABB9C;
        }

    </style>
@endpush