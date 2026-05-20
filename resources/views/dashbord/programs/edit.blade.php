@extends('layouts.app')

@section('title', 'تعديل البرنامج')
@section('page-title', 'تعديل البرنامج')

@push('scripts')
<script>
  const dropzone = document.getElementById('media-dropzone');
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

@section('content')
<div class="form-layout">
  <div class="form-preview">
    <h3>{{ $program->title }}</h3>
    @if($program->image)
      <div style="margin-top:1rem;">
        <img src="{{ asset('storage/' . $program->image) }}" width="120" style="border-radius:8px; border:1px solid #ddd;">
        <form action="{{ route('admin.programs.delete-image', $program->id) }}" method="POST" style="margin-top:8px;">
          @csrf @method('DELETE')
          <button type="submit" class="icon-btn danger" style="font-size:12px;">حذف الصورة</button>
        </form>
      </div>
    @endif
  </div>

  <div class="form-section">
    <form method="POST" action="{{ route('admin.programs.update', $program->id) }}" enctype="multipart/form-data">
      @csrf @method('PUT')
      <div class="field-group">
        <label>العنوان</label>
        <input type="text" name="title" class="field-input" value="{{ $program->title }}" required>
      </div>
      <div class="field-group">
        <label>الوصف</label>
        <textarea name="description" class="field-input" rows="4" required>{{ $program->description }}</textarea>
      </div>

      <div class="field-group">
        <label>صورة جديدة</label>
        <div id="media-dropzone" class="dropzone" style="border:2px dashed #cbd5e1; border-radius:12px; background:#f8fafc; padding:1.5rem; text-align:center; cursor:pointer;">
          <p>اسحب الصورة هنا أو اضغط للاختيار</p>
        </div>
        <input type="file" name="image" id="image-input" style="display:none;">
      </div>

      <div class="field-group">
        <label>رابط فيديو</label>
        <input type="url" name="video_url" class="field-input" value="{{ $program->video_url }}">
      </div>

      <button type="submit" class="btn btn-primary" style="margin-top:1rem;">حفظ التعديلات</button>
    </form>
  </div>
</div>
@endsection
