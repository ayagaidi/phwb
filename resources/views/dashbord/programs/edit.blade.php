@extends('layouts.app')

@section('title', __('admin.programs.edit_program'))
@section('page-title', __('admin.programs.edit_program'))

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
          <h1>تعديل البرنامج</h1>
          <p>قم بتحديث بيانات البرنامج</p>
        </div>
      </div>
    </div>

    <!-- Main Form Card -->
    <div class="glass-box p-8">
      <form method="POST" action="{{ route('admin.programs.update', $program->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-grid">

          @if($program->image)
          <!-- Current Image -->
          <div class="form-group grid-full">
            <label>الصورة الحالية</label>
            <div style="display: flex; gap: 12px; margin-bottom: 8px;">
              <div class="current-image-item" style="position: relative; width: 120px; height: 90px; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
                <img src="{{ asset('storage/' . $program->image) }}" style="width: 100%; height: 100%; object-fit: cover;">
                <button type="button"
                        class="remove-image-btn"
                        data-image="{{ $program->image }}"
                        style="position: absolute; top: 4px; right: 4px;
                               background: #dc2626; color: white; border: none;
                               width: 26px; height: 26px; border-radius: 6px;
                               display: flex; align-items: center; justify-content: center;
                               cursor: pointer; box-shadow: 0 1px 3px rgba(0,0,0,0.3);"
                        title="حذف الصورة">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
          @endif

          <!-- New / Replacement Image -->
          <div class="form-group grid-full">
            <label>صورة جديدة (اختياري)</label>
            <div id="image-dropzone" class="upload-zone">
              <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="1.5" fill="none">
                <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                <polyline points="21 15 16 10 5 21"></polyline>
              </svg>
              <p>اسحب الصورة هنا أو اضغط للرفع</p>
              <div id="selected-images-list" style="margin-top: 8px; font-size: 0.8rem; color: var(--muted);"></div>
            </div>
            <input type="file" name="image" id="image-input" style="display:none;" accept="image/*">
            @error('image')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- Hidden container for image removal -->
          <div id="removed-image-container" style="display:none;"></div>

          <!-- Video URL -->
          <div class="form-group grid-full">
            <label>رابط فيديو يوتيوب (اختياري)</label>
            <input type="url" name="video_url" class="field-input" value="{{ old('video_url', $program->video_url) }}" placeholder="https://www.youtube.com/watch?v=...">
            @error('video_url')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- Arabic Title -->
          <div class="form-group grid-half">
            <label>العنوان (عربي) <span class="text-red-500">*</span></label>
            <input type="text" name="title" class="field-input" value="{{ old('title', $program->title) }}" required>
            @error('title')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- English Title -->
          <div class="form-group grid-half">
            <label>العنوان (إنجليزي)</label>
            <input type="text" name="title_en" class="field-input" value="{{ old('title_en', $program->title_en) }}">
          </div>

          <!-- Arabic Description -->
          <div class="form-group grid-full">
            <label>الوصف (عربي) <span class="text-red-500">*</span></label>
            <textarea name="description" class="field-input" rows="4" required>{{ old('description', $program->description) }}</textarea>
            @error('description')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- English Description -->
          <div class="form-group grid-full">
            <label>الوصف (إنجليزي)</label>
            <textarea name="description_en" class="field-input" rows="4">{{ old('description_en', $program->description_en) }}</textarea>
          </div>

        </div>

        <div class="form-footer mt-8">
          <button type="submit" class="btn btn-save">
            <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2.5" fill="none">
              <line x1="12" y1="5" x2="12" y2="19"></line>
              <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            حفظ التعديلات
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
  // New image upload (single file, identical to create)
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

  // Current image removal with SweetAlert confirmation
  document.querySelectorAll('.remove-image-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();

      const imgPath = this.dataset.image;
      const wrapper = this.closest('.current-image-item');

      Swal.fire({
        title: 'هل أنت متأكد؟',
        text: 'هل تريد حذف هذه الصورة؟',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'نعم، احذفها',
        cancelButtonText: 'إلغاء'
      }).then((result) => {
        if (result.isConfirmed) {
          if (wrapper) {
            wrapper.style.opacity = '0.3';
            wrapper.style.pointerEvents = 'none';
          }

          const container = document.getElementById('removed-image-container');
          if (container) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_image';
            input.value = imgPath;
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
