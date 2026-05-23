@extends('layouts.app')

@section('title', __('admin.programs.add_new'))
@section('page-title', __('admin.programs.add_new'))

@push('styles')
<style>
  .dropzone {
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    background: #f8fafc;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
  }
  .dropzone.dragover {
    background: #e0f2fe;
    border-color: #0ea5e9;
  }
</style>
@endpush

@section('content')
<div class="form-layout">
  <div class="form-preview">
    <div class="form-preview-icon">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20m10-10H2"/></svg>
    </div>
    <h3>{{ __('admin.programs.new_program') }}</h3>
    <p>{{ __('admin.programs.description_hint') }}</p>
  </div>

  <div class="form-section">
    <form method="POST" action="{{ route('admin.programs.store') }}" enctype="multipart/form-data" id="program-form">
      @csrf
      <div class="field-group">
        <label>{{ __('admin.programs.title_ar') }}</label>
        <input type="text" name="title" class="field-input" required>
      </div>
      <div class="field-group">
        <label>{{ __('admin.programs.title_en') }}</label>
        <input type="text" name="title_en" class="field-input">
      </div>
      <div class="field-group">
        <label>{{ __('admin.programs.description_ar') }}</label>
        <textarea name="description" class="field-input" rows="4" required></textarea>
      </div>
      <div class="field-group">
        <label>{{ __('admin.programs.description_en') }}</label>
        <textarea name="description_en" class="field-input" rows="4"></textarea>
      </div>

      <!-- Dropzone for Image/Video -->
      <div class="field-group">
        <label>{{ __('admin.programs.media') }}</label>
        <div id="media-dropzone" class="dropzone">
          <div class="dz-message">
            {{ __('admin.programs.drag_drop') }}<br>
            <small>{{ __('admin.programs.media_hint') }}</small>
          </div>
        </div>
        <input type="hidden" name="media" id="media-input">
      </div>

      <button type="submit" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.65rem 1.35rem; border-radius:20px; background:var(--accent); color:#fff; font-size:0.875rem; font-weight:700; border:none; cursor:pointer; margin-top:1rem;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        {{ __('admin.programs.add_button') }}
      </button>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  const dropzone = document.getElementById('media-dropzone');
  const mediaInput = document.getElementById('media-input');
  let selectedFile = null;

  dropzone.addEventListener('click', () => {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*,video/*';
    input.onchange = (e) => {
      selectedFile = e.target.files[0];
      dropzone.innerHTML = `<p>تم اختيار: ${selectedFile.name}</p>`;
    };
    input.click();
  });

  dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('dragover');
  });

  dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('dragover');
  });

  dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('dragover');
    selectedFile = e.dataTransfer.files[0];
    dropzone.innerHTML = `<p>تم اختيار: ${selectedFile.name}</p>`;
  });

  // Attach file to form before submit
  document.getElementById('program-form').addEventListener('submit', function(e) {
    if (selectedFile) {
      const formData = new FormData(this);
      formData.append('media', selectedFile);
      // We will let the normal form submit handle it
    }
  });
</script>
@endpush

