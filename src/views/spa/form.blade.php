@extends('pulsar::layouts.tab', ['tabs' => [
        ['id' => 'box_tab1', 'name' => trans_choice('hotels::pulsar.hotel', 1)],
        ['id' => 'box_tab2', 'name' => trans_choice('pulsar::pulsar.description', 2)],
        ['id' => 'box_tab3', 'name' => trans_choice('pulsar::pulsar.attachment', 2)],
    ]])

@section('head')
    @parent
    <link rel="stylesheet" href="{{ asset('packages/syscover/pulsar/vendor/mappoint/css/mappoint.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/syscover/pulsar/vendor/attachment/css/attachment-library.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/syscover/pulsar/vendor/getfile/libs/cropper/cropper.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/syscover/pulsar/vendor/getfile/libs/filedrop/filedrop.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/syscover/pulsar/vendor/getfile/css/getfile.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/syscover/pulsar/vendor/select-listdescription/select-listdescription.css') }}">

    <script src="{{ asset('packages/syscover/pulsar/vendor/getaddress/js/jquery.getaddress.js') }}"></script>
    <script src="{{ asset('packages/syscover/pulsar/vendor/getfile/libs/cropper/cropper.min.js') }}"></script>
    <script src="{{ asset('packages/syscover/pulsar/vendor/getfile/libs/cssloader/js/jquery.cssloader.min.js') }}"></script>
    <script src="{{ asset('packages/syscover/pulsar/vendor/getfile/libs/mobiledetect/mdetect.min.js') }}"></script>
    <script src="{{ asset('packages/syscover/pulsar/vendor/getfile/libs/filedrop/filedrop.min.js') }}"></script>
    <script src="{{ asset('packages/syscover/pulsar/vendor/getfile/js/jquery.getfile.js') }}"></script>
    <script src="{{ asset('packages/syscover/pulsar/vendor/speakingurl/speakingurl.min.js') }}"></script>
    <script src="{{ asset('packages/syscover/pulsar/vendor/duallistbox/jquery.duallistbox.1.3.1.js') }}"></script>
    <script src="{{ asset('packages/syscover/pulsar/vendor/mappoint/js/jquery.mappoint.js') }}"></script>
    <script src="{{ asset('packages/syscover/pulsar/plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('api.googleMapsApiKey') }}&libraries=places"></script>

    @include('pulsar::includes.html.froala_references')

    <script src="{{ asset('packages/syscover/pulsar/vendor/attachment/js/attachment-library.js') }}"></script>
    @include('pulsar::includes.js.attachment', [
        'resource'          => 'hotels-hotel',
        'routesConfigFile'  => 'hotels',
        'objectId'          => isset($object)? $object->id_180 : null])
    @include('pulsar::includes.js.check_slug', [
        'route' => 'apiCheckSlugHotel'
    ])

    <script>
        $(document).ready(function() {
            // to hotel data
            $.getAddress({
                id:                         '01',
                type:                       'laravel',
                appName:                    'pulsar',
                token:                      '{{ csrf_token() }}',
                lang:                       '{{ config('app.locale') }}',
                highlightCountrys:          ['ES','US'],

                useSeparatorHighlight:      true,
                textSeparatorHighlight:     '------------------',

                countryValue:               '{{ old('country', isset($object->country_180)? $object->country_180 : null) }}',
                territorialArea1Value:      '{{ old('territorialArea1', isset($object->territorial_area_1_180)? $object->territorial_area_1_180 : null) }}',
                territorialArea2Value:      '{{ old('territorialArea2', isset($object->territorial_area_2_180)? $object->territorial_area_2_180 : null) }}',
                territorialArea3Value:      '{{ old('territorialArea3', isset($object->territorial_area_3_180)? $object->territorial_area_3_180 : null) }}'
            })

            // to billing data
            $.getAddress({
                id:                         '02',
                type:                       'laravel',
                appName:                    'pulsar',
                token:                      '{{ csrf_token() }}',
                lang:                       '{{ config('app.locale') }}',
                highlightCountrys:          ['ES','US'],

                useSeparatorHighlight:      true,
                textSeparatorHighlight:     '------------------',

                tA1Wrapper:					'billingTerritorialArea1Wrapper',
                tA2Wrapper:					'billingTerritorialArea2Wrapper',
                tA3Wrapper:					'billingTerritorialArea3Wrapper',
                tA1Label:                   'billingTerritorialArea1Label',
                tA2Label:                   'billingTerritorialArea2Label',
                tA3Label:                   'billingTerritorialArea3Label',
                countrySelect:              'billingCountry',
                tA1Select:                  'billingTerritorialArea1',
                tA2Select:                  'billingTerritorialArea2',
                tA3Select:                  'billingTerritorialArea3',

                countryValue:               '{{ old('billingCountry', isset($object->billing_country_180)? $object->billing_country_180 : null) }}',
                territorialArea1Value:      '{{ old('billingTerritorialArea1', isset($object->billing_territorial_area_1_180)? $object->billing_territorial_area_1_180 : null) }}',
                territorialArea2Value:      '{{ old('billingTerritorialArea2', isset($object->billing_territorial_area_2_180)? $object->billing_territorial_area_2_180 : null) }}',
                territorialArea3Value:      '{{ old('billingTerritorialArea3', isset($object->billing_territorial_area_3_180)? $object->billing_territorial_area_3_180 : null) }}'
            })

            $.mapPoint({
                id:                 '01',
                urlPlugin:          '/packages/syscover/pulsar/vendor',
                @if(!empty($object->latitude_180))lat: {{ $object->latitude_180 }},@endif
                @if(!empty($object->longitude_180))lng: {{ $object->longitude_180 }},@endif
                zoom:               12,
                showMarker:         true,
                customIcon:         {
                    src: '/packages/syscover/hotels/images/location.svg',
                    scaledWidth: 49,
                    scaledHeight: 71,
                    anchorX: 25,
                    anchorY: 71
                }
            })

            $('.wysiwyg').froalaEditor({
                language: '{{ config('app.locale') }}',
                toolbarInline: false,
                toolbarSticky: true,
                tabSpaces: true,
                shortcutsEnabled: ['show', 'bold', 'italic', 'underline', 'strikeThrough', 'indent', 'outdent', 'undo', 'redo', 'insertImage', 'createLink'],
                toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript', '|', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'insertHR', 'insertLink', 'undo', 'redo', 'clearFormatting', 'selectAll', 'html'],
                heightMin: 130,
                enter: $.FroalaEditor.ENTER_BR,
                key: '{{ config('pulsar.froalaEditorKey') }}'
            })

            // custom Dual multi select
            $.configureBoxes({
                textShowing: '{{ trans('pulsar::pulsar.showing') }}',
                textOf: '{{ trans('pulsar::pulsar.of') }}'
            })

            // launch slug function when change name and slug
            $("[name=name], [name=slug]").on('change', function(){
                $("[name=slug]").val(getSlug($(this).val(),{
                    separator: '-',
                    lang: '{{ $lang->id_001 }}'
                }))
                $.checkSlug()
            })

            // save id product to save it after
            $(".product-toggle").on('change', function() {
                var products = JSON.parse($('[name=products]').val())
                if($(this).is(':checked'))
                {
                    products.push($(this).val())
                }
                else
                {
                    var i = products.indexOf($(this).val())
                    if(i != -1)
                        products.splice(i, 1)
                }
                $('[name=products]').val(JSON.stringify(products))
            })

            // set tab active
            @if(isset($tab))
                $('.tabbable li:eq({{ $tab }}) a').tab('show')
            @endif
        })
    </script>

    @include('pulsar::includes.js.custom_fields', [
        'resource' => 'hotels-hotel'
    ])
    @include('pulsar::includes.js.delete_translation_record')
