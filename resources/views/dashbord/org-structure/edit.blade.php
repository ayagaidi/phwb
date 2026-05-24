@extends('layouts.app')

@section('title', __('admin.org_structure.edit_unit'))
@section('page-title', __('admin.org_structure.edit_unit'))

@section('content')
<div class="content-scroll">
  <div class="content">

    <!-- Header -->
    <div class="page-hdr">
      <div class="page-hdr-back">
        <a href="{{ route('admin.org-structure') }}" class="btn-back">
          <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none">
            <path d="M15 18l-6-6 6-6"></path>
          </svg>
        </a>
        <div>
          <h1>{{ __('admin.org_structure.edit_unit') }}</h1>
          <p>{{ __('admin.org_structure.edit_hint') }}</p>
        </div>
      </div>
    </div>

    <!-- Main Form Card -->
    <div class="glass-box p-8">
      <form method="POST" action="{{ route('admin.org-structure.update', $unit->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-grid">

          @if($unit->photo)
          <!-- Current Photo -->
          <div class="form-group grid-full">
            <label>{{ __('admin.org_structure.current_photo') }}</label>
            <div style="display: flex; gap: 12px; margin-bottom: 8px;">
              <div class="current-image-item" style="position: relative; width: 120px; height: 90px; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
                <img src="{{ asset('storage/' . $unit->photo) }}" style="width: 100%; height: 100%; object-fit: cover;">
                <button type="button"
                        class="remove-image-btn"
                        data-photo="{{ $unit->photo }}"
                        style="position: absolute; top: 4px; right: 4px;
                               background: #dc2626; color: white; border: none;
                               width: 26px; height: 26px; border-radius: 6px;
                               display: flex; align-items: center; justify-content: center;
                               cursor: pointer; box-shadow: 0 1px 3px rgba(0,0,0,0.3);"
                         title="{{ __('admin.org_structure.delete_photo') }}">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
          @endif

          <!-- New / Replacement Photo -->
          <div class="form-group grid-full">
            <label>{{ __('admin.org_structure.new_photo_optional') }}</label>
            <div id="image-dropzone" class="upload-zone">
              <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="1.5" fill="none">
                <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                <polyline points="21 15 16 10 5 21"></polyline>
              </svg>
              <p>{{ __('admin.org_structure.drag_drop') }}</p>
              <div id="selected-images-list" style="margin-top: 8px; font-size: 0.8rem; color: var(--muted);"></div>
            </div>
            <input type="file" name="photo" id="image-input" style="display:none;" accept="image/*">
            @error('photo')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- Hidden container for photo removal -->
          <div id="removed-photo-container" style="display:none;"></div>

          <!-- Arabic Name -->
          <div class="form-group grid-half">
            <label>{{ __('admin.org_structure.name_ar') }} <span class="text-red-500">*</span></label>
            <input type="text" name="name" class="field-input" value="{{ old('name', $unit->name) }}" required>
            @error('name')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- English Name -->
          <div class="form-group grid-half">
            <label>{{ __('admin.org_structure.name_en') }}</label>
            <input type="text" name="name_en" class="field-input" value="{{ old('name_en', $unit->name_en) }}">
          </div>

          <!-- Arabic Title -->
          <div class="form-group grid-half">
            <label>{{ __('admin.org_structure.title_ar') }}</label>
            <input type="text" name="title" class="field-input" value="{{ old('title', $unit->title) }}">
            @error('title')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- English Title -->
          <div class="form-group grid-half">
            <label>{{ __('admin.org_structure.title_en') }}</label>
            <input type="text" name="title_en" class="field-input" value="{{ old('title_en', $unit->title_en) }}">
          </div>

          <!-- Parent -->
          <div class="form-group grid-half">
            <label>{{ __('admin.org_structure.parent') }}</label>
            <select name="parent_id" class="field-input">
              <option value="">{{ __('admin.org_structure.no_parent') }}</option>
              @foreach($parents as $p)
                <option value="{{ $p->id }}" {{ old('parent_id', $unit->parent_id) == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
              @endforeach
            </select>
            @error('parent_id')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- Sort Order -->
          <div class="form-group grid-half">
            <label>{{ __('admin.org_structure.sort_order') }}</label>
            <input type="number" name="sort_order" class="field-input" value="{{ old('sort_order', $unit->sort_order) }}">
            @error('sort_order')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

        </div>

        <div class="form-footer mt-8">
          <button type="submit" class="btn btn-save">
            <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2.5" fill="none">
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            {{ __('admin.org_structure.save_changes') }}
          </button>
          <a href="{{ route('admin.org-structure') }}" class="btn btn-cancel">{{ __('admin.cancel') }}</a>
        </div>

      </form>
    </div>

  </div>
</div>
@endsection

@push('scripts')
<script>
  // Single file upload (same as create)
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

  // Current photo removal with SweetAlert confirmation
  document.querySelectorAll('.remove-image-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();

      const photoPath = this.dataset.photo;
      const wrapper = this.closest('.current-image-item');

      Swal.fire({
        title: '{{ __("admin.confirm.delete_title") }}',
        text: '{{ __("admin.org_structure.delete_photo_confirm") }}',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: '{{ __("admin.confirm.delete_button") }}',
        cancelButtonText: '{{ __("admin.confirm.cancel") }}'
      }).then((result) => {
        if (result.isConfirmed) {
          if (wrapper) {
            wrapper.style.opacity = '0.3';
            wrapper.style.pointerEvents = 'none';
          }

          const container = document.getElementById('removed-photo-container');
          if (container) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_photo';
            input.value = photoPath;
            container.appendChild(input);
          }

          this.disabled = true;
          this.style.opacity = '0.5';
        }
      });
    });
  });
</script>
@endpush
