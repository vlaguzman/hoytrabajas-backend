<?php

namespace App\Repositories;

use App\Models\MembresiaEmpleador;
use InfyOm\Generator\Common\BaseRepository;

class MembresiaEmpleadorRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'pagado',
        'desde',
        'hasta',
        'empleador_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MembresiaEmpleador::class;
    }
}
