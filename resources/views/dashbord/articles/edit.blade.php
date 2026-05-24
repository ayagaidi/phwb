@extends('layouts.app')

@section('title', __('admin.app_name') . ' | ' . __('admin.articles.edit_article'))
@section('page-title', __('admin.articles.edit_article'))

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
           <h1>{{ __('admin.articles.edit_article') }}</h1>
           <p>{{ __('admin.articles.edit_hint') }}</p>
        </div>
      </div>
    </div>

    <!-- Main Form Card -->
    <div class="glass-box p-8">
      <form method="POST" action="{{ route('admin.articles.update', $article->id) }}" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="form-grid">

          @php
            $currentImages = $article->images ?? [];
            if ($article->image && empty($currentImages)) {
                $currentImages = [$article->image];
            }
          @endphp

          <!-- Current Images -->
          @if(!empty($currentImages))
          <div class="form-group grid-full">
            <label>الصور الحالية</label>
            <div style="display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 8px;">
              @foreach($currentImages as $img)
                <div class="current-image-item" style="position: relative; width: 120px; height: 90px; border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
                  <img src="{{ asset('storage/' . $img) }}" style="width: 100%; height: 100%; object-fit: cover;">
                   <button type="button" 
                           class="remove-image-btn"
                           data-image="{{ $img }}"
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
              @endforeach
            </div>
          </div>
          @endif

           <!-- New Images Upload -->
           <div class="form-group grid-full">
             <label>صور المقالة</label>
             <div id="image-dropzone" class="upload-zone">
               <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="1.5" fill="none">
                 <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                 <circle cx="8.5" cy="8.5" r="1.5"></circle>
                 <polyline points="21 15 16 10 5 21"></polyline>
               </svg>
               <p>اسحب الصور هنا أو اضغط للرفع</p>
               <div id="selected-images-list" style="margin-top: 8px; font-size: 0.8rem; color: var(--muted);"></div>
             </div>
             <input type="file" name="images[]" id="image-input" style="display:none;" accept="image/*" multiple>
             @error('images.*')
               <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
             @enderror
           </div>

           <!-- Hidden container for images to remove (always present) -->
           <div id="removed-images-container" style="display:none;"></div>

           <!-- Arabic Title -->
          <div class="form-group grid-half">
            <label>العنوان (عربي) <span class="text-red-500">*</span></label>
            <input type="text" name="title" class="field-input" value="{{ $article->title }}" required>
            @error('title')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- English Title -->
          <div class="form-group grid-half">
            <label>العنوان (إنجليزي)</label>
            <input type="text" name="title_en" class="field-input" value="{{ $article->title_en }}">
          </div>

          <!-- Arabic Content -->
          <div class="form-group grid-full">
            <label>المحتوى (عربي) <span class="text-red-500">*</span></label>
            <textarea name="content" class="field-input" rows="8" required>{{ $article->content }}</textarea>
            @error('content')
              <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
            @enderror
          </div>

          <!-- English Content -->
          <div class="form-group grid-full">
            <label>المحتوى (إنجليزي)</label>
            <textarea name="content_en" class="field-input" rows="8">{{ $article->content_en }}</textarea>
          </div>

        </div>

        <div class="form-footer mt-8">
          <button type="submit" class="btn btn-save">
            حفظ التعديلات
          </button>
          <a href="{{ route('admin.articles') }}" class="btn btn-cancel">{{ __('admin.cancel') }}</a>
        </div>

      </form>
    </div>

  </div>
</div>

@push('scripts')
<script>
  // New images upload (exact match to create.blade.php)
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
      cancelButtonText: 'إلغاء'
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

  // Current images removal with SweetAlert confirmation (for existing uploaded images)
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

          // Add hidden input so the controller knows to delete this image
          const container = document.getElementById('removed-images-container');
          if (container) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_images[]';
            input.value = imgPath;
            container.appendChild(input);
          }

          // Prevent further clicks
          this.disabled = true;
          this.style.opacity = '0.5';
        }
      });
    });
  });
</script>
@endpush
@endsection