@stop

@section('layoutTabHeader')
    @include('pulsar::includes.html.form_record_header')
@stop
@section('layoutTabFooter')
    @include('pulsar::includes.html.form_record_footer')
@stop

@section('box_tab1')
    <!-- hotels::hotels.create -->
    <div class="row">
        <div class="col-md-6">
            @include('pulsar::includes.html.form_text_group', [
                'label' => 'ID',
                'fieldSize' => 4,
                'name' => 'id',
                'value' => old('id', isset($object->id_180)? $object->id_180 : null),
                'readOnly' => true
            ])
        </div>
        <div class="col-md-6">
            @include('pulsar::includes.html.form_image_group', [
                'label' => 'ID',
                'fieldSize' => 4,
                'label' => trans_choice('pulsar::pulsar.language', 1),
                'name' => 'lang',
                'nameImage' => $lang->name_001,
                'value' => $lang->id_001,
                'url' => asset('/packages/syscover/pulsar/storage/langs/' . $lang->image_001)
            ])
        </div>
    </div>
    @include('pulsar::includes.html.form_text_group', [
        'labelSize' => 1,
        'fieldSize' => 11,
        'label' => trans('pulsar::pulsar.name'),
        'name' => 'name',
        'value' => old('name', isset($object->name_180)? $object->name_180 : null),
        'maxLength' => '100',
        'rangeLength' => '2,100',
        'required' => true,
        'readOnly' => $action == 'update' || $action == 'store'? false : true
    ])
    @include('pulsar::includes.html.form_text_group', [
        'labelSize' => 1,
        'fieldSize' => 11,
        'label' => trans('pulsar::pulsar.slug'),
        'name' => 'slug',
        'value' => old('slug', isset($object->slug_180)? $object->slug_180 : null),
        'maxLength' => '255',
        'rangeLength' => '2,255',
        'required' => true,
        'readOnly' => $action == 'update' || $action == 'store'? false : true
    ])
    <div class="row">
        <div class="col-md-6">
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans('pulsar::pulsar.web'),
                'name' => 'web',
                'value' => old('web', isset($object->web_180)? $object->web_180 : null),
                'maxLength' => '100',
                'rangeLength' => '2,100',
                'placeholder' => 'mydomain.com',
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans_choice('pulsar::pulsar.contact', 1),
                'name' => 'contact',
                'value' => old('contact', isset($object->contact_180)? $object->contact_180 : null),
                'maxLength' => '100',
                'rangeLength' => '2,100',
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans_choice('pulsar::pulsar.phone', 1),
                'name' => 'phone',
                'value' => old('phone', isset($object->phone_180)? $object->phone_180 : null),
                'maxLength' => '50',
                'rangeLength' => '2,50',
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans('pulsar::pulsar.fax'),
                'name' => 'fax',
                'value' => old('fax', isset($object->fax_180)? $object->fax_180 : null),
                'maxLength' => '50',
                'rangeLength' => '2,50',
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
        </div>
        <div class="col-md-6">
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans('hotels::pulsar.web_url'),
                'name' => 'webUrl',
                'value' => old('webUrl', isset($object->web_url_180)? $object->web_url_180 : null),
                'maxLength' => '100',
                'rangeLength' => '2,100',
                'placeholder' => 'http://www.mydomain.com',
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans('pulsar::pulsar.email'),
                'name' => 'email',
                'value' => old('email', isset($object->email_180)? $object->email_180 : null),
                'maxLength' => '50',
                'rangeLength' => '2,50',
                'type' => 'email',
                'required' => true,
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans('pulsar::pulsar.mobile'),
                'name' => 'mobile',
                'value' => old('mobile', isset($object->mobile_180)? $object->mobile_180 : null),
                'maxLength' => '50',
                'rangeLength' => '2,50',
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
            @include('pulsar::includes.html.form_select_group', [
                'fieldSize' => 7,
                'label' => trans_choice('pulsar::pulsar.field_group', 1),
                'name' => 'customFieldGroup',
                'value' => old('customFieldGroup', isset($object->custom_field_group_180)? $object->custom_field_group_180 : null),
                'objects' => $customFieldGroups,
                'idSelect' => 'id_025',
                'nameSelect' => 'name_025'
            ])
        </div>
    </div>

    @include('pulsar::includes.html.form_section_header', [
        'label' => trans('pulsar::pulsar.access'),
        'icon' => 'fa fa-check-circle-o'
    ])
    <div class="row">
        <div class="col-md-6">
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans_choice('pulsar::pulsar.user', 1),
                'name' => 'user',
                'value' => old('user', isset($object->user_180)? $object->user_180 : null),
                'maxLength' => '50',
                'rangeLength' => '2,50',
                'fieldSize' => 6,
                'required' => true,
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
            @include('pulsar::includes.html.form_text_group', [
                'fieldSize' => 8,
                'label' => trans('pulsar::pulsar.password'),
                'type' => 'password',
                'name' => 'password',
                'value' => old('password'),
                'maxLength' => '50',
                'rangeLength' => '4,50',
                'required' => $action == 'store'? true : false,
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
            @include('pulsar::includes.html.form_text_group', [
                'fieldSize' => 8,
                'label' => trans('pulsar::pulsar.repeat_password'),
                'type' => 'password' ,
                'name' => 'repassword',
                'value' => old('repassword'),
                'maxLength' => '50',
                'rangeLength' => '4,50',
                'required' => $action == 'store'? true : false,
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
        </div>
        <div class="col-md-6">
            @include('pulsar::includes.html.form_select_group', [
                'label' => trans('hotels::pulsar.published'),
                'name' => 'published[]',
                'value' => old('published', isset($object)? $object->getPublications : null),
                'objects' => $publications,
                'idSelect' => 'id_174',
                'nameSelect' => 'name_174',
                'multiple' => true,
                'class' => 'select2',
                'data' => [
                    'language' => config('app.locale'),
                    'width' => '100%',
                    'error-placement' => 'select2-section-outer-container',
                    'disabled' => $action == 'update' || $action == 'store'? false : true
                ]
            ])
            @include('pulsar::includes.html.form_checkbox_group', [
                'label' => trans('pulsar::pulsar.active'),
                'name' => 'active',
                'value' => 1,
                'checked' => old('active', isset($object)? $object->active_180 : null),
                'disabled' => $action == 'update' || $action == 'store'? false : true
            ])
        </div>
    </div>

    @include('pulsar::includes.html.form_section_header', [
        'label' => trans_choice('hotels::pulsar.service', 2),
        'icon' => 'fa fa-star'
    ])
    @include('pulsar::includes.html.form_dual_list_group', [
        'name' => 'services',
        'value' => old('countries'),
        'objectsSelect' => isset($object)? $object->getServices->where('lang_153', $lang->id_001) : null,
        'objects' => $services,
        'idSelect' => 'id_153',
        'nameSelect' => 'name_153',
        'idList1' => 1,
        'idList2' => 2,
        'labelList1' => trans('hotels::pulsar.services_list'),
        'labelList2' => trans('hotels::pulsar.selected_services'),
        'required' => true
    ])

    @include('pulsar::includes.html.form_section_header', [
        'label' => trans_choice('pulsar::pulsar.feature', 2),
        'icon' => 'fa fa-bookmark'
    ])
    <div class="row">
        <div class="col-md-6">
            @include('pulsar::includes.html.form_select_group', [
                'label' => trans_choice('hotels::pulsar.environment', 1),
                'name' => 'environment',
                'value' => old('environment', isset($object->environment_180)? $object->environment_180 : null),
                'objects' => $environments,
                'idSelect' => 'id_150',
                'nameSelect' => 'name_150',
                'class' => 'select2',
                'data' => [
                    'language' => config('app.locale'),
                    'width' => '100%',
                    'error-placement' => 'select2-section-outer-container',
                    'disabled' => $action == 'update' || $action == 'store'? false : true
                ]
            ])
            @include('pulsar::includes.html.form_select_group', [
                'label' => trans_choice('hotels::pulsar.decoration', 1),
                'name' => 'decoration',
                'value' => old('decoration', isset($object->decoration_180)? $object->decoration_180 : null),
                'objects' => $decorations,
                'idSelect' => 'id_151',
                'nameSelect' => 'name_151',
                'class' => 'select2',
                'data' => [
                    'language' => config('app.locale'),
                    'width' => '100%',
                    'error-placement' => 'select2-section-outer-container',
                    'disabled' => $action == 'update' || $action == 'store'? false : true
                ]
            ])
            @include('pulsar::includes.html.form_select_group', [
                'label' => trans_choice('hotels::pulsar.relationship', 1),
                'name' => 'relationship',
                'value' => old('relationship', isset($object->relationship_180)? $object->relationship_180 : null),
                'objects' => $relationships,
                'idSelect' => 'id_152',
                'nameSelect' => 'name_152',
                'class' => 'select2',
                'data' => [
                    'language' => config('app.locale'),
                    'width' => '100%',
                    'error-placement' => 'select2-section-outer-container',
                    'disabled' => $action == 'update' || $action == 'store'? false : true
                ]
            ])
        </div>
        <div class="col-md-6">
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans('hotels::pulsar.number_rooms'),
                'name' => 'nRooms',
                'value' => old('nRooms', isset($object->n_rooms_180)? $object->n_rooms_180 : null),
                'maxLength' => '50',
                'rangeLength' => '1,50',
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans('hotels::pulsar.number_places'),
                'name' => 'nPlaces',
                'value' => old('nPlaces', isset($object->n_places_180)? $object->n_places_180 : null),
                'maxLength' => '50',
                'rangeLength' => '1,50',
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
        </div>
    </div>

    @include('pulsar::includes.html.form_section_header', [
        'label' => trans_choice('pulsar::pulsar.company', 2),
        'icon' => 'fa fa-building'
    ])
    <div class="row">
        <div class="col-md-6">
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans_choice('hotels::pulsar.meeting_rooms', 1),
                'name' => 'nEventsRooms',
                'value' => old('nEventsRooms', isset($object->n_events_rooms_180)? $object->n_events_rooms_180 : null),
                'maxLength' => '50',
                'rangeLength' => '1,50',
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
        </div>
        <div class="col-md-6">
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans_choice('hotels::pulsar.capacity', 1),
                'name' => 'nEventsRoomsPlaces',
                'value' => old('nEventsRoomsPlaces', isset($object->n_events_rooms_places_180)? $object->n_events_rooms_places_180 : null),
                'maxLength' => '50',
                'rangeLength' => '1,50',
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
        </div>
    </div>

    @include('pulsar::includes.html.form_section_header', [
        'label' => trans('hotels::pulsar.restaurant'),
        'icon' => 'fa fa-cutlery'
    ])
    <div class="row">
        <div class="col-md-6">
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans('pulsar::pulsar.name'),
                'name' => 'restaurantName',
                'value' => old('restaurantName', isset($object->restaurant_name_180)? $object->restaurant_name_180 : null),
                'maxLength' => '100',
                'rangeLength' => '2,100',
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans('hotels::pulsar.cuisine'),
                'name' => 'cuisine',
                'value' => old('cuisine', isset($object->cuisine_171)? $object->cuisine_171 : null),
                'maxLength' => '255',
                'rangeLength' => '2,255'
            ])
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans('hotels::pulsar.special_dish'),
                'name' => 'specialDish',
                'value' => old('specialDish', isset($object->special_dish_171)? $object->special_dish_171 : null),
                'maxLength' => '255',
                'rangeLength' => '2,255'
            ])
            @include('pulsar::includes.html.form_checkbox_group', [
                'label' => trans('hotels::pulsar.terrace'),
                'name' => 'restaurantTerrace',
                'value' => 1,
                'checked' => old('restaurantTerrace', isset($object)? $object->restaurant_terrace_180 : null),
                'disabled' => $action == 'update' || $action == 'store'? false : true
            ])
        </div>
        <div class="col-md-6">
            @include('pulsar::includes.html.form_checkbox_group', [
                'label' => 'Country Chef',
                'name' => 'countryChefRestaurant',
                'value' => 1,
                'checked' => old('countryChefRestaurant', isset($object)? $object->country_chef_restaurant_180 : null),
                'disabled' => $action == 'update' || $action == 'store'? false : true
            ])
            @include('pulsar::includes.html.form_text_group', [
                'label' => 'T.C.C. URL',
                'name' => 'countryChefUrl',
                'value' => old('countryChefUrl', isset($object->country_chef_url_180)? $object->country_chef_url_180 : null),
                'maxLength' => '255',
                'rangeLength' => '2,255',
                'placeholder' => 'http://www.thecountrychef.es/',
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
            @include('pulsar::includes.html.form_select_group', [
                'label' => trans_choice('pulsar::pulsar.type', 1),
                'name' => 'restaurantType',
                'value' => old('restaurantType', isset($object->restaurant_type_180)? $object->restaurant_type_180 : null),
                'objects' => $restaurantTypes,
                'idSelect' => 'id',
                'nameSelect' => 'name',
                'class' => 'select2',
                'data' => [
                    'language' => config('app.locale'),
                    'width' => '100%',
                    'error-placement' => 'select2-section-outer-container',
                    'minimum-results-for-search' => -1,
                    'disabled' => $action == 'update' || $action == 'store'? false : true
                ]
            ])
        </div>
    </div>

    @include('pulsar::includes.html.form_section_header', [
        'label' => trans('hotels::pulsar.booking_data'),
        'icon' => 'fa fa-bed'
    ])
    @include('pulsar::includes.html.form_text_group', [
        'labelSize' => 1,
        'fieldSize' => 5,
        'label' => trans('hotels::pulsar.booking_email'),
        'name' => 'bookingEmail',
        'value' => old('bookingEmail', isset($object->booking_email_180)? $object->booking_email_180 : null),
        'maxLength' => '50',
        'rangeLength' => '2,50',
        'type' => 'email',
        'readOnly' => $action == 'update' || $action == 'store'? false : true
    ])
    @include('pulsar::includes.html.form_text_group', [
        'labelSize' => 1,
        'fieldSize' => 11,
        'label' => trans('hotels::pulsar.booking_url'),
        'name' => 'bookingUrl',
        'value' => old('bookingUrl', isset($object->booking_url_180)? $object->booking_url_180 : null),
        'maxLength' => '100',
        'rangeLength' => '2,100',
        'placeholder' => 'http://www.booking.com/',
        'readOnly' => $action == 'update' || $action == 'store'? false : true
    ])

    @include('pulsar::includes.html.form_section_header', [
        'label' => trans_choice('pulsar::pulsar.geolocation', 1),
        'icon' => 'fa fa-map-signs'
    ])
    @include('pulsar::includes.html.form_text_group', [
        'labelSize' => 1,
        'fieldSize' => 11,
        'label' => trans_choice('pulsar::pulsar.address', 1),
        'name' => 'address',
        'value' => old('address', isset($object->address_180)? $object->address_180 : null),
        'maxLength' => '150',
        'rangeLength' => '2,150',
        'readOnly' => $action == 'update' || $action == 'store'? false : true
    ])
    <div class="row">
        <div class="col-md-6">
            @include('pulsar::includes.html.form_select_group', [
                'label' => trans_choice('pulsar::pulsar.country', 1),
                'id' => 'country',
                'name' => 'country',
                'idSelect' => 'id_002',
                'nameSelect' => 'name_002',
                'class' => 'col-md-12 select2',
                'required' => true,
                'style' => 'width:100%',
                'data' => [
                    'language' => config('app.locale'),
                    'error-placement' => 'select2-country-outer-container',
                    'disabled' => $action == 'update' || $action == 'store'? false : true
                ]
            ])
            @include('pulsar::includes.html.form_select_group', [
                'containerId' => 'territorialArea1Wrapper',
                'labelId' => 'territorialArea1Label',
                'name' => 'territorialArea1',
                'class' => 'col-md-12 select2',
                'style' => 'width:100%',
                'data' => [
                    'language' => config('app.locale'),
                    'disabled' => $action == 'update' || $action == 'store'? false : true
                ]
            ])
            @include('pulsar::includes.html.form_select_group', [
                'containerId' => 'territorialArea2Wrapper',
                'labelId' => 'territorialArea2Label',
                'name' => 'territorialArea2',
                'class' => 'col-md-12 select2',
                'style' => 'width:100%',
                'data' => [
                    'language' => config('app.locale'),
                    'disabled' => $action == 'update' || $action == 'store'? false : true
                ]
            ])
            @include('pulsar::includes.html.form_select_group', [
                'containerId' => 'territorialArea3Wrapper',
                'labelId' => 'territorialArea3Label',
                'name' => 'territorialArea3',
                'class' => 'col-md-12 select2',
                'style' => 'width:100%',
                'data' => [
                    'language' => config('app.locale'),
                    'disabled' => $action == 'update' || $action == 'store'? false : true
                ]
            ])
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans('pulsar::pulsar.cp'),
                'name' => 'cp',
                'value' => old('cp', isset($object->cp_180)? $object->cp_180 : null),
                'maxLength' => '10',
                'rangeLength' => '2,10',
                'fieldSize' => 4,
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans('pulsar::pulsar.locality'),
                'name' => 'locality',
                'value' => old('locality', isset($object->locality_180)? $object->locality_180 : null),
                'maxLength' => '100',
                'rangeLength' => '2,100',
                'fieldSize' => 6,
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans('pulsar::pulsar.latitude'),
                'name' => 'latitude',
                'value' => old('latitude', isset($object->latitude_180)? $object->latitude_180 : null),
                'maxLength' => '100',
                'rangeLength' => '2,100',
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
            @include('pulsar::includes.html.form_text_group', [
                'label' => trans('pulsar::pulsar.longitude'),
                'name' => 'longitude',
                'value' => old('longitude', isset($object->longitude_180)? $object->longitude_180 : null),
                'maxLength' => '100',
                'rangeLength' => '2,100',
                'readOnly' => $action == 'update' || $action == 'store'? false : true
            ])
        </div>
        <div class="col-md-6">
            <div id="locationMapWrapper"></div>
        </div>
    </div>

    @include('pulsar::includes.html.form_section_header', [
        'label' => trans_choice('pulsar::pulsar.custom_field', 2),
        'icon' => 'fa fa-align-left',
        'containerId' => 'headerCustomFields'
    ])
    <div id="wrapperCustomFields"></div>
    <!-- ./hotels::hotels.create -->
@stop

@section('box_tab2')
    @include('pulsar::includes.html.form_text_group', [
        'label' => trans('hotels::pulsar.construction'),
        'name' => 'construction',
        'value' => old('construction', isset($object->construction_171)? $object->construction_171 : null),
        'maxLength' => '255',
        'rangeLength' => '2,255'
    ])
    @include('pulsar::includes.html.form_text_group', [
        'label' => trans('hotels::pulsar.description_title'),
        'name' => 'descriptionTitle',
        'value' => old('descriptionTitle', isset($object->description_title_171)? $object->description_title_171 : null),
        'maxLength' => '100',
        'rangeLength' => '2,100'
    ])
    @include('pulsar::includes.html.form_wysiwyg_group', [
        'label' => trans_choice('pulsar::pulsar.description', 1),
        'name' => 'description',
        'value' => old('description', isset($object->description_171)? $object->description_171 : null)
    ])
    @include('pulsar::includes.html.form_wysiwyg_group', [
        'label' => trans('hotels::pulsar.activities'),
        'name' => 'activities',
        'value' => old('activities', isset($object->activities_171)? $object->activities_171 : null)
    ])
    @include('pulsar::includes.html.form_wysiwyg_group', [
        'label' => trans('hotels::pulsar.indications'),
        'name' => 'indications',
         'value' => old('indications', isset($object->indications_171)? $object->indications_171 : null)
    ])
    @include('pulsar::includes.html.form_wysiwyg_group', [
        'label' => trans('hotels::pulsar.interest_points'),
        'name' => 'interestPoints',
        'value' => old('interestPoints', isset($object->interest_points_171)? $object->interest_points_171 : null)
    ])
@stop

@section('box_tab3')
    @include('pulsar::includes.html.attachment', [
        'action'            => 'create',
        'routesConfigFile'  => 'hotels'])
@stop

@section('endBody')
    <!--TODO: Implementar botón para añadir fotografías desde la librería-->
    <div id="attachment-library-mask">
        <div id="attachment-library-content">
            {{ trans('pulsar::pulsar.drag_files') }}
        </div>
    </div>
@stop