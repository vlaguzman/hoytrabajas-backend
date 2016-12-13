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
                   {!! Form::model($sectorCandidato, ['route' => ['sectorCandidatos.update', $sectorCandidato->id], 'method' => 'patch']) !!}

                        @include('sector_candidatos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection