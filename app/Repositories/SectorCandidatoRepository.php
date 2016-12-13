<?php

namespace App\Repositories;

use App\Models\SectorCandidato;
use InfyOm\Generator\Common\BaseRepository;

class SectorCandidatoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'sector_id',
        'candidato_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return SectorCandidato::class;
    }
}
