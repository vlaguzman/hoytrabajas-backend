<?php

namespace App\Repositories;

use App\Models\Mensajes;
use InfyOm\Generator\Common\BaseRepository;

class MensajesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'deuser_id',
        'parauser_id',
        'mensaje',
        'fenviado',
        'frecivido',
        'fleido',
        'recivido',
        'leido'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Mensajes::class;
    }
}
