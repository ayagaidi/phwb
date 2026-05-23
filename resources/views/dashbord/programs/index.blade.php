@extends('layouts.app')

@section('title', __('admin.app_name') . ' | ' . __('admin.programs.management'))
@section('page-title', __('admin.programs.title'))

@section('content')
<!-- Stats -->
<div class="stats-cards-row mb-4">
  <div class="stat-card-users">
    <div class="top">
      <div class="ic orange">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20m10-10H2"/></svg>
      </div>
    </div>
    <p class="lbl">{{ __('admin.programs.total_programs') }}</p>
    <p class="val">{{ $programs->count() }}</p>
  </div>
  <div class="stat-card-users">
    <div class="top">
      <div class="ic green">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
      </div>
      <span class="badge-pill">{{ $programs->count() > 0 ? round(($programs->where('is_published', true)->count() / $programs->count()) * 100) : 0 }}%</span>
    </div>
    <p class="lbl">{{ __('admin.programs.published') }}</p>
    <p class="val">{{ $programs->where('is_published', true)->count() }}</p>
  </div>
  <div class="stat-card-users">
    <div class="top">
      <div class="ic red">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6"/><path d="M9 9l6 6"/></svg>
      </div>
      <span class="badge-pill" style="background:#f3f4f6;color:#6b7280;">{{ $programs->count() > 0 ? round(($programs->where('is_published', false)->count() / $programs->count()) * 100) : 0 }}%</span>
    </div>
    <p class="lbl">{{ __('admin.programs.unpublished') }}</p>
    <p class="val">{{ $programs->where('is_published', false)->count() }}</p>
  </div>
</div>

<div class="table-card">
  <div class="table-card-hdr">
    <h3 class="table-card-title">{{ __('admin.programs.programs_list') }}</h3>
    <a href="{{ route('admin.programs.create') }}" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.65rem 1.35rem; border-radius:20px; background:var(--accent); color:#fff; font-size:0.875rem; font-weight:700; text-decoration:none;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      {{ __('admin.programs.add_program') }}
    </a>
  </div>
  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>{{ __('admin.programs.program') }}</th>
          <th class="tc">{{ __('admin.programs.status') }}</th>
          <th class="tl">{{ __('admin.programs.actions') }}</th>
        </tr>
      </thead>
      <tbody>
        @forelse($programs as $index => $program)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>
              <div class="cell-name">
                @if($program->image)
                  <img src="{{ asset('storage/' . $program->image) }}" width="40" height="40" style="object-fit:cover; border-radius:8px; margin-left:8px;">
                @else
                  <div class="cell-icon" style="background:var(--accent-light); color:var(--accent);">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20m10-10H2"/></svg>
                  </div>
                @endif
                <div>
                  @php
                    $progTitle = app()->getLocale() === 'en' && $program->title_en ? $program->title_en : $program->title;
                    $progDesc  = app()->getLocale() === 'en' && $program->description_en ? $program->description_en : $program->description;
                  @endphp
                  <strong>{{ $progTitle }}</strong>
                  <small>{{ Str::limit($progDesc, 50) }}</small>
                </div>
              </div>
            </td>
            <td class="tc">
              @if($program->is_published)
                <span class="badge badge-green">{{ __('admin.programs.published_badge') }}</span>
              @else
                <span class="badge badge-gray">{{ __('admin.programs.unpublished_badge') }}</span>
              @endif
            </td>
            <td>
              <div class="action-btns">
                <a href="{{ route('admin.programs.edit', $program->id) }}" class="icon-btn icon-btn-edit" title="{{ __('admin.programs.edit') }}">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                </a>
                <form method="POST" action="{{ route('admin.programs.toggle', $program->id) }}" style="display:inline;">
                  @csrf @method('PATCH')
                  <button type="submit" class="icon-btn {{ $program->is_published ? 'icon-btn-accept' : 'icon-btn-reject' }}" title="{{ $program->is_published ? __('admin.programs.unpublish') : __('admin.programs.publish') }}">
                    @if($program->is_published)
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6"/><path d="M9 9l6 6"/></svg>
                    @else
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    @endif
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" style="text-align:center; padding:3rem; color:var(--muted);">{{ __('admin.programs.no_programs') }}</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
