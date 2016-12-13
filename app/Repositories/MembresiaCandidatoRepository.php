<?php

namespace App\Repositories;

use App\Models\MembresiaCandidato;
use InfyOm\Generator\Common\BaseRepository;

class MembresiaCandidatoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pagado',
        'desde',
        'hasta',
        'candidato_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MembresiaCandidato::class;
    }
}
