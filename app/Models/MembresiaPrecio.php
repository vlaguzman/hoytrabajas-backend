<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="MembresiaPrecio",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="membresia_id",
 *          description="membresia_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="precio",
 *          description="precio",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="duracion",
 *          description="duracion",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class MembresiaPrecio extends Model
{
    use SoftDeletes;

    public $table = 'membresias_precios';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'membresia_id',
        'precio',
        'duracion',
        'desde',
        'hasta'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'membresia_id' => 'integer',
        'duracion' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
