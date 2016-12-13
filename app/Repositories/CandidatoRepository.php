<?php

namespace App\Repositories;

use App\Models\Candidato;
use InfyOm\Generator\Common\BaseRepository;

class CandidatoRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'nombres',
        'apellidos',
        'url_imagen',
        'fnac',
        'telefono',
        'correo',
        'descripcion',
        'direccion',
        'experiencia',
        'rate',
        'genero_id',
        'ciudad_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Candidato::class;
    }
}
