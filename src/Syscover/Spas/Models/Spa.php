<?php namespace Syscover\Spas\Models;

use Syscover\Pulsar\Models\Model;
use Illuminate\Support\Facades\Validator;
use Syscover\Pulsar\Traits\TraitModel;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * Class Spa
 *
 * Model with properties
 * <br><b>[id, name, slug, web, web_url, contact, email, phone, mobile, fax, active, country, territorial_area_1, territorial_area_2, territorial_area_3, cp, locality, address, latitude, longitude, data_lang, data]</b>
 *
 * @package     Syscover\Hotels\Models
 */

class Spa extends Model {

    use TraitModel;
    use Eloquence, Mappable;

	protected $table        = '007_180_hotel';
    protected $primaryKey   = 'id_180';
    protected $suffix        = '180';
    public $timestamps      = false;
    protected $fillable     = ['id_180', 'custom_field_group_180', 'name_180', 'slug_180', 'web_180', 'web_url_180', 'contact_180', 'email_180', 'phone_180', 'mobile_180', 'fax_180', 'environment_180', 'decoration_180', 'relationship_180', 'n_rooms_180', 'n_places_180', 'n_events_rooms_180', 'n_events_rooms_places_180', 'user_180', 'password_180', 'active_180', 'country_180', 'territorial_area_1_180', 'territorial_area_2_180', 'territorial_area_3_180', 'cp_180', 'locality_180', 'address_180', 'latitude_180', 'longitude_180', 'booking_url_180', 'booking_email_180', 'country_chef_restaurant_180', 'country_chef_url_180', 'restaurant_name_180', 'restaurant_terrace_180', 'restaurant_type_180', 'billing_name_180', 'billing_surname_180', 'billing_company_name_180', 'billing_tin_180', 'billing_country_180', 'billing_territorial_area_1_180', 'billing_territorial_area_2_180', 'billing_territorial_area_3_180', 'billing_cp_180', 'billing_locality_180', 'billing_address_180', 'billing_phone_180', 'billing_email_180', 'billing_iban_country_180', 'billing_iban_check_digits_180', 'billing_iban_basic_bank_account_number_180', 'billing_bic_180', 'data_lang_180', 'data_180'];
    protected $maps         = [];
    protected $relationMaps = [
        'lang'          => \Syscover\Pulsar\Models\Lang::class,
        'hotel_lang'    => \Syscover\Hotels\Models\HotelLang::class,
        'country'       => \Syscover\Pulsar\Models\Country::class
    ];
    private static $rules   = [
        'name'      => 'required|between:2,100',
        'email'     => 'required|between:2,50|email|unique:007_180_hotel,email_180',
        'user'      => 'required|between:2,50|unique:007_180_hotel,user_180',
        'password'  => 'required|between:4,50|same:repassword'
    ];

    public static function validate($data, $specialRules = [])
    {
        if(isset($specialRules['emailRule']) && $specialRules['emailRule']) static::$rules['email'] = 'required|between:2,50|email';
        if(isset($specialRules['userRule']) && $specialRules['userRule']) static::$rules['user'] = 'required|between:2,50';
        if(isset($specialRules['passRule']) && $specialRules['passRule']) static::$rules['password'] = '';

        return Validator::make($data, static::$rules);
	}

    /**
     * @param   \Sofa\Eloquence\Builder     $query
     * @return  mixed
     */
    public function scopeBuilder($query)
    {
        return $query->join('007_171_hotel_lang', '007_180_hotel.id_180', '=', '007_171_hotel_lang.id_171')
            ->join('001_001_lang', '007_171_hotel_lang.lang_171', '=', '001_001_lang.id_001')
            ->join('001_002_country', function ($join) {
                $join->on('007_180_hotel.country_180', '=', '001_002_country.id_002')
                    ->on('001_002_country.lang_002', '=', '001_001_lang.id_001');
            })
            ->leftJoin('001_003_territorial_area_1', '007_180_hotel.territorial_area_1_180', '=', '001_003_territorial_area_1.id_003')
            ->leftJoin('001_004_territorial_area_2', '007_180_hotel.territorial_area_2_180', '=', '001_004_territorial_area_2.id_004')
            ->leftJoin('007_150_environment', function($join){
                $join->on('007_180_hotel.environment_180', '=', '007_150_environment.id_150')
                    ->on('007_150_environment.lang_150', '=', '007_171_hotel_lang.lang_171');
            })
            ->leftJoin('007_151_decoration', function($join){
                $join->on('007_180_hotel.decoration_180', '=', '007_151_decoration.id_151')
                    ->on('007_151_decoration.lang_151', '=', '007_171_hotel_lang.lang_171');
            })
            ->leftJoin('007_152_relationship', function($join){
                $join->on('007_180_hotel.relationship_180', '=', '007_152_relationship.id_152')
                    ->on('007_152_relationship.lang_152', '=', '007_171_hotel_lang.lang_171');
            });
    }

    /**
     * @param   \Sofa\Eloquence\Builder   $query
     * @param   array                     $publications
     * @return  mixed
     */
    public function scopePublishedOn($query, $publications)
    {
        return $query->whereIn('id_180', function($query) use ($publications) {
            $query->select('hotel_175')
                ->from('007_175_hotels_publications')
                ->whereIn('publication_175', $publications);
        });
    }

    public function getLang()
    {
        return $this->belongsTo('Syscover\Pulsar\Models\Lang', 'lang_171');
    }

    public function getPublications()
    {
        return $this->belongsToMany('Syscover\Hotels\Models\Publication', '007_175_hotels_publications', 'hotel_175', 'publication_175');
    }

    public function getServices()
    {
        return $this->belongsToMany('Syscover\Hotels\Models\Service', '007_176_hotels_services', 'hotel_176', 'service_176');
    }

    public function getHotelProducts()
    {
        return $this->hasMany('Syscover\Hotels\Models\HotelProduct', 'hotel_177')
            ->where('007_177_hotels_products.lang_177', $this->lang_171);
    }

    public function getProducts()
    {
        return $this->belongsToMany('Syscover\Market\Models\Product', '007_177_hotels_products', 'hotel_177', 'product_177');
    }

    public function addToGetIndexRecords($request, $parameters)
    {
        $query =  $this->builder();

        if(isset($parameters['lang'])) $query->where('lang_171', $parameters['lang']);

        return $query;
    }

    public static function getTranslationRecord($parameters)
    {
        return Hotel::join('007_171_hotel_lang', '007_180_hotel.id_180', '=', '007_171_hotel_lang.id_171')
            ->join('001_001_lang', '007_171_hotel_lang.lang_171', '=', '001_001_lang.id_001')
            ->where('id_180', $parameters['id'])->where('lang_171', $parameters['lang'])
            ->first();
    }

    public static function getRecords($parameters)
    {
        $query = Hotel::builder();

        if(isset($parameters['slug_180'])) $query->where('slug_180', $parameters['slug_180']);
        if(isset($parameters['lang_171'])) $query->where('lang_171', $parameters['lang_171']);
        if(isset($parameters['territorial_area_1_180'])) $query->where('territorial_area_1_180', $parameters['territorial_area_1_180']);

        if(isset($parameters['publication_175'])) $query->whereIn('id_180', function($query) use ($parameters) {
            $query->select('hotel_175')
                ->from('007_175_hotels_publications')
                ->whereIn('publication_175', $parameters['publication_175']);
        });

        if(isset($parameters['active_180'])) $query->where('active_180', true);

        return $query->get();
    }
}