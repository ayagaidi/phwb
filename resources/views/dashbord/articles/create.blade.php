@extends('layouts.app')

@section('title', __('admin.app_name') . ' | ' . __('admin.articles.add_new'))
@section('page-title', __('admin.articles.add_new'))

@section('content')
<div class="content-scroll">
  <div class="content">

    <!-- Header -->
    <div class="page-hdr">
      <div class="page-hdr-back">
        <a href="{{ route('admin.articles') }}" class="btn-back">
          <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none">
            <path d="M15 18l-6-6 6-6"></path>
          </svg>
        </a>
        <div>
          <h1>{{ __('admin.articles.add_new') }}</h1>
           <p>{{ __('admin.articles.details_hint') }}</p>
        </div>
      </div>
    </div>

    <!-- Main Form Card -->
    <div class="glass-box p-8">
      <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">

          <!-- Images Upload -->
          <div class="form-group grid-full">
            <label>{{ __('admin.articles.image') }}</label>
            <div id="image-dropzone" class="upload-zone">
              <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="1.5" fill="none">
                <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                <polyline points="21 15 16 10 5 21"></polyline>
              </svg>
              <p>{{ __('admin.articles.drag_drop') }}</p>
              <div id="selected-images-list" style="margin-top: 8px; font-size: 0.8rem; color: var(--muted);"></div>
            </div>
            <input type="file" name="images[]" id="image-input" style="display:none;" accept="image/*" multiple>
            @error('images.*')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- Arabic Title -->
          <div class="form-group grid-half">
            <label>{{ __('admin.articles.title_ar') }} <span class="text-red-500">*</span></label>
            <input type="text" name="title" class="field-input" value="{{ old('title') }}" required>
            @error('title')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- English Title -->
          <div class="form-group grid-half">
            <label>{{ __('admin.articles.title_en') }}</label>
            <input type="text" name="title_en" class="field-input" value="{{ old('title_en') }}">
          </div>

          <!-- Arabic Content -->
          <div class="form-group grid-full">
            <label>{{ __('admin.articles.content_ar') }} <span class="text-red-500">*</span></label>
            <textarea name="content" class="field-input" rows="8" required>{{ old('content') }}</textarea>
            @error('content')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- English Content -->
          <div class="form-group grid-full">
            <label>{{ __('admin.articles.content_en') }}</label>
            <textarea name="content_en" class="field-input" rows="8">{{ old('content_en') }}</textarea>
          </div>

        </div>

        <div class="form-footer mt-8">
          <button type="submit" class="btn btn-save">
            <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2.5" fill="none">
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            {{ __('admin.articles.add_button') }}
          </button>
          <a href="{{ route('admin.articles') }}" class="btn btn-cancel">{{ __('admin.cancel') }}</a>
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

  let selectedFiles = [];

  function updateFileList() {
    listContainer.innerHTML = '';
    if (selectedFiles.length === 0) return;

    const ul = document.createElement('ul');
    ul.style.cssText = 'list-style:none; padding:0; margin:8px 0 0; text-align:left; max-width:100%;';

    selectedFiles.forEach((file, index) => {
      const li = document.createElement('li');
      li.style.cssText = 'display:flex; align-items:center; justify-content:space-between; background:white; padding:4px 8px; border-radius:6px; margin-bottom:4px; font-size:0.85rem;';
      li.innerHTML = `
        <span style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">${file.name}</span>
        <button type="button" style="background:none; border:none; color:#dc2626; cursor:pointer; font-size:14px; padding:0 4px;">×</button>
      `;
      li.querySelector('button').onclick = () => {
        removeSelectedImage(index);
      };
      ul.appendChild(li);
    });

    listContainer.appendChild(ul);
  }

  function syncToInput() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    fileInput.files = dt.files;
  }

  // Dedicated function to remove a selected image with confirmation
  function removeSelectedImage(index) {
    Swal.fire({
      title: 'هل أنت متأكد؟',
      text: 'هل تريد إزالة هذه الصورة من القائمة؟',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'نعم، أزلها',
      cancelButtonText: '{{ __("admin.confirm.cancel") }}'
    }).then((result) => {
      if (result.isConfirmed) {
        selectedFiles.splice(index, 1);
        updateFileList();
        syncToInput();
      }
    });
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

      Array.from(e.dataTransfer.files).forEach(file => {
        if (file.type.startsWith('image/')) {
          selectedFiles.push(file);
        }
      });

      updateFileList();
      syncToInput();
    });

    fileInput.addEventListener('change', () => {
      Array.from(fileInput.files).forEach(file => {
        if (!selectedFiles.some(f => f.name === file.name)) {
          selectedFiles.push(file);
        }
      });
      updateFileList();
    });
  }
</script>
@endpush
