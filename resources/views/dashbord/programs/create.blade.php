@extends('layouts.app')

@section('title', __('admin.programs.add_new'))
@section('page-title', __('admin.programs.add_new'))

@section('content')
<div class="content-scroll">
  <div class="content">

    <!-- Header -->
    <div class="page-hdr">
      <div class="page-hdr-back">
        <a href="{{ route('admin.programs') }}" class="btn-back">
          <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none">
            <path d="M15 18l-6-6 6-6"></path>
          </svg>
        </a>
        <div>
          <h1>{{ __('admin.programs.add_new') }}</h1>
          <p>{{ __('admin.programs.description_hint') }}</p>
        </div>
      </div>
    </div>

    <!-- Main Form Card -->
    <div class="glass-box p-8">
      <form method="POST" action="{{ route('admin.programs.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">

          <!-- Image Upload (single) -->
          <div class="form-group grid-full">
            <label>{{ __('admin.programs.media') }}</label>
            <div id="image-dropzone" class="upload-zone">
              <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="1.5" fill="none">
                <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                <polyline points="21 15 16 10 5 21"></polyline>
              </svg>
              <p>{{ __('admin.programs.drag_drop') }}</p>
              <div id="selected-images-list" style="margin-top: 8px; font-size: 0.8rem; color: var(--muted);"></div>
            </div>
            <input type="file" name="image" id="image-input" style="display:none;" accept="image/*">
            @error('image')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- Video URL -->
          <div class="form-group grid-full">
            <label>{{ __('admin.programs.video_url') }} (اختياري)</label>
            <input type="url" name="video_url" class="field-input" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=...">
            @error('video_url')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- Arabic Title -->
          <div class="form-group grid-half">
            <label>{{ __('admin.programs.title_ar') }} <span class="text-red-500">*</span></label>
            <input type="text" name="title" class="field-input" value="{{ old('title') }}" required>
            @error('title')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- English Title -->
          <div class="form-group grid-half">
            <label>{{ __('admin.programs.title_en') }}</label>
            <input type="text" name="title_en" class="field-input" value="{{ old('title_en') }}">
          </div>

          <!-- Arabic Description -->
          <div class="form-group grid-full">
            <label>{{ __('admin.programs.description_ar') }} <span class="text-red-500">*</span></label>
            <textarea name="description" class="field-input" rows="4" required>{{ old('description') }}</textarea>
            @error('description')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- English Description -->
          <div class="form-group grid-full">
            <label>{{ __('admin.programs.description_en') }}</label>
            <textarea name="description_en" class="field-input" rows="4">{{ old('description_en') }}</textarea>
          </div>

        </div>

        <div class="form-footer mt-8">
          <button type="submit" class="btn btn-save">
            <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2.5" fill="none">
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            {{ __('admin.programs.add_button') }}
          </button>
          <a href="{{ route('admin.programs') }}" class="btn btn-cancel">{{ __('admin.cancel') }}</a>
        </div>

      </form>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
  const dropzone = document.getElementById('image-dropzone');
  const fileInput = document.getElementById('image-input');
  const listContainer = document.getElementById('selected-images-list');

  let selectedFile = null;

  function updateFileList() {
    listContainer.innerHTML = '';
    if (!selectedFile) return;

    const ul = document.createElement('ul');
    ul.style.cssText = 'list-style:none; padding:0; margin:8px 0 0; text-align:left; max-width:100%;';

    const li = document.createElement('li');
    li.style.cssText = 'display:flex; align-items:center; justify-content:space-between; background:white; padding:4px 8px; border-radius:6px; margin-bottom:4px; font-size:0.85rem;';
    li.innerHTML = `
      <span style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">${selectedFile.name}</span>
      <button type="button" style="background:none; border:none; color:#dc2626; cursor:pointer; font-size:14px; padding:0 4px;">×</button>
    `;
    li.querySelector('button').onclick = () => {
      selectedFile = null;
      updateFileList();
      syncToInput();
    };
    ul.appendChild(li);

    listContainer.appendChild(ul);
  }

  function syncToInput() {
    const dt = new DataTransfer();
    if (selectedFile) dt.items.add(selectedFile);
    fileInput.files = dt.files;
  }

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
        const f = e.dataTransfer.files[0];
        if (f.type.startsWith('image/')) {
          selectedFile = f;
        }
      }

      updateFileList();
      syncToInput();
    });

    fileInput.addEventListener('change', () => {
      if (fileInput.files.length > 0) {
        const f = fileInput.files[0];
        if (f.type.startsWith('image/')) {
          selectedFile = f;
        }
      }
      updateFileList();
    });
  }
</script>
@endpush
