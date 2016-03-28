<?php namespace Syscover\Spas\Models;

use Syscover\Pulsar\Models\Model;
use Illuminate\Support\Facades\Validator;
use Syscover\Pulsar\Traits\TraitModel;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;

/**
 * Class HotelLang
 *
 * Model with properties
 * <br><b>[id, lang, cuisine, special_dish, indications, interest_points, environment_description, construction, activities, description_title, description, data_181]</b>
 *
 * @package     Syscover\Hotels\Models
 */

class SpaLang extends Model {

    use TraitModel;
    use Eloquence, Mappable;

	protected $table        = '007_181_hotel_lang';
    protected $primaryKey   = 'id_181';
    protected $suffix       = '181';
    public $timestamps      = false;
    protected $fillable     = ['id_181', 'lang_181', 'cuisine_181', 'special_dish_181', 'indications_181', 'interest_points_181', 'environment_description_181', 'construction_181', 'activities_181', 'description_title_181', 'description_181', 'data_181'];
    protected $maps         = [];
    protected $relationMaps = [
        'lang'  => \Syscover\Pulsar\Models\Lang::class
    ];
    private static $rules   = [];

    public static function validate($data)
    {
        return Validator::make($data, static::$rules);
	}

    public function getLang()
    {
        return $this->belongsTo('Syscover\Pulsar\Models\Lang', 'lang_181');
    }
}