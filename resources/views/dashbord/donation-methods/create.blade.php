@extends('layouts.app')

@section('title', 'صيادلة بلا حدود | إضافة طريقة تبرع')
@section('page-title', 'إضافة طريقة تبرع')

@section('content')
<div class="form-layout">
  <!-- Side Preview -->
  <div class="form-preview">
    <div class="form-preview-icon" style="background: var(--blue-light); color: var(--blue);">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20m10-10H2"/></svg>
    </div>
    <h3>طريقة تبرع جديدة</h3>
    <p>ستظهر للمتبرعين</p>

    <div class="preview-stats">
      <div class="preview-stat orange">
        <p>الحالة</p>
        <p>نشطة</p>
      </div>
    </div>
  </div>

  <!-- Form Section -->
  <div class="form-section">
    <form method="POST" action="{{ route('admin.donation-methods.store') }}">
      @csrf

      <div class="form-section-hdr">
        <div class="form-section-hdr-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </div>
        <h3>بيانات طريقة التبرع</h3>
      </div>

      <div class="field-group">
        <label>اسم الطريقة</label>
        <input type="text" name="name" class="field-input" value="{{ old('name') }}" required>
        @error('name')
          <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
        @enderror
      </div>

      <div class="field-group">
        <label>الوصف</label>
        <textarea name="description" class="field-input" rows="6" required>{{ old('description') }}</textarea>
        @error('description')
          <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
        @enderror
      </div>

      <div class="field-group">
        <label>الصورة</label>
        <div id="image-dropzone" class="dropzone" style="border:2px dashed #cbd5e1; border-radius:12px; background:#f8fafc; padding:2rem; text-align:center; cursor:pointer; min-height:140px; display:flex; align-items:center; justify-content:center; flex-direction:column; gap:0.5rem;">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
          <p style="margin:0; color:#64748b; font-size:0.95rem;">اسحب الصورة هنا أو اضغط للاختيار</p>
        </div>
        <input type="file" name="image" id="image-input" class="field-input" style="display:none;" accept="image/*">
        @error('image')
          <span style="color:#dc2626; font-size:0.875rem;">{{ $message }}</span>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.65rem 1.35rem; border-radius:20px; background:var(--accent); color:#fff; font-size:0.875rem; font-weight:700; border:none; cursor:pointer; margin-top:1rem;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        إضافة طريقة التبرع
      </button>
    </form>
  </div>
</div>

@push('scripts')
<script>
  const dropzone = document.getElementById('image-dropzone');
  const fileInput = document.getElementById('image-input');

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
