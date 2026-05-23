@extends('layouts.app')

@section('title', __('admin.contact_settings.title'))
@section('page-title', __('admin.contact_settings.title'))

@section('content')
@if(session('success'))
  <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="form-layout">
  <div class="form-preview">
    <div class="form-preview-icon" style="background: var(--blue-light); color: var(--blue);">
      <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
    </div>
    <h3>{{ __('admin.contact_settings.title') }}</h3>
    <p>{{ __('admin.contact_settings.title') }}</p>
  </div>

  <div class="form-section">
    <form method="POST" action="{{ route('admin.contact-settings.update') }}">
      @csrf

      <div class="field-group">
        <label>{{ __('admin.contact_settings.phone') }}</label>
        <input type="text" name="phone" class="field-input" value="{{ $contact->phone }}">
      </div>

      <div class="field-group">
        <label>{{ __('admin.contact_settings.email') }}</label>
        <input type="email" name="email" class="field-input" value="{{ $contact->email }}">
      </div>

      <div class="field-group">
        <label>{{ __('admin.contact_settings.address_ar') }}</label>
        <textarea name="address_ar" class="field-input" rows="2">{{ $contact->address_ar }}</textarea>
      </div>

      <div class="field-group">
        <label>{{ __('admin.contact_settings.address_en') }}</label>
        <textarea name="address_en" class="field-input" rows="2">{{ $contact->address_en }}</textarea>
      </div>

      <div class="field-group">
        <label>{{ __('admin.contact_settings.whatsapp') }}</label>
        <input type="text" name="whatsapp" class="field-input" value="{{ $contact->whatsapp }}">
      </div>

      <div class="field-group">
        <label>{{ __('admin.contact_settings.facebook') }}</label>
        <input type="url" name="facebook" class="field-input" value="{{ $contact->facebook }}">
      </div>

      <div class="field-group">
        <label>{{ __('admin.contact_settings.instagram') }}</label>
        <input type="url" name="instagram" class="field-input" value="{{ $contact->instagram }}">
      </div>

      <div class="field-group">
        <label>{{ __('admin.contact_settings.working_hours_ar') }}</label>
        <input type="text" name="working_hours_ar" class="field-input" value="{{ $contact->working_hours_ar }}">
      </div>

      <div class="field-group">
        <label>{{ __('admin.contact_settings.working_hours_en') }}</label>
        <input type="text" name="working_hours_en" class="field-input" value="{{ $contact->working_hours_en }}">
      </div>

      <button type="submit" class="btn btn-primary" style="margin-top:1rem;">
        {{ __('admin.contact_settings.save_changes') }}
      </button>
    </form>
  </div>
</div>
@endsection
