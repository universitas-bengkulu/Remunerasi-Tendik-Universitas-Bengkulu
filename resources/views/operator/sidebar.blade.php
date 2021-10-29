@php
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}
    use App\Models\PeriodeInsentif;
    $periode_aktif = PeriodeInsentif::where('status','aktif')->select('slug')->firstOrFail();
@endphp
<li>
    <a class={{ count($periode_aktif)<1 ? "noclick"  : 'click'}} href=" {{ route('operator.dashboard',[$periode_aktif->slug]) }} "><i class="fa fa-home"></i>Dashboard</a>
</li>

<li>
    <a href="{{ route('operator.datainsentif') }}"><i class="fa fa-clock-o"></i>Data Remunerasi</a>
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