<li{!! is_current_resource(['spas-spa']) !!}>
    <a href="javascript:void(0)"><i class="fa fa-tint"></i>{{ trans('spas::pulsar.package_name') }}</a>
    <ul class="sub-menu">
        @if(is_allowed('spas-spa', 'access'))
            <li{!! is_current_resource('spas-spa') !!}><a href="{{ route('spa', [base_lang2()->id_001]) }}"><i class="fa fa-tint"></i>{{ trans_choice('spas::pulsar.spa', 2) }}</a></li>
        @endif
    </ul>
</li>