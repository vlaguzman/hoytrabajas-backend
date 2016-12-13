<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Candidato",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="nombres",
 *          description="nombres",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="apellidos",
 *          description="apellidos",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="url_imagen",
 *          description="url_imagen",
 *          type="string"
 *      ),
 *      @SWG\Property(
 *          property="fnac",
 *          description="fnac",
 *          type="string",
 *          format="date"
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
 *          property="experiencia",
 *          description="experiencia",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="rate",
 *          description="rate",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="genero_id",
 *          description="genero_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="ciudad_id",
 *          description="ciudad_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class Candidato extends Model
{
    use SoftDeletes;

    public $table = 'candidatos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'nombres',
        'apellidos',
        'url_imagen',
        'fnac',
        'telefono',
        'correo',
        'descripcion',
        'direccion',
        'experiencia',
        'rate',
        'genero_id',
        'ciudad_id',
		'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'nombres' => 'string',
        'apellidos' => 'string',
        'url_imagen' => 'string',
        'fnac' => 'date',
        'telefono' => 'string',
        'correo' => 'string',
        'descripcion' => 'string',
        'direccion' => 'string',
        'experiencia' => 'integer',
        'rate' => 'integer',
        'genero_id' => 'integer',
        'ciudad_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
