<?php

namespace App\Repositories;

use App\Models\EstudiosCandidato;
use InfyOm\Generator\Common\BaseRepository;

class EstudiosCandidatoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'estudio_id',
        'candidato_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EstudiosCandidato::class;
    }
}
