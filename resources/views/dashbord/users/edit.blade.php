@extends('layouts.app')

@section('title', 'صيادلة بلا حدود | تعديل مستخدم')
@section('page-title', 'تعديل المستخدم')

@section('content')
<div class="form-layout">
  <!-- Side Preview -->
  <div class="form-preview">
    <div class="form-preview-icon" style="background:{{ $user->is_active ? 'var(--green-light)' : 'var(--red-light)' }}; color:{{ $user->is_active ? 'var(--green)' : 'var(--red)' }};">
      @if($user->is_active)
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4 12 14.01l-3-3"/></svg>
      @else
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6"/><path d="M9 9l6 6"/></svg>
      @endif
    </div>
    <h3>{{ $user->name }}</h3>
    <p>{{ $user->email }}</p>

    <div class="preview-stats">
      <div class="preview-stat orange">
        <p>الدور</p>
        <p>{{ $user->role ?? 'مستخدم' }}</p>
      </div>
      <div class="preview-stat orange">
        <p>الحالة</p>
        <p>{{ $user->is_active ? 'نشط' : 'معطل' }}</p>
      </div>
    </div>
  </div>

  <!-- Form Section -->
  <div class="form-section">
    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
      @csrf @method('PUT')

      <div class="form-section-hdr">
        <div class="form-section-hdr-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
        </div>
        <h3>تعديل البيانات</h3>
      </div>

      <div class="field-grid">
        <div class="field-group">
          <label>الاسم الكامل</label>
          <input type="text" name="name" class="field-input" value="{{ $user->name }}" required>
        </div>

        <div class="field-group">
          <label>البريد الإلكتروني</label>
          <input type="email" name="email" class="field-input" value="{{ $user->email }}" required>
        </div>

        <div class="field-group">
          <label>الدور</label>
          <select name="role" class="field-input">
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>مدير</option>
            <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>موظف</option>
          </select>
        </div>
      </div>

      <button type="submit" class="btn-primary mt-4">حفظ التعديلات</button>
    </form>
  </div>
</div>
@endsection
