<?php namespace Syscover\Spas\Models;

use Syscover\Pulsar\Core\Model;
use Sofa\Eloquence\Eloquence;
use Sofa\Eloquence\Mappable;
use Illuminate\Support\Facades\Validator;

/**
 * Class SpaLang
 *
 * Model with properties
 * <br><b>[id, lang, cuisine, description_title, description, treatments]</b>
 *
 * @package     Syscover\Spas\Models
 */

class SpaLang extends Model
{
    use Eloquence, Mappable;

	protected $table        = '014_181_spa_lang';
    protected $primaryKey   = 'id_181';
    protected $suffix       = '181';
    public $timestamps      = false;
    protected $fillable     = ['id_181', 'lang_181', 'description_title_181', 'description_181', 'treatments_181'];
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