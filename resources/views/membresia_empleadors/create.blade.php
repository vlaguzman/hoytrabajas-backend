@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Membresia Empleador
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'membresiaEmpleadors.store']) !!}

                        @include('membresia_empleadors.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
