@extends('layouts.app')

@section('title', __('admin.app_name') . ' | ' . __('admin.users.add_new'))
@section('page-title', __('admin.users.add_new'))

@section('content')
<div class="page-hdr mb-4" style="display:flex; justify-content:space-between; align-items:center;">
  <div>
    <h1 style="margin:0;">{{ __('admin.users.add_new') }}</h1>
  </div>
  <a href="{{ route('admin.users') }}" class="btn btn-back" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.65rem 1.25rem; border-radius:16px; background:var(--surface); border:1px solid var(--border-gray); color:var(--muted); font-size:0.875rem; font-weight:700; text-decoration:none;">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
    {{ __('admin.users.back') }}
  </a>
</div>

<div class="form-layout">
  <!-- Side Preview -->
  <div class="form-preview">
    <div class="form-preview-icon">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
    </div>
    <h3>{{ __('admin.users.new_user') }}</h3>
    <p>{{ __('admin.users.add_description') }}</p>

    <div class="preview-stats">
      <div class="preview-stat orange">
        <p>{{ __('admin.users.role') }}</p>
        <p>{{ __('admin.users.role_set_on_create') }}</p>
      </div>
    </div>
  </div>

  <!-- Form Section -->
  <div class="form-section">
    <form method="POST" action="{{ route('admin.users.store') }}">
      @csrf

      <div class="form-section-hdr">
        <div class="form-section-hdr-icon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
        </div>
        <h3>{{ __('admin.users.user_data') }}</h3>
      </div>

      <div class="field-grid">
        <div class="field-group">
          <label>{{ __('admin.users.full_name') }} <span style="color:var(--red)">*</span></label>
          <input type="text" name="name" class="field-input" value="{{ old('name') }}" required>
        </div>

        <div class="field-group">
          <label>{{ __('admin.email') }} <span style="color:var(--red)">*</span></label>
          <input type="email" name="email" class="field-input" value="{{ old('email') }}" required>
        </div>

        <div class="field-group">
          <label>{{ __('admin.users.password') }} <span style="color:var(--red)">*</span></label>
          <input type="password" name="password" class="field-input" required>
        </div>

        <div class="field-group">
          <label>{{ __('admin.users.role') }}</label>
          <select name="role" class="field-input">
            <option value="admin">{{ __('admin.users.role_admin') }}</option>
            <option value="staff">{{ __('admin.users.role_staff') }}</option>
          </select>
        </div>
      </div>

      <button type="submit" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.65rem 1.35rem; border-radius:20px; background:var(--accent); color:#fff; font-size:0.875rem; font-weight:700; border:none; cursor:pointer;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        {{ __('admin.users.add_button') }}
      </button>
    </form>
  </div>
</div>
@endsection
