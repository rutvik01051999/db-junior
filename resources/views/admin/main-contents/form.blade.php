@if(isset($mainContent))
    {!! Form::model($mainContent, ['route' => ['admin.main-contents.update', $mainContent->id], 'method' => 'PUT', 'files' => true]) !!}
@else
    {!! Form::open(['route' => 'admin.main-contents.store', 'method' => 'POST', 'files' => true]) !!}
@endif

<div class="card">
    <div class="card-header">
        <h5>{{ isset($mainContent) ? 'Edit' : 'Add' }} Main Content</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <div class="form-group mb-3">
                    {!! Form::label('title', 'Title *', ['class' => 'form-label']) !!}
                    {!! Form::text('title', null, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : ''), 'required']) !!}
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('description', 'Description', ['class' => 'form-label']) !!}
                    {!! Form::textarea('description', null, ['class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''), 'rows' => 4]) !!}
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('participation_categories', 'Participation Categories', ['class' => 'form-label']) !!}
                    {!! Form::text('participation_categories', null, ['class' => 'form-control' . ($errors->has('participation_categories') ? ' is-invalid' : '')]) !!}
                    @error('participation_categories')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('timeline', 'Timeline', ['class' => 'form-label']) !!}
                    {!! Form::text('timeline', null, ['class' => 'form-control' . ($errors->has('timeline') ? ' is-invalid' : '')]) !!}
                    @error('timeline')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mb-3">
                    {!! Form::label('image', 'Image *', ['class' => 'form-label']) !!}
                    @if(isset($mainContent) && $mainContent->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $mainContent->image) }}" alt="{{ $mainContent->title }}" class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    @endif
                    {!! Form::file('image', ['class' => 'form-control' . ($errors->has('image') ? ' is-invalid' : ''), !isset($mainContent) ? 'required' : '']) !!}
                    <small class="form-text text-muted">Recommended size: 1200x600px, Max size: 2MB</small>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    {!! Form::label('sort_order', 'Sort Order', ['class' => 'form-label']) !!}
                    {!! Form::number('sort_order', null, ['class' => 'form-control' . ($errors->has('sort_order') ? ' is-invalid' : ''), 'min' => 0]) !!}
                    @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <div class="form-check form-switch">
                        {!! Form::checkbox('is_active', 1, null, ['class' => 'form-check-input', 'id' => 'is_active']) !!}
                        {!! Form::label('is_active', 'Active', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ isset($mainContent) ? 'Update' : 'Save' }}
        </button>
        <a href="{{ route('admin.main-contents.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

{!! Form::close() !!}
