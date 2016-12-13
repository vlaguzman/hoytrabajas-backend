@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Idiomas Candidato
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($idiomasCandidato, ['route' => ['idiomasCandidatos.update', $idiomasCandidato->id], 'method' => 'patch']) !!}

                        @include('idiomas_candidatos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection