<?php

namespace App\Repositories;

use App\Models\Genero;
use InfyOm\Generator\Common\BaseRepository;

class GeneroRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'descripcion'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Genero::class;
    }
}
