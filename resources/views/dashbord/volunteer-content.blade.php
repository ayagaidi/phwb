@extends('layouts.app')

@section('title', __('admin.app_name') . ' | ' . __('admin.volunteer.page_title'))
@section('page-title', __('admin.volunteer.page_title'))

@section('content')
<div class="content-scroll">
  <div class="content">

    <!-- Header -->
    <div class="page-hdr">
      <div class="page-hdr-back">
        <a href="{{ route('admin.dashboard') }}" class="btn-back">
          <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none">
            <path d="M15 18l-6-6 6-6"></path>
          </svg>
        </a>
        <div>
          <h1>{{ __('admin.volunteer.title') }}</h1>
          <p>{{ __('admin.volunteer.page_title') }}</p>
        </div>
      </div>
    </div>

    <!-- Main Form -->
    <div class="glass-box p-8">
      <form method="POST" action="{{ route('admin.volunteer-content.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">

          <!-- Arabic Section -->
          <div class="form-group grid-full">
            <h5 style="margin-bottom: 12px; color: #334155; font-size: 1rem;">النسخة العربية</h5>
          </div>

          <div class="form-group grid-full">
            <label>{{ __('admin.volunteer.hero_title') }}</label>
            <input type="text" name="hero_title" class="field-input" value="{{ $content->hero_title }}" required>
          </div>

          <div class="form-group grid-full">
            <label>{{ __('admin.volunteer.hero_desc') }}</label>
            <textarea name="hero_desc" class="field-input" rows="3">{{ $content->hero_desc }}</textarea>
          </div>

          <div class="form-group grid-full">
            <label>{{ __('admin.volunteer.opportunities') }}</label>
            <textarea name="opportunities" class="field-input" rows="5">{{ $content->opportunities }}</textarea>
          </div>

          <!-- English Section -->
          <div class="form-group grid-full" style="margin-top: 16px;">
            <h5 style="margin-bottom: 12px; color: #334155; font-size: 1rem;">النسخة الإنجليزية</h5>
          </div>

          <div class="form-group grid-full">
            <label>{{ __('admin.volunteer.hero_title_en') }}</label>
            <input type="text" name="hero_title_en" class="field-input" value="{{ $content->hero_title_en }}">
          </div>

          <div class="form-group grid-full">
            <label>{{ __('admin.volunteer.hero_desc_en') }}</label>
            <textarea name="hero_desc_en" class="field-input" rows="3">{{ $content->hero_desc_en }}</textarea>
          </div>

          <div class="form-group grid-full">
            <label>{{ __('admin.volunteer.opportunities_en') }}</label>
            <textarea name="opportunities_en" class="field-input" rows="5">{{ $content->opportunities_en }}</textarea>
          </div>

          <!-- Banner Image -->
          <div class="form-group grid-full">
            <label>{{ __('admin.volunteer.banner_image') }}</label>

            @if($content->banner_image)
              <div style="margin-bottom: 12px;">
                <img src="{{ asset('storage/' . $content->banner_image) }}" 
                     style="max-height: 140px; border-radius: 8px; border: 1px solid #e2e8f0; display: block;">
              </div>
            @endif

            <div id="banner-dropzone" class="upload-zone">
              <svg viewBox="0 0 24 24" width="32" height="32" stroke="currentColor" stroke-width="1.5" fill="none">
                <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                <polyline points="21 15 16 10 5 21"></polyline>
              </svg>
              <p>{{ __('admin.volunteer.drag_drop') }}</p>
            </div>
            <input type="file" name="banner_image" id="banner-input" style="display:none;" accept="image/*">
          </div>

        </div>

        <div class="form-footer mt-8">
          <button type="submit" class="btn btn-save">
            {{ __('admin.volunteer.save_changes') }}
          </button>
          <a href="{{ route('admin.dashboard') }}" class="btn btn-cancel">{{ __('admin.cancel') }}</a>
        </div>

      </form>
    </div>

  </div>
</div>

@push('scripts')
<script>
  // Banner image dropzone (same style as articles)
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
        const dt = new DataTransfer();
        dt.items.add(e.dataTransfer.files[0]);
        fileInput.files = dt.files;
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
