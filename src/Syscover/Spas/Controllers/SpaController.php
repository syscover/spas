<?php namespace Syscover\Spas\Controllers;

use Illuminate\Support\Facades\Hash;
use Syscover\Hotels\Models\Decoration;
use Syscover\Hotels\Models\Environment;
use Syscover\Hotels\Models\HotelProduct;
use Syscover\Hotels\Models\Publication;
use Syscover\Hotels\Models\Relationship;
use Syscover\Hotels\Models\Service;
use Syscover\Market\Models\Product;
use Syscover\Pulsar\Controllers\Controller;
use Syscover\Pulsar\Libraries\AttachmentLibrary;
use Syscover\Pulsar\Libraries\CustomFieldResultLibrary;
use Syscover\Pulsar\Models\Attachment;
use Syscover\Pulsar\Models\AttachmentFamily;
use Syscover\Pulsar\Models\CustomFieldGroup;
use Syscover\Pulsar\Traits\TraitController;
use Syscover\Spas\Models\Spa;
use Syscover\Spas\Models\SpaLang;

/**
 * Class SpaController
 * @package Syscover\Spas\Controllers
 */

class SpaController extends Controller {

    use TraitController;

    protected $routeSuffix  = 'spa';
    protected $folder       = 'spa';
    protected $package      = 'spas';
    protected $aColumns     = ['id_180', 'name_001', 'name_002', 'name_003', 'name_180', ['data' => 'active_180', 'type' => 'active']];
    protected $nameM        = 'name_180';
    protected $model        = Spa::class;
    protected $langModel    = SpaLang::class;
    protected $icon         = 'fa fa-tint';
    protected $objectTrans  = 'spa';

    public function indexCustom($parameters)
    {
        $parameters['urlParameters']['lang']    = session('baseLang')->id_001;
        // init record on tap 4
        $parameters['urlParameters']['tab']     = 2;

        return $parameters;
    }

    public function customActionUrlParameters($actionUrlParameters, $parameters)
    {
        $actionUrlParameters['tab'] = 2;

        return $actionUrlParameters;
    }

    public function createCustomRecord($parameters)
    {
        $parameters['attachmentFamilies']   = AttachmentFamily::getAttachmentFamilies(['resource_015' => 'hotels-hotel']);
        $parameters['customFieldGroups']    = CustomFieldGroup::where('resource_025', 'hotels-hotel')->get();
        $parameters['attachmentsInput']     = json_encode([]);

        if(isset($parameters['id']))
        {
            // get attachments from base lang
            $attachments = AttachmentLibrary::getRecords($this->package, 'spas-spa', $parameters['id'], session('baseLang')->id_001, true);

            // merge parameters and attachments array
            $parameters  = array_merge($parameters, $attachments);
        }

        return $parameters;
    }

    public function checkSpecialRulesToStore($parameters)
    {
        if(isset($parameters['id']))
        {
            $hotel = Hotel::find($parameters['id']);

            $parameters['specialRules']['emailRule']    = $this->request->input('email') == $hotel->email_180? true : false;
            $parameters['specialRules']['userRule']     = $this->request->input('user') == $hotel->user_180? true : false;
            $parameters['specialRules']['passRule']     = $this->request->input('password') == ""? true : false;
        }

        return $parameters;
    }

