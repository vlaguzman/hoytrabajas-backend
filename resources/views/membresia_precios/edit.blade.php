@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Membresia Precio
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($membresiaPrecio, ['route' => ['membresiaPrecios.update', $membresiaPrecio->id], 'method' => 'patch']) !!}

                        @include('membresia_precios.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection