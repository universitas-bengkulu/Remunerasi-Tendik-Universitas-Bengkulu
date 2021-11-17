
<li>
    <a  href=" {{ route('administrator.dashboard') }} "><i class="fa fa-home"></i>Dashboard</a>
</li>
<li><a><i class="fa fa-newspaper-o"></i> Manajemen Periode <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu" style="display: none">
        
        <li>  <a href=" {{ route('administrator.periode') }} "><i class="fa fa-calendar"></i>Periode Remun P1 & P2</a></li>
            <li> <a href=" {{ route('administrator.periodeinsentif') }} "><i class="fa fa-calendar"></i>Periode Remun P3</a></li>
       
    </ul>
</li>
<li>
    <a href=" {{ route('administrator.unit') }} "><i class="fa fa-building"></i>Manajemen Unit</a>
</li>
<li>
    <a href=" {{ route('administrator.jabatan') }} "><i class="fa fa-user"></i>Manajemen Jabatan</a>
</li>

<li><a><i class="fa fa-info-circle"></i>Manajemen Rubrik <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu" style="display: none">
        <li><a href=" {{ route('administrator.rubrik') }} "><i class="fa fa-book"></i>Manajemen Rubrik</a></li>
        <li><a href=" {{ route('administrator.pengguna_rubrik') }} "><i class="fa fa-book"></i>Pengguna Rubrik</a></li>
    </ul>
</li>

<li><a><i class="fa fa-users"></i>Manajemen User <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu" style="display: none">
        <li> <a href=" {{ route('administrator.tendik') }} "><i class="fa fa-user"></i>Manajemen Tendik</a></li>
            <li><a href=" {{ route('administrator.user') }} "><i class="fa fa-user"></i>Manajemen User</a></li>
       
    </ul>
</li>
<li><a><i class="fa fa-newspaper-o"></i>Rekapitulasi <span class="fa fa-chevron-down"></span></a>
    <ul class="nav child_menu" style="display: none">
        <li><a href=" {{ route('administrator.rekap_p1') }} "><i class="fa fa-book"></i>Rekapitulasi P1 dan P2</a></li>
        <li><a href=" {{ route('administrator.rekap_p3') }} "><i class="fa fa-book"></i>Rekapitulasi P3</a></li>
    </ul>
</li>

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