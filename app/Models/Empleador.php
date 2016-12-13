<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Empleador",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="contacto",
 *          description="contacto",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="empresa",
 *          description="empresa",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="telefono",
 *          description="telefono",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="correo",
 *          description="correo",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="descripcion",
 *          description="descripcion",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="direccion",
 *          description="direccion",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="ciudad_id",
 *          description="ciudad_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="url_imagen",
 *          description="url_imagen",
 *          type="string"
 *      )
 * )
 */
class Empleador extends Model
{
    use SoftDeletes;

    public $table = 'empleadores';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'contacto',
        'empresa',
        'telefono',
        'correo',
        'descripcion',
        'direccion',
        'ciudad_id',
        'url_imagen',
		'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'contacto' => 'string',
        'empresa' => 'string',
        'telefono' => 'string',
        'correo' => 'string',
        'descripcion' => 'string',
        'direccion' => 'string',
        'ciudad_id' => 'integer',
        'url_imagen' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
