<!-- Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Departamento Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('departamento_id', 'Departamento Id:') !!}
    {!! Form::number('departamento_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('ciudads.index') !!}" class="btn btn-default">Cancel</a>
</div>