    public function storeCustomRecord($parameters)
    {
        if(!$this->request->has('id'))
        {
            // create new hotel
            $hotel = Hotel::create([
                'custom_field_group_180'                        => empty($this->request->input('customFieldGroup'))? null : $this->request->input('customFieldGroup'),
                'name_180'                                      => $this->request->input('name'),
                'slug_180'                                      => $this->request->input('slug'),
                'web_180'                                       => $this->request->input('web'),
                'web_url_180'                                   => $this->request->input('webUrl'),
                'contact_180'                                   => $this->request->input('contact'),
                'email_180'                                     => $this->request->input('email'),
                'booking_email_180'                             => $this->request->input('bookingEmail'),
                'phone_180'                                     => $this->request->input('phone'),
                'mobile_180'                                    => $this->request->input('mobile'),
                'fax_180'                                       => $this->request->input('fax'),
                'environment_180'                               => $this->request->has('environment') ? $this->request->input('environment') : null,
                'decoration_180'                                => $this->request->has('decoration') ? $this->request->input('decoration') : null,
                'relationship_180'                              => $this->request->has('relationship') ? $this->request->input('relationship') : null,
                'n_rooms_180'                                   => $this->request->input('nRooms'),
                'n_places_180'                                  => $this->request->input('nPlaces'),
                'n_events_rooms_180'                            => $this->request->input('nEventsRooms'),
                'n_events_rooms_places_180'                     => $this->request->input('nEventsRoomsPlaces'),
                'user_180'                                      => $this->request->input('user'),
                'password_180'                                  => Hash::make($this->request->input('password')),
                'active_180'                                    => $this->request->has('active'),
                'country_180'                                   => $this->request->input('country'),
                'territorial_area_1_180'                        => $this->request->has('territorialArea1') ? $this->request->input('territorialArea1') : null,
                'territorial_area_2_180'                        => $this->request->has('territorialArea2') ? $this->request->input('territorialArea2') : null,
                'territorial_area_3_180'                        => $this->request->has('territorialArea3') ? $this->request->input('territorialArea3') : null,
                'cp_180'                                        => $this->request->input('cp'),
                'locality_180'                                  => $this->request->input('locality'),
                'address_180'                                   => $this->request->input('address'),
                'latitude_180'                                  => str_replace(',', '', $this->request->input('latitude')),   // replace ',' character, can contain this character that damage script
                'longitude_180'                                 => str_replace(',', '', $this->request->input('longitude')),  // replace ',' character, can contain this character that damage script
                'booking_url_180'                               => $this->request->input('bookingUrl'),
                'country_chef_restaurant_180'                   => $this->request->has('countryChefRestaurant'),
                'country_chef_url_180'                          => $this->request->input('countryChefUrl'),
                'restaurant_name_180'                           => $this->request->input('restaurantName'),
                'restaurant_type_180'                           => $this->request->has('restaurantType')? $this->request->input('restaurantType') : null,
                'restaurant_terrace_180'                        => $this->request->has('restaurantTerrace'),
                'billing_name_180'                              => $this->request->input('billingName'),
                'billing_surname_180'                           => $this->request->input('billingSurname'),
                'billing_company_name_180'                      => $this->request->input('billingCompanyName'),
                'billing_tin_180'                               => $this->request->input('billingTin'),
                'billing_country_180'                           => $this->request->has('billingCountry')? $this->request->input('billingCountry') : null,
                'billing_territorial_area_1_180'                => $this->request->has('billingTerritorialArea1')? $this->request->input('billingTerritorialArea1') : null,
                'billing_territorial_area_2_180'                => $this->request->has('billingTerritorialArea2')? $this->request->input('billingTerritorialArea2') : null,
                'billing_territorial_area_3_180'                => $this->request->has('billingTerritorialArea3')? $this->request->input('billingTerritorialArea3') : null,
                'billing_cp_180'                                => $this->request->input('billingCp'),
                'billing_locality_180'                          => $this->request->input('billingLocality'),
                'billing_address_180'                           => $this->request->input('billingAddress'),
                'billing_phone_180'                             => $this->request->input('billingPhone'),
                'billing_email_180'                             => $this->request->input('billingEmail'),
                'billing_iban_country_180'                      => $this->request->input('billingIbanCountry'),
                'billing_iban_check_digits_180'                 => $this->request->input('billingIbanCheckDigits'),
                'billing_iban_basic_bank_account_number_180'    => $this->request->input('billingIbanBasicBankAccountNumber'),
                'billing_bic_180'                               => $this->request->input('billingBic')
            ]);

            $id     = $hotel->id_180;
            $idLang = null;

            // publications
            if(is_array($this->request->input('published')))
                $hotel->getPublications()->sync($this->request->input('published'));

            // services
            if(is_array($this->request->input('services')))
                $hotel->getServices()->sync($this->request->input('services'));
        }
        else
        {
            // create hotel language
            $id     = $this->request->input('id');
            $idLang = $id;
        }

        Hotel::where('id_180', $id)->update([
            'data_lang_180'                 => Hotel::addLangDataRecord($this->request->input('lang'), $idLang)
        ]);

        HotelLang::create([
            'id_171'                        => $id,
            'lang_171'                      => $this->request->input('lang'),
            'cuisine_171'                   => $this->request->input('cuisine'),
            'special_dish_171'              => $this->request->input('specialDish'),
            'indications_171'               => $this->request->input('indications'),
            'interest_points_171'           => $this->request->input('interestPoints'),
            'environment_description_171'   => $this->request->input('environmentDescription'),
            'construction_171'              => $this->request->input('construction'),
            'activities_171'                => $this->request->input('activities'),
            'description_title_171'         => $this->request->input('descriptionTitle'),
            'description_171'               => $this->request->input('description')
        ]);

        // set hotel products
        $hotelProducts = [];
        $products = json_decode($this->request->input('products'));
        foreach($products as $product)
        {
            $hotelProducts[] = [
                'hotel_177'         => $id,
                'product_177'       => $product,
                'lang_177'          => $this->request->input('lang'),
                'description_177'   => $this->request->input('d' . $product)
            ];
        }

        if(count($hotelProducts) > 0)
            HotelProduct::insert($hotelProducts);

        // set attachments
        $attachments = json_decode($this->request->input('attachments'));
        AttachmentLibrary::storeAttachments($attachments, 'hotels', 'hotels-hotel', $id, $this->request->input('lang'));

        // set custom fields
        if(!empty($this->request->input('customFieldGroup')))
            CustomFieldResultLibrary::storeCustomFieldResults($this->request, $this->request->input('customFieldGroup'), 'hotels-hotel', $id, $this->request->input('lang'));
    }

