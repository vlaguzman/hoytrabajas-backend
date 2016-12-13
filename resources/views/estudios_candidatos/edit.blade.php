@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Estudios Candidato
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($estudiosCandidato, ['route' => ['estudiosCandidatos.update', $estudiosCandidato->id], 'method' => 'patch']) !!}

                        @include('estudios_candidatos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection