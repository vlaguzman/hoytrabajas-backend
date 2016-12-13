<?php

namespace App\Repositories;

use App\Models\Estudio;
use InfyOm\Generator\Common\BaseRepository;

class EstudioRepository extends BaseRepository
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
        return Estudio::class;
    }
}
