<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'paises*', 'departamentos*', 'ciudades*','generos*', 'estudios*', 'idiomas*', 'sectores*',
		'ofertasactivas*','ofertasvencidas*','loginm*','registraru2*', 'registraru3*','regoferta*',
		'regpostulacion*','regpostulaciona*','regpostulacionr*','postulaciones*','*regmembresia',
		'getdetoferta*','buscarcandidato*','getcandidatoa*','verificarmembresia*','postulacionempleadores*',
		'getcandidatodetalle*','getdetusuario*','historicomensajes*','regmensaje*','postulacionusuarios*',
		'postulacionpendientes*','postulacionaceptadas*','postulacionrechazadas*'
    ];
}
