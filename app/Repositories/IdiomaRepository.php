<?php

namespace App\Repositories;

use App\Models\Idioma;
use InfyOm\Generator\Common\BaseRepository;

class IdiomaRepository extends BaseRepository
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
        return Idioma::class;
    }
}
