@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Idiomas Candidato
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('idiomas_candidatos.show_fields')
                    <a href="{!! route('idiomasCandidatos.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
