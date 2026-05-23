@extends('layouts.app')

@section('title', __('admin.profile.title'))
@section('page-title', __('admin.profile.title'))

@section('content')
@if(session('success'))
  <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="form-layout">
  <div class="form-preview">
    <div class="form-preview-icon">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
        <circle cx="12" cy="7" r="4" />
      </svg>
    </div>
    <h3>{{ $user->name }}</h3>
    <p>{{ $user->email }}</p>
  </div>

  <div class="form-section">
    <h3 style="margin-bottom: 1rem;">{{ __('admin.profile.change_password') }}</h3>

    <form method="POST" action="{{ route('admin.profile.update-password') }}">
      @csrf
      @method('PUT')

      <div class="field-group">
        <label>{{ __('admin.profile.current_password') }}</label>
        <input type="password" name="current_password" class="field-input" required>
        @error('current_password')
          <span style="color: #dc2626; font-size: 0.875rem;">{{ $message }}</span>
        @enderror
      </div>

      <div class="field-group">
        <label>{{ __('admin.profile.new_password') }}</label>
        <input type="password" name="password" class="field-input" required minlength="6">
      </div>

      <div class="field-group">
        <label>{{ __('admin.profile.confirm_new_password') }}</label>
        <input type="password" name="password_confirmation" class="field-input" required>
      </div>

      <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">
        {{ __('admin.profile.save') }}
      </button>
    </form>
  </div>
</div>
@endsection
