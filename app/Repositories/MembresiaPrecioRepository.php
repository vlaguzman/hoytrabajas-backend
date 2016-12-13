<?php

namespace App\Repositories;

use App\Models\MembresiaPrecio;
use InfyOm\Generator\Common\BaseRepository;

class MembresiaPrecioRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'membresia_id',
        'precio',
        'duracion',
        'desde',
        'hasta'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MembresiaPrecio::class;
    }
}
