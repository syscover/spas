<?php namespace Syscover\Spas\Models;

use Syscover\Pulsar\Core\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;
use Illuminate\Support\Facades\Validator;

/**
 * Class Spa
 *
 * Model with properties
 * <br><b>[id, field_group_id, hotel_id, name, slug, web, web_url, contact, email, phone, mobile, fax, active, country_id, territorial_area_1_id, territorial_area_2_id, territorial_area_3_id, cp, locality, address, latitude, longitude, booking_data, booking_email, data_lang, data]</b>
 *
 * @package     Syscover\Spas\Models
 */

class Spa extends Model
{
    use Eloquence, Mappable;

	protected $table        = '014_180_spa';
    protected $primaryKey   = 'id_180';
    protected $suffix       = '180';
    public $timestamps      = false;
    protected $fillable     = ['id_180', 'field_group_id_180', 'hotel_id_180', 'name_180', 'slug_180', 'web_180', 'web_url_180', 'contact_180', 'email_180', 'phone_180', 'mobile_180', 'fax_180', 'active_180', 'country_id_180', 'territorial_area_1_id_180', 'territorial_area_2_id_180', 'territorial_area_3_id_180', 'cp_180', 'locality_180', 'address_180', 'latitude_180', 'longitude_180', 'booking_data_180', 'booking_email_180', 'data_lang_180', 'data_180'];
    protected $maps         = [];
    protected $relationMaps = [
        'hotel'         => \Syscover\Hotels\Models\Hotel::class, // if this spa belonging to a hotel
        'lang'          => \Syscover\Pulsar\Models\Lang::class,
        'spa_lang'      => \Syscover\Spas\Models\SpaLang::class,
        'country'       => \Syscover\Pulsar\Models\Country::class
    ];
    private static $rules   = [
        'name'      => 'required|between:2,100',
        'email'     => 'required|between:2,50|email|unique:014_180_spa,email_180',
    ];

    public static function validate($data, $specialRules = [])
    {
        if(isset($specialRules['emailRule']) && $specialRules['emailRule']) static::$rules['email'] = 'required|between:2,50|email';

        return Validator::make($data, static::$rules);
	}

    /**
     * @param   \Sofa\Eloquence\Builder     $query
     * @return  mixed
     */
    public function scopeBuilder($query)
    {
        return $query->join('014_181_spa_lang', '014_180_spa.id_180', '=', '014_181_spa_lang.id_181')
            ->join('001_001_lang', '014_181_spa_lang.lang_id_181', '=', '001_001_lang.id_001')
            ->join('001_002_country', function ($join) {
                $join->on('014_180_spa.country_id_180', '=', '001_002_country.id_002')
                    ->on('001_002_country.lang_id_002', '=', '001_001_lang.id_001');
            })
            ->leftJoin('001_003_territorial_area_1', '014_180_spa.territorial_area_1_id_180', '=', '001_003_territorial_area_1.id_003')
            ->leftJoin('001_004_territorial_area_2', '014_180_spa.territorial_area_2_id_180', '=', '001_004_territorial_area_2.id_004');
    }

    public function getLang()
    {
        return $this->belongsTo('Syscover\Pulsar\Models\Lang', 'lang_id_181');
    }

    public function addToGetIndexRecords($request, $parameters)
    {
        $query =  $this->builder();

        if(isset($parameters['lang'])) $query->where('lang_id_181', $parameters['lang']);

        return $query;
    }

    public static function getTranslationRecord($parameters)
    {
        return Spa::join('014_181_spa_lang', '014_180_spa.id_180', '=', '014_181_spa_lang.id_181')
            ->join('001_001_lang', '014_181_spa_lang.lang_id_181', '=', '001_001_lang.id_001')
            ->where('id_180', $parameters['id'])->where('lang_id_181', $parameters['lang'])
            ->first();
    }

    public static function getRecords($parameters)
    {
        $query = Spa::builder();

        if(isset($parameters['slug_180'])) $query->where('slug_180', $parameters['slug_180']);
        if(isset($parameters['lang_id_181'])) $query->where('lang_id_181', $parameters['lang_id_181']);
        if(isset($parameters['territorial_area_1_id_180'])) $query->where('territorial_area_1_id_180', $parameters['territorial_area_1_id_180']);

        if(isset($parameters['active_180'])) $query->where('active_180', true);

        return $query->get();
    }
}