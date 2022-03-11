@php
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
    use App\Models\Periode;
    $periode_aktif = Periode::where('status','aktif')->select('id')->first();
@endphp
<li>
    <a class={{ count((array)$periode_aktif)<1 ? "noclick"  : 'click'}} href=" {{ route('kepegawaian.dashboard') }} "><i class="fa fa-home"></i>Dashboard</a>
</li>

<li>
    <a href=" {{ route('kepegawaian.periode') }} "><i class="fa fa-clock-o"></i>Periode Remunerasi</a>
</li>

<li>
    <a class={{ count((array)$periode_aktif)<1 ? "noclick"  : 'click'}} href=" {{ route('kepegawaian.jabatan') }} "><i class="fa fa-briefcase"></i>Manajemen Jabatan</a>
</li>

<li>
    <a class={{ count((array)$periode_aktif)<1 ? "noclick"  : 'click'}} href=" {{ route('kepegawaian.tendik') }} "><i class="fa fa-users"></i>Manajemen Data Tendik</a>
</li>

<li 
    @if (Route::current()->getName() == "kepegawaian.r_integritas" || Route::current()->getName() == "kepegawaian.r_integritas.remun_30"
        ||Route::current()->getName() == "kepegawaian.r_integritas.remun_70"||Route::current()->getName() == "kepegawaian.r_integritas.total_remun"||
        Route::current()->getName() == "kepegawaian.r_integritas.pajak_pph"||Route::current()->getName() == "kepegawaian.r_integritas.lhkpn_lhkasn"||
        Route::current()->getName() == "kepegawaian.r_integritas.sanksi_disiplin"||Route::current()->getName() == "kepegawaian.r_integritas.integritas_satu_bulan"||
        Route::current()->getName() == "kepegawaian.r_integritas.total_integritas"||Route::current()->getName() == "kepegawaian.r_skp"||
        Route::current()->getName() == "kepegawaian.r_absensi"||Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_1"||
        Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_2"||Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_3"||
        Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_4"||Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_5"||Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_6")
        class="set_active active"
    @endif
><a class={{ count((array)$periode_aktif)<1 ? "noclick"  : 'click'}}><i class="fa fa-check-circle"></i>Rubrik Remun P1&P2<span class="fa fa-chevron-down" ></span></a>
    <ul class="nav child_menu"
        @if (Route::current()->getName() == "kepegawaian.r_integritas" || Route::current()->getName() == "kepegawaian.r_integritas.remun_30"
            ||Route::current()->getName() == "kepegawaian.r_integritas.remun_70"||Route::current()->getName() == "kepegawaian.r_integritas.total_remun"||
            Route::current()->getName() == "kepegawaian.r_integritas.pajak_pph"||Route::current()->getName() == "kepegawaian.r_integritas.lhkpn_lhkasn"||
            Route::current()->getName() == "kepegawaian.r_integritas.sanksi_disiplin"||Route::current()->getName() == "kepegawaian.r_integritas.integritas_satu_bulan"||
            Route::current()->getName() == "kepegawaian.r_integritas.total_integritas"||Route::current()->getName() == "kepegawaian.r_skp"||
            Route::current()->getName() == "kepegawaian.r_absensi"||Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_1"||
            Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_2"||Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_3"||
            Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_4"||Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_5"||Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_6")
            style="display:block !important;"
        @endif
    >
        <li
        @if (Route::current()->getName() == "kepegawaian.capaian_skp")
                class="current-page"
        @endif
        ><a href=" {{ route('kepegawaian.r_skp',[count((array)$periode_aktif)> 0 ? $periode_aktif->id : '']) }} ">Rubrik Capaian SKP</a></li>
        <li
            @if(Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_1" || Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_2"||
            Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_3"||Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_4"||
            Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_5"||Route::current()->getName() == "kepegawaian.r_absensi.potongan_bulan_6")
            class="current-page "
        @endif
        ><a href=" {{ route('kepegawaian.r_absensi',[count((array)$periode_aktif)> 0 ? $periode_aktif->id : '']) }} ">Rubrik Absensi</a></li> 
        <li
            @if (Route::current()->getName() == "kepegawaian.r_integritas")
                class="current-page"
                @elseif(Route::current()->getName() == "kepegawaian.r_integritas.remun_30")
                class="current-page"
                @elseif(Route::current()->getName() == "kepegawaian.r_integritas.remun_70")
                class="current-page"
                @elseif(Route::current()->getName() == "kepegawaian.r_integritas.total_remun")
                class="current-page"
                @elseif(Route::current()->getName() == "kepegawaian.r_integritas.pajak_pph")
                class="current-page"
                @elseif(Route::current()->getName() == "kepegawaian.r_integritas.lhkpn_lhkasn")
                class="current-page"
                @elseif(Route::current()->getName() == "kepegawaian.r_integritas.sanksi_disiplin")
                class="current-page"
                @elseif(Route::current()->getName() == "kepegawaian.r_integritas.integritas_satu_bulan")
                class="current-page"
                @elseif(Route::current()->getName() == "kepegawaian.r_integritas.total_integritas")
                class="current-page"
            @endif
        ><a href=" {{ route('kepegawaian.r_integritas',[count((array)$periode_aktif)> 0 ? $periode_aktif->id : '']) }} ">Rubrik Disiplin</a></li> 
    </ul>
</li>

<li>
    <a href=" {{ route('kepegawaian.rekapitulasi',[count((array)$periode_aktif)> 0 ? $periode_aktif->id : '']) }} "><i class="fa fa-bar-chart"></i>Rekapitulasi P1, P2</a>
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