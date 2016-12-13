<?php

namespace App\Repositories;

use App\Models\Oferta;
use InfyOm\Generator\Common\BaseRepository;

class OfertaRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombre',
        'descripcion',
        'url_imagen',
        'direccion',
        'paga',
        'sector_id',
        'ciudad_id',
        'empleador_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Oferta::class;
    }
}