    public function editCustomRecord($parameters)
    {
        $parameters['services']             = Service::where('lang_153', $parameters['lang']->id_001)->get();
        $parameters['environments']         = Environment::where('lang_150', $parameters['lang']->id_001)->get();
        $parameters['decorations']          = Decoration::where('lang_151', $parameters['lang']->id_001)->get();
        $parameters['relationships']        = Relationship::where('lang_152', $parameters['lang']->id_001)->get();
        $parameters['publications']         = Publication::all();
        $parameters['restaurantTypes']      = array_map(function($object){
            $object->name = trans($object->name);
            return $object;
        }, config('hotels.restaurantTypes'));

        // get attachments elements
        $attachments = AttachmentLibrary::getRecords('hotels', 'hotels-hotel', $parameters['object']->id_180, $parameters['lang']->id_001);

        $parameters['products']             = Product::builder()->where('active_111',true)->where('lang_112', $parameters['lang']->id_001)->get();

        // get attachments products with photo list
        $parameters['attachmentsProducts']  = Attachment::builder()
            ->where('lang_016', $parameters['lang']->id_001)
            ->where('resource_016', 'market-product')
            ->where('family_016', config('hotels.idAttachmentsFamily.productList'))
            ->get()
            ->keyBy('object_016');

        // merge parameters and attachments array
        $parameters['customFieldGroups']    = CustomFieldGroup::builder()->where('resource_025', 'hotels-hotel')->get();
        $parameters['attachmentFamilies']   = AttachmentFamily::getAttachmentFamilies(['resource_015' => 'hotels-hotel']);
        $parameters                         = array_merge($parameters, $attachments);

        // get hotel products
        $parameters['hotelProducts']        = $parameters['object']->getHotelProducts->keyBy('product_177');
        $parameters['hotelProductsIds']     = json_encode($parameters['hotelProducts']->keys()->map(function($item, $key) { return strval($item); }));

        return $parameters;
    }

