<!-- Nombre Field -->
<div class="form-group col-sm-6">
    {!! Form::label('nombre', 'Nombre:') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control']) !!}
</div>

<!-- Descripcion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('descripcion', 'Descripcion:') !!}
    {!! Form::text('descripcion', null, ['class' => 'form-control']) !!}
</div>

<!-- Url Imagen Field -->
<div class="form-group col-sm-6">
    {!! Form::label('url_imagen', 'Url Imagen:') !!}
    {!! Form::text('url_imagen', null, ['class' => 'form-control']) !!}
</div>

<!-- Direccion Field -->
<div class="form-group col-sm-6">
    {!! Form::label('direccion', 'Direccion:') !!}
    {!! Form::text('direccion', null, ['class' => 'form-control']) !!}
</div>

<!-- Paga Field -->
<div class="form-group col-sm-6">
    {!! Form::label('paga', 'Paga:') !!}
    {!! Form::text('paga', null, ['class' => 'form-control']) !!}
</div>

<!-- Sector Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('sector_id', 'Sector Id:') !!}
    {!! Form::number('sector_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Ciudad Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ciudad_id', 'Ciudad Id:') !!}
    {!! Form::number('ciudad_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Empleador Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('empleador_id', 'Empleador Id:') !!}
    {!! Form::number('empleador_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('ofertas.index') !!}" class="btn btn-default">Cancel</a>
</div>
