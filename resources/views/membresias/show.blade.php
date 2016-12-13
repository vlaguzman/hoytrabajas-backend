@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Membresia
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('membresias.show_fields')
                    <a href="{!! route('membresias.index') !!}" class="btn btn-default">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
