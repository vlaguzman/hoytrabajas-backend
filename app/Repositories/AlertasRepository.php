<?php

namespace App\Repositories;

use App\Models\Alertas;
use InfyOm\Generator\Common\BaseRepository;

class AlertasRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'email',
        'push'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Alertas::class;
    }
}
