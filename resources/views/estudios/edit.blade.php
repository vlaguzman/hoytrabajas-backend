@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Estudio
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($estudio, ['route' => ['estudios.update', $estudio->id], 'method' => 'patch']) !!}

                        @include('estudios.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection