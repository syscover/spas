<li{!! Miscellaneous::setCurrentOpenPage(['spas-spa']) !!}>
    <a href="javascript:void(0)"><i class="fa fa-tint"></i>{{ trans('spas::pulsar.package_name') }}</a>
    <ul class="sub-menu">
        @if(session('userAcl')->allows('spas-spa', 'access'))
            <li{!! Miscellaneous::setCurrentPage('spas-spa') !!}><a href="{{ route('spa', [session('baseLang')->id_001]) }}"><i class="fa fa-tint"></i>{{ trans_choice('spas::pulsar.spa', 2) }}</a></li>
        @endif
    </ul>
</li>