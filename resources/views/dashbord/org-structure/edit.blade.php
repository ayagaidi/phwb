@extends('layouts.app')

@section('title', __('admin.org_structure.edit_unit'))
@section('page-title', __('admin.org_structure.edit_unit'))

@section('content')
<div class="form-layout">
  <div class="form-preview">
    <div class="form-preview-icon">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
    </div>
    <h3>{{ __('admin.org_structure.edit_unit') }} - {{ $unit->name }}</h3>
  </div>

  <div class="form-section">
    <form method="POST" action="{{ route('admin.org-structure.update', $unit->id) }}" enctype="multipart/form-data">
      @csrf @method('PUT')

      <div class="field-group">
        <label>{{ __('admin.org_structure.name_ar') }} <span style="color:var(--red)">*</span></label>
        <input type="text" name="name" class="field-input" value="{{ $unit->name }}" required>
      </div>

      <div class="field-group">
        <label>{{ __('admin.org_structure.name_en') }}</label>
        <input type="text" name="name_en" class="field-input" value="{{ $unit->name_en }}">
      </div>

      <div class="field-group">
        <label>{{ __('admin.org_structure.title_ar') }}</label>
        <input type="text" name="title" class="field-input" value="{{ $unit->title }}">
      </div>

      <div class="field-group">
        <label>{{ __('admin.org_structure.title_en') }}</label>
        <input type="text" name="title_en" class="field-input" value="{{ $unit->title_en }}">
      </div>

      @if($unit->photo)
        <div class="field-group">
          <label>{{ __('admin.org_structure.current_photo') }}</label>
          <img src="{{ asset('storage/' . $unit->photo) }}" width="80" style="border-radius:9999px;">
        </div>
      @endif

      <div class="field-group">
        <label>{{ __('admin.org_structure.change_photo') }}</label>
        <input type="file" name="photo" class="field-input" accept="image/*">
      </div>

      <div class="field-group">
        <label>{{ __('admin.org_structure.parent') }}</label>
        <select name="parent_id" class="field-input">
          <option value="">-- {{ __('admin.org_structure.no_parent') }} --</option>
          @foreach($parents as $p)
            <option value="{{ $p->id }}" {{ $unit->parent_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="field-group">
        <label>{{ __('admin.org_structure.sort_order') }}</label>
        <input type="number" name="sort_order" class="field-input" value="{{ $unit->sort_order }}">
      </div>

      <button type="submit" class="btn btn-primary" style="margin-top:1rem;">
        {{ __('admin.org_structure.save_changes') }}
      </button>
    </form>
  </div>
</div>
@endsection
