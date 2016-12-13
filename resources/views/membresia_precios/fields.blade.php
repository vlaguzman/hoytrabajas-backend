<!-- Membresia Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('membresia_id', 'Membresia Id:') !!}
    {!! Form::number('membresia_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Precio Field -->
<div class="form-group col-sm-6">
    {!! Form::label('precio', 'Precio:') !!}
    {!! Form::number('precio', null, ['class' => 'form-control']) !!}
</div>

<!-- Duracion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('duracion', 'Duracion:') !!}
    {!! Form::number('duracion', null, ['class' => 'form-control']) !!}
</div>

<!-- Desde Field -->
<div class="form-group col-sm-6">
    {!! Form::label('desde', 'Desde:') !!}
    {!! Form::date('desde', null, ['class' => 'form-control']) !!}
</div>

<!-- Hasta Field -->
<div class="form-group col-sm-6">
    {!! Form::label('hasta', 'Hasta:') !!}
    {!! Form::date('hasta', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('membresiaPrecios.index') !!}" class="btn btn-default">Cancel</a>
</div>
