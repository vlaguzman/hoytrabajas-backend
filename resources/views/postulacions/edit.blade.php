@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Postulacion
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($postulacion, ['route' => ['postulacions.update', $postulacion->id], 'method' => 'patch']) !!}

                        @include('postulacions.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection