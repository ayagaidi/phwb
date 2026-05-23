@extends('layouts.app')

@section('title', __('admin.app_name') . ' | ' . __('admin.users.edit_user'))
@section('page-title', __('admin.users.edit_user'))

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
        <p>{{ __('admin.users.role') }}</p>
        <p>{{ $user->role ?? __('admin.users.default_role') }}</p>
      </div>
      <div class="preview-stat orange">
        <p>{{ __('admin.users.status') }}</p>
        <p>{{ $user->is_active ? __('admin.users.active') : __('admin.users.inactive') }}</p>
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
        <h3>{{ __('admin.users.edit_data') }}</h3>
      </div>

      <div class="field-grid">
        <div class="field-group">
          <label>{{ __('admin.users.full_name') }}</label>
          <input type="text" name="name" class="field-input" value="{{ $user->name }}" required>
        </div>

        <div class="field-group">
          <label>{{ __('admin.email') }}</label>
          <input type="email" name="email" class="field-input" value="{{ $user->email }}" required>
        </div>

        <div class="field-group">
          <label>{{ __('admin.users.role') }}</label>
          <select name="role" class="field-input">
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>{{ __('admin.users.role_admin') }}</option>
            <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>{{ __('admin.users.role_staff') }}</option>
          </select>
        </div>
      </div>

      <button type="submit" class="btn-primary mt-4">{{ __('admin.users.save_changes') }}</button>
    </form>
  </div>
</div>
@endsection
