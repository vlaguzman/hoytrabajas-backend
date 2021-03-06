<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @SWG\Definition(
 *      definition="Postulacion",
 *      required={""},
 *      @SWG\Property(
 *          property="id",
 *          description="id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="oferta_id",
 *          description="oferta_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="candidato_id",
 *          description="candidato_id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="estatus_id",
 *          description="estatus_id",
 *          type="integer",
 *          format="int32"
 *      )
 * )
 */
class Postulacion extends Model
{
    use SoftDeletes;

    public $table = 'postulaciones';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'oferta_id',
        'candidato_id',
        'estatus_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'oferta_id' => 'integer',
        'candidato_id' => 'integer',
        'estatus_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function candidato()
    {
        return $this->belongsTo(\App\Models\Candidato::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function estatusPostulacion()
    {
        return $this->belongsTo(\App\Models\EstatusPostulacion::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function oferta()
    {
        return $this->belongsTo(\App\Models\Oferta::class);
    }
}
