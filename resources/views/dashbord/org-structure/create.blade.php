@extends('layouts.app')

@section('title', __('admin.org_structure.add_new'))
@section('page-title', __('admin.org_structure.add_new'))

@section('content')
<div class="form-layout">
  <div class="form-preview">
    <div class="form-preview-icon">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
    </div>
    <h3>{{ __('admin.org_structure.add_new') }}</h3>
    <p>{{ __('admin.org_structure.management') }}</p>
  </div>

  <div class="form-section">
    <form method="POST" action="{{ route('admin.org-structure.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="field-group">
        <label>{{ __('admin.org_structure.name_ar') }} <span style="color:var(--red)">*</span></label>
        <input type="text" name="name" class="field-input" required>
      </div>

      <div class="field-group">
        <label>{{ __('admin.org_structure.name_en') }}</label>
        <input type="text" name="name_en" class="field-input">
      </div>

      <div class="field-group">
        <label>{{ __('admin.org_structure.title_ar') }}</label>
        <input type="text" name="title" class="field-input">
      </div>

      <div class="field-group">
        <label>{{ __('admin.org_structure.title_en') }}</label>
        <input type="text" name="title_en" class="field-input">
      </div>

      <div class="field-group">
        <label>{{ __('admin.org_structure.photo') }}</label>
        <input type="file" name="photo" class="field-input" accept="image/*">
      </div>

      <div class="field-group">
        <label>{{ __('admin.org_structure.parent') }}</label>
        <select name="parent_id" class="field-input">
          <option value="">-- {{ __('admin.org_structure.no_parent') }} --</option>
          @foreach($parents as $p)
            <option value="{{ $p->id }}">{{ $p->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="field-group">
        <label>{{ __('admin.org_structure.sort_order') }}</label>
        <input type="number" name="sort_order" class="field-input" value="0">
      </div>

      <button type="submit" class="btn btn-primary" style="margin-top:1rem;">
        {{ __('admin.org_structure.add_button') }}
      </button>
    </form>
  </div>
</div>
@endsection
