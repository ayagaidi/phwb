@extends('layouts.app')

@section('title', __('admin.app_name') . ' | ' . __('admin.volunteer.page_title'))
@section('page-title', __('admin.volunteer.page_title'))

@section('content')
@if(session('success'))
  <div class="alert alert-success mb-4" style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:8px;margin-bottom:1rem;">
    {{ session('success') }}
  </div>
@endif

<style>
  .field-input { padding: 18px 20px; font-size: 1.05rem; line-height: 1.5; }
  .field-grid { gap: 1.5rem; }
  .form-section { max-width: 920px; }
  textarea.field-input { min-height: 120px; }
</style>
<div class="form-layout">
  <!-- Side Preview -->
  <div class="form-preview">
    <div class="form-preview-icon" style="background: var(--green-light); color: var(--green);">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20m10-10H2"/></svg>
    </div>
    <h3>{{ __('admin.volunteer.title') }}</h3>
    <p>{{ __('admin.volunteer.page_title') }}</p>

    <div class="preview-stats">
      <div class="preview-stat orange">
        <p>{{ __('admin.volunteer.hero_title') }}</p>
        <p>{{ $content->hero_title ?? __('admin.volunteer.hero_title') }}</p>
      </div>
      <div class="preview-stat orange">
        <p>{{ __('admin.programs.status') }}</p>
        <p>{{ $content->is_published ? __('admin.programs.published_badge') : __('admin.programs.unpublished_badge') }}</p>
      </div>
    </div>
  </div>

  <!-- Form Section -->
  <div class="form-section">
    <form method="POST" action="{{ route('admin.volunteer-content.update') }}">
      @csrf

      <div class="form-section-hdr">
        <div class="form-section-hdr-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </div>
        <h3>{{ __('admin.volunteer.title') }}</h3>
      </div>

      <div class="field-grid">
        <!-- Arabic -->
        <div class="field-group">
          <label>{{ __('admin.volunteer.hero_title') }}</label>
          <input type="text" name="hero_title" class="field-input" value="{{ $content->hero_title }}" required>
        </div>

        <div class="field-group">
          <label>{{ __('admin.volunteer.hero_desc') }}</label>
          <textarea name="hero_desc" class="field-input" rows="3">{{ $content->hero_desc }}</textarea>
        </div>

        <div class="field-group">
          <label>{{ __('admin.volunteer.opportunities') }}</label>
          <textarea name="opportunities" class="field-input" rows="4">{{ $content->opportunities }}</textarea>
        </div>

        <!-- English -->
        <div class="field-group">
          <label>{{ __('admin.volunteer.hero_title_en') }}</label>
          <input type="text" name="hero_title_en" class="field-input" value="{{ $content->hero_title_en }}">
        </div>

        <div class="field-group">
          <label>{{ __('admin.volunteer.hero_desc_en') }}</label>
          <textarea name="hero_desc_en" class="field-input" rows="3">{{ $content->hero_desc_en }}</textarea>
        </div>

        <div class="field-group">
          <label>{{ __('admin.volunteer.opportunities_en') }}</label>
          <textarea name="opportunities_en" class="field-input" rows="4">{{ $content->opportunities_en }}</textarea>
        </div>

        <!-- Banner -->
        <div class="field-group">
          <label>{{ __('admin.volunteer.banner_image') }}</label>
          @if($content->banner_image)
            <div style="margin-bottom:8px;">
              <img src="{{ asset('storage/' . $content->banner_image) }}" style="max-height:80px; border-radius:6px;">
            </div>
          @endif
          <div id="banner-dropzone" class="dropzone" style="border:2px dashed #cbd5e1; border-radius:12px; background:#f8fafc; padding:1.5rem; text-align:center; cursor:pointer; min-height:120px; display:flex; align-items:center; justify-content:center;">
            <p>{{ __('admin.volunteer.drag_drop') }}</p>
          </div>
          <input type="file" name="banner_image" id="banner-input" class="field-input" style="display:none;" accept="image/*">
        </div>
      </div>

      <button type="submit" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.65rem 1.35rem; border-radius:20px; background:var(--accent); color:#fff; font-size:0.875rem; font-weight:700; border:none; cursor:pointer; margin-top:1rem;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
{{ __('admin.volunteer.save_changes') }}
      </button>
    </form>
  </div>
</div>

@push('scripts')
<script>
  const dropzone = document.getElementById('banner-dropzone');
  const fileInput = document.getElementById('banner-input');

  if (dropzone && fileInput) {
    dropzone.addEventListener('click', () => fileInput.click());

    dropzone.addEventListener('dragover', e => {
      e.preventDefault();
      dropzone.style.borderColor = '#0ea5e9';
    });

    dropzone.addEventListener('dragleave', () => {
      dropzone.style.borderColor = '#cbd5e1';
    });

    dropzone.addEventListener('drop', e => {
      e.preventDefault();
      dropzone.style.borderColor = '#cbd5e1';
      if (e.dataTransfer.files.length > 0) {
        fileInput.files = e.dataTransfer.files;
        dropzone.innerHTML = `<p>تم اختيار: ${e.dataTransfer.files[0].name}</p>`;
      }
    });

    fileInput.addEventListener('change', () => {
      if (fileInput.files.length > 0) {
        dropzone.innerHTML = `<p>تم اختيار: ${fileInput.files[0].name}</p>`;
      }
    });
  }
</script>
@endpush
@endsection
