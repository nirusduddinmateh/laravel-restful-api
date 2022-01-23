<div class="form-group{{ $errors->has('description') ? 'has-error' : ''}}">
    <label for="description">คำอธิบาย</label>
    <input type="text" class="form-control" id="description" name="description"
           value="{{ $formMode === 'edit' ? $model->description : '' }}"
           required>
    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('img') ? 'has-error' : ''}}">
    <label for="image">รูปภาพ</label>
    <input type="file" id="img" name="img">
    {!! $errors->first('img', '<p class="help-block">:message</p>') !!}
</div>

<div class="mb-5">
    @if($formMode === 'edit')
        <img src="{{ Storage::url($model->img) }}" alt="{{ $model->description }}" class="h-20 w-20 object-cover"
             height="16px">
    @endif
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $formMode === 'edit' ? 'Update' : 'Create' }}</button>
</div>
