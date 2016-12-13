<?php

namespace App\Repositories;

use App\Models\Membresia;
use InfyOm\Generator\Common\BaseRepository;

class MembresiaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'descripcion',
        'empleador',
        'candidato'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Membresia::class;
    }
}
