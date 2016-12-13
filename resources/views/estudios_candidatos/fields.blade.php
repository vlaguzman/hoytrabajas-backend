<!-- Estudio Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('estudio_id', 'Estudio Id:') !!}
    {!! Form::number('estudio_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Candidato Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('candidato_id', 'Candidato Id:') !!}
    {!! Form::number('candidato_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('estudiosCandidatos.index') !!}" class="btn btn-default">Cancel</a>
</div>
