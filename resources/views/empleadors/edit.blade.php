@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Empleador
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($empleador, ['route' => ['empleadors.update', $empleador->id], 'method' => 'patch']) !!}

                        @include('empleadors.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection