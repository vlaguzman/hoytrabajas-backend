<!-- Deuser Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deuser_id', 'Deuser Id:') !!}
    {!! Form::number('deuser_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Parauser Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('parauser_id', 'Parauser Id:') !!}
    {!! Form::number('parauser_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Mensaje Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('mensaje', 'Mensaje:') !!}
    {!! Form::textarea('mensaje', null, ['class' => 'form-control']) !!}
</div>

<!-- Fenviado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fenviado', 'Fenviado:') !!}
    {!! Form::date('fenviado', null, ['class' => 'form-control']) !!}
</div>

<!-- Frecivido Field -->
<div class="form-group col-sm-6">
    {!! Form::label('frecivido', 'Frecivido:') !!}
    {!! Form::date('frecivido', null, ['class' => 'form-control']) !!}
</div>

<!-- Fleido Field -->
<div class="form-group col-sm-6">
    {!! Form::label('fleido', 'Fleido:') !!}
    {!! Form::date('fleido', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('mensajes.index') !!}" class="btn btn-default">Cancel</a>
</div>
