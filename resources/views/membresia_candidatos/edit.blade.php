@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Membresia Candidato
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($membresiaCandidato, ['route' => ['membresiaCandidatos.update', $membresiaCandidato->id], 'method' => 'patch']) !!}

                        @include('membresia_candidatos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection