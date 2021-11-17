<li>
    <a  href=" {{ route('operator.dashboard') }} "><i class="fa fa-home"></i>Dashboard</a>
</li>

<li
    @if (Route::current()->getName() == "operator.dataremun")
    class="current-page"
        @elseif(Route::current()->getName() == "operator.detail_isian")
            class="current-page"
    @endif
>
    <a href="{{ route('operator.datainsentif') }}"><i class="fa fa-clock-o"></i>Data Remunerasi</a>
</li>

<li>
    <a href="{{ route('operator.laporan') }}"><i class="fa fa-file-pdf-o"></i>Laporan Remun</a>
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