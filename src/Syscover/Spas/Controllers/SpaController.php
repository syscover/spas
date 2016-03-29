<?php namespace Syscover\Spas\Controllers;

use Illuminate\Support\Facades\Hash;
use Syscover\Hotels\Models\Hotel;
use Syscover\Pulsar\Controllers\Controller;
use Syscover\Pulsar\Libraries\AttachmentLibrary;
use Syscover\Pulsar\Libraries\CustomFieldResultLibrary;
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

    public function customIndex($parameters)
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
        $parameters['attachmentFamilies']   = AttachmentFamily::getAttachmentFamilies(['resource_015' => 'spas-spa']);
        $parameters['customFieldGroups']    = CustomFieldGroup::where('resource_025', 'spas-spa')->get();
        $parameters['attachmentsInput']     = json_encode([]);
        $parameters['hotels']               = Hotel::builder()->where('active_170', true)->get();

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
            $spa = Spa::find($parameters['id']);

            $parameters['specialRules']['emailRule']    = $this->request->input('email') == $spa->email_180? true : false;
        }

        return $parameters;
    }

    public function storeCustomRecord($parameters)
    {
        if(!$this->request->has('id'))
        {
            // create new spa
            $spa = Spa::create([
                'custom_field_group_180'                        => $this->request->has('customFieldGroup')? $this->request->input('customFieldGroup') : null,
                'hotel_id_180'                                  => $this->request->has('hotel')? $this->request->input('hotel') : null,
                'name_180'                                      => $this->request->input('name'),
                'slug_180'                                      => $this->request->input('slug'),
                'web_180'                                       => $this->request->input('web'),
                'web_url_180'                                   => $this->request->input('webUrl'),
                'contact_180'                                   => $this->request->input('contact'),
                'email_180'                                     => $this->request->input('email'),
                'phone_180'                                     => $this->request->input('phone'),
                'mobile_180'                                    => $this->request->input('mobile'),
                'fax_180'                                       => $this->request->input('fax'),
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
            ]);

            $id     = $spa->id_180;
            $idLang = null;
        }
        else
        {
            // create spa language
            $id     = $this->request->input('id');
            $idLang = $id;
        }

        Spa::where('id_180', $id)->update([
            'data_lang_180'                 => Spa::addLangDataRecord($this->request->input('lang'), $idLang)
        ]);

        SpaLang::create([
            'id_181'                        => $id,
            'lang_181'                      => $this->request->input('lang'),
            'description_title_181'         => $this->request->has('descriptionTitle')? $this->request->input('descriptionTitle') : null,
            'description_181'               => $this->request->has('description')? $this->request->input('description') : null,
            'treatments_181'                => $this->request->has('treatments')? $this->request->input('treatments') : null,
        ]);

        // set attachments
        $attachments = json_decode($this->request->input('attachments'));
        AttachmentLibrary::storeAttachments($attachments, $this->package, 'spas-spa', $id, $this->request->input('lang'));

        // set custom fields
        if(!empty($this->request->input('customFieldGroup')))
            CustomFieldResultLibrary::storeCustomFieldResults($this->request, $this->request->input('customFieldGroup'), 'spas-spa', $id, $this->request->input('lang'));
    }

    public function editCustomRecord($parameters)
    {
        // get attachments elements
        $attachments = AttachmentLibrary::getRecords('spas', 'spas-spa', $parameters['object']->id_180, $parameters['lang']->id_001);

        // merge parameters and attachments array
        $parameters['attachmentFamilies']   = AttachmentFamily::getAttachmentFamilies(['resource_015' => 'spas-spa']);
        $parameters['customFieldGroups']    = CustomFieldGroup::builder()->where('resource_025', 'spas-spa')->get();
        $parameters['hotels']               = Hotel::builder()->where('active_170', true)->get();

        $parameters                         = array_merge($parameters, $attachments);

        return $parameters;
    }

    public function checkSpecialRulesToUpdate($parameters)
    {
        $spa = Spa::find($parameters['id']);

        $parameters['specialRules']['emailRule']    = $this->request->input('email') == $spa->email_180? true : false;

        return $parameters;
    }

    public function updateCustomRecord($parameters)
    {
        $spa = [
            'custom_field_group_180'                        => $this->request->has('customFieldGroup')? $this->request->input('customFieldGroup') : null,
            'hotel_id_180'                                  => $this->request->has('hotel')? $this->request->input('hotel') : null,
            'name_180'                                      => $this->request->input('name'),
            'slug_180'                                      => $this->request->input('slug'),
            'web_180'                                       => $this->request->input('web'),
            'web_url_180'                                   => $this->request->input('webUrl'),
            'contact_180'                                   => $this->request->input('contact'),
            'email_180'                                     => $this->request->input('email'),
            'phone_180'                                     => $this->request->input('phone'),
            'mobile_180'                                    => $this->request->input('mobile'),
            'fax_180'                                       => $this->request->input('fax'),
            'active_180'                                    => $this->request->has('active'),
            'country_180'                                   => $this->request->input('country'),
            'territorial_area_1_180'                        => $this->request->has('territorialArea1') ? $this->request->input('territorialArea1') : null,
            'territorial_area_2_180'                        => $this->request->has('territorialArea2') ? $this->request->input('territorialArea2') : null,
            'territorial_area_3_180'                        => $this->request->has('territorialArea3') ? $this->request->input('territorialArea3') : null,
            'cp_180'                                        => $this->request->input('cp'),
            'locality_180'                                  => $this->request->input('locality'),
            'address_180'                                   => $this->request->input('address'),
            'latitude_180'                                  => str_replace(',', '', $this->request->input('latitude')),   // replace ',' character, can contain this character that damage script
            'longitude_180'                                 => str_replace(',', '', $this->request->input('longitude')),  // replace ',' character, can contain this character that damage script)
        ];

        if($parameters['specialRules']['emailRule'])  $hotel['email_180']       = $this->request->input('email');

        Spa::where('id_180', $parameters['id'])->update($spa);

        // por si hiciera falta a futuro, sinconizar el spa con otros elementos,
        // haría falta el objedo actualizado
        //$spa = Spa::find($parameters['id']);

        SpaLang::where('id_181', $parameters['id'])->where('lang_181', $this->request->input('lang'))->update([
            'description_title_181'         => $this->request->has('descriptionTitle')? $this->request->input('descriptionTitle') : null,
            'description_181'               => $this->request->has('description')? $this->request->input('description') : null,
            'treatments_181'                => $this->request->has('treatments')? $this->request->input('treatments') : null,
        ]);

        // set custom fields
        if(!empty($this->request->input('customFieldGroup')))
        {
            CustomFieldResultLibrary::deleteCustomFieldResults('spas-spa', $parameters['id'], $this->request->input('lang'));
            CustomFieldResultLibrary::storeCustomFieldResults($this->request, $this->request->input('customFieldGroup'), 'spas-spa', $parameters['id'], $this->request->input('lang'));
        }
    }

    public function deleteCustomRecord($object)
    {
        // delete all attachments
        AttachmentLibrary::deleteAttachment($this->package, 'spas-spa', $object->id_180);
    }

    public function deleteCustomTranslationRecord($object)
    {
        // delete all attachments from lang object
        AttachmentLibrary::deleteAttachment($this->package, 'spas-spa', $object->id_181, $object->lang_181);
    }

    public function deleteCustomRecordsSelect($ids)
    {
        foreach($ids as $id)
        {
            AttachmentLibrary::deleteAttachment($this->package, 'spas-spa', $id);
        }
    }

    public function apiCheckSlug()
    {
        return response()->json([
            'status'    => 'success',
            'slug'      => Spa::checkSlug('slug_180', $this->request->input('slug'), $this->request->input('id'))
        ]);
    }
}