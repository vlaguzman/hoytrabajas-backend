<?php

namespace App\Repositories;

use App\Models\IdiomasCandidato;
use InfyOm\Generator\Common\BaseRepository;

class IdiomasCandidatoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'idioma_id',
        'candidato_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return IdiomasCandidato::class;
    }
}
