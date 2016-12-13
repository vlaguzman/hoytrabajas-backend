<?php

namespace App\Repositories;

use App\Models\Ciudad;
use InfyOm\Generator\Common\BaseRepository;

class CiudadRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'descripcion',
        'departamento_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Ciudad::class;
    }
}
