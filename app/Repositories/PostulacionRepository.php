<?php

namespace App\Repositories;

use App\Models\Postulacion;
use InfyOm\Generator\Common\BaseRepository;

class PostulacionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'oferta_id',
        'candidato_id',
        'estatus_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Postulacion::class;
    }
}