    public function checkSpecialRulesToUpdate($parameters)
    {
        $hotel = Hotel::find($parameters['id']);

        $parameters['specialRules']['emailRule']    = $this->request->input('email') == $hotel->email_180? true : false;
        $parameters['specialRules']['userRule']     = $this->request->input('user') == $hotel->user_180? true : false;
        $parameters['specialRules']['passRule']     = $this->request->input('password') == ""? true : false;

        return $parameters;
    }

    public function updateCustomRecord($parameters)
    {
        $hotel = [
            'custom_field_group_180'                        => empty($this->request->input('customFieldGroup'))? null : $this->request->input('customFieldGroup'),
            'name_180'                                      => $this->request->input('name'),
            'slug_180'                                      => $this->request->input('slug'),
            'web_180'                                       => $this->request->input('web'),
            'web_url_180'                                   => $this->request->input('webUrl'),
            'contact_180'                                   => $this->request->input('contact'),
            'email_180'                                     => $this->request->input('email'),
            'booking_email_180'                             => $this->request->input('bookingEmail'),
            'phone_180'                                     => $this->request->input('phone'),
            'mobile_180'                                    => $this->request->input('mobile'),
            'fax_180'                                       => $this->request->input('fax'),
            'environment_180'                               => $this->request->has('environment')? $this->request->input('environment') : null,
            'decoration_180'                                => $this->request->has('decoration')? $this->request->input('decoration') : null,
            'relationship_180'                              => $this->request->has('relationship')? $this->request->input('relationship') : null,
            'n_rooms_180'                                   => $this->request->input('nRooms'),
            'n_places_180'                                  => $this->request->input('nPlaces'),
            'n_events_rooms_180'                            => $this->request->input('nEventsRooms'),
            'n_events_rooms_places_180'                     => $this->request->input('nEventsRoomsPlaces'),
            'user_180'                                      => $this->request->input('user'),
            'active_180'                                    => $this->request->has('active'),
            'country_180'                                   => $this->request->input('country'),
            'territorial_area_1_180'                        => $this->request->has('territorialArea1')? $this->request->input('territorialArea1') : null,
            'territorial_area_2_180'                        => $this->request->has('territorialArea2')? $this->request->input('territorialArea2') : null,
            'territorial_area_3_180'                        => $this->request->has('territorialArea3')? $this->request->input('territorialArea3') : null,
            'cp_180'                                        => $this->request->input('cp'),
            'locality_180'                                  => $this->request->input('locality'),
            'address_180'                                   => $this->request->input('address'),
            'latitude_180'                                  => str_replace(',', '', $this->request->input('latitude')),       // replace ',' character, can contain this character that damage script
            'longitude_180'                                 => str_replace(',', '', $this->request->input('longitude')),      // replace ',' character, can contain this character that damage script
            'booking_url_180'                               => $this->request->input('bookingUrl'),
            'country_chef_restaurant_180'                   => $this->request->has('countryChefRestaurant'),
            'country_chef_url_180'                          => $this->request->input('countryChefUrl'),
            'restaurant_name_180'                           => $this->request->input('restaurantName'),
            'restaurant_type_180'                           => $this->request->has('restaurantType')? $this->request->input('restaurantType') : null,
            'restaurant_terrace_180'                        => $this->request->has('restaurantTerrace'),
            'billing_name_180'                              => $this->request->input('billingName'),
            'billing_surname_180'                           => $this->request->input('billingSurname'),
            'billing_company_name_180'                      => $this->request->input('billingCompanyName'),
            'billing_tin_180'                               => $this->request->input('billingTin'),
            'billing_country_180'                           => $this->request->has('billingCountry')? $this->request->input('billingCountry') : null,
            'billing_territorial_area_1_180'                => $this->request->has('billingTerritorialArea1')? $this->request->input('billingTerritorialArea1') : null,
            'billing_territorial_area_2_180'                => $this->request->has('billingTerritorialArea2')? $this->request->input('billingTerritorialArea2') : null,
            'billing_territorial_area_3_180'                => $this->request->has('billingTerritorialArea3')? $this->request->input('billingTerritorialArea3') : null,
            'billing_cp_180'                                => $this->request->input('billingCp'),
            'billing_locality_180'                          => $this->request->input('billingLocality'),
            'billing_address_180'                           => $this->request->input('billingAddress'),
            'billing_phone_180'                             => $this->request->input('billingPhone'),
            'billing_email_180'                             => $this->request->input('billingEmail'),
            'billing_iban_country_180'                      => $this->request->input('billingIbanCountry'),
            'billing_iban_check_digits_180'                 => $this->request->input('billingIbanCheckDigits'),
            'billing_iban_basic_bank_account_number_180'    => $this->request->input('billingIbanBasicBankAccountNumber'),
            'billing_bic_180'                               => $this->request->input('billingBic')
        ];

        if($parameters['specialRules']['emailRule'])  $hotel['email_180']       = $this->request->input('email');
        if($parameters['specialRules']['userRule'])   $hotel['user_180']        = $this->request->input('user');
        if(!$parameters['specialRules']['passRule'])  $hotel['password_180']    = Hash::make($this->request->input('password'));

        Hotel::where('id_180', $parameters['id'])->update($hotel);

        $hotel = Hotel::find($parameters['id']);

        // publications
        if(is_array($this->request->input('published')))
        {
            $hotel->getPublications()->sync($this->request->input('published'));
        }
        else
        {
            $hotel->getPublications()->detach();
        }

        // services
        if(is_array($this->request->input('services')))
        {
            $hotel->getServices()->sync($this->request->input('services'));
        }
        else
        {
            $hotel->getServices()->detach();
        }

        HotelLang::where('id_171', $parameters['id'])->where('lang_171', $this->request->input('lang'))->update([
            'cuisine_171'                   => $this->request->input('cuisine'),
            'special_dish_171'              => $this->request->input('specialDish'),
            'indications_171'               => $this->request->input('indications'),
            'interest_points_171'           => $this->request->input('interestPoints'),
            'environment_description_171'   => $this->request->input('environmentDescription'),
            'construction_171'              => $this->request->input('construction'),
            'activities_171'                => $this->request->input('activities'),
            'description_title_171'         => $this->request->input('descriptionTitle'),
            'description_171'               => $this->request->input('description')
        ]);

        // set hotel products
        HotelProduct::where('hotel_177', $parameters['id'])->where('lang_177', $this->request->input('lang'))->delete();
        $hotelProducts = [];
        $products = json_decode($this->request->input('products'));
        foreach($products as $product)
        {
            $hotelProducts[] = [
                'hotel_177'         => $parameters['id'],
                'product_177'       => $product,
                'lang_177'          => $this->request->input('lang'),
                'description_177'   => $this->request->input('d' . $product)
            ];
        }

        if(count($hotelProducts) > 0)
            HotelProduct::insert($hotelProducts);

        // set custom fields
        if(!empty($this->request->input('customFieldGroup')))
        {
            CustomFieldResultLibrary::deleteCustomFieldResults('hotels-hotel', $parameters['id'], $this->request->input('lang'));
            CustomFieldResultLibrary::storeCustomFieldResults($this->request, $this->request->input('customFieldGroup'), 'hotels-hotel', $parameters['id'], $this->request->input('lang'));
        }
    }

    public function deleteCustomRecord($object)
    {
        // delete all attachments
        AttachmentLibrary::deleteAttachment($this->package, 'hotels-hotel', $object->id_180);
    }

    public function deleteCustomTranslationRecord($object)
    {
        // delete all attachments from lang object
        AttachmentLibrary::deleteAttachment($this->package, 'hotels-hotel', $object->id_171, $object->lang_171);
    }

    public function deleteCustomRecordsSelect($ids)
    {
        foreach($ids as $id)
        {
            AttachmentLibrary::deleteAttachment($this->package, 'hotels-hotel', $id);
        }
    }

    public function apiCheckSlug()
    {
        return response()->json([
            'status'    => 'success',
            'slug'      => Hotel::checkSlug('slug_180', $this->request->input('slug'), $this->request->input('id'))
        ]);
    }
}