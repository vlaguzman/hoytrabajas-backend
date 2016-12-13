@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Sector Candidato
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'sectorCandidatos.store']) !!}

                        @include('sector_candidatos.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
