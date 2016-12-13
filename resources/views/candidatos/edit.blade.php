@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Candidato
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($candidato, ['route' => ['candidatos.update', $candidato->id], 'method' => 'patch']) !!}

                        @include('candidatos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection