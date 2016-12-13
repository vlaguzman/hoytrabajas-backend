<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="MembresiaCandidato",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="pagado",
 *          description="pagado",
 *          type="number",
 *          format="float"
 *      ),
 *      @SWG\Property(
 *          property="candidato_id",
 *          description="candidato_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class MembresiaCandidato extends Model
{
    use SoftDeletes;

    public $table = 'membresias_candidatos';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'pagado',
        'desde',
        'hasta',
        'candidato_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'candidato_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
