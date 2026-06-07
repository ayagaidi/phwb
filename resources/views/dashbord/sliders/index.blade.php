@extends('layouts.app')

@section('title', __('admin.sliders.management'))
@section('page-title', __('admin.sliders.title'))

@section('content')
<div class="stats-cards-row mb-4">
  <div class="stat-card-users">
    <div class="top">
      <div class="ic orange">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
      </div>
    </div>
    <p class="lbl">{{ __('admin.sliders.total') }}</p>
    <p class="val">{{ $sliders->count() }}</p>
  </div>
  <div class="stat-card-users">
    <div class="top">
      <div class="ic green">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
      </div>
      <span class="badge-pill">{{ $sliders->count() > 0 ? round(($sliders->where('is_published', true)->count() / $sliders->count()) * 100) : 0 }}%</span>
    </div>
    <p class="lbl">{{ __('admin.sliders.published') }}</p>
    <p class="val">{{ $sliders->where('is_published', true)->count() }}</p>
  </div>
  <div class="stat-card-users">
    <div class="top">
      <div class="ic red">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6"/><path d="M9 9l6 6"/></svg>
      </div>
      <span class="badge-pill" style="background:#f3f4f6;color:#6b7280;">{{ $sliders->count() > 0 ? round(($sliders->where('is_published', false)->count() / $sliders->count()) * 100) : 0 }}%</span>
    </div>
    <p class="lbl">{{ __('admin.sliders.unpublished') }}</p>
    <p class="val">{{ $sliders->where('is_published', false)->count() }}</p>
  </div>
</div>

<div class="table-card">
  <div class="table-card-hdr">
    <h3 class="table-card-title">{{ __('admin.sliders.sliders_list') }}</h3>
    <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.65rem 1.35rem; border-radius:20px; background:var(--accent); color:#fff; font-size:0.875rem; font-weight:700; text-decoration:none;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      {{ __('admin.sliders.add_slider') }}
    </a>
  </div>
  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>{{ __('admin.sliders.image') }}</th>
          <th>{{ __('admin.sliders.status') }}</th>
          <th class="tl">{{ __('admin.sliders.actions') }}</th>
        </tr>
      </thead>
      <tbody>
        @forelse($sliders as $index => $slider)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>
              @if($slider->image)
                <img src="{{ asset('storage/' . $slider->image) }}" width="120" height="80" style="object-fit:cover; border-radius:8px;">
              @else
                <span style="color:var(--muted);">{{ __('admin.sliders.no_image') }}</span>
              @endif
            </td>
            <td>
              @if($slider->is_published)
                <span class="badge badge-green">{{ __('admin.sliders.published_badge') }}</span>
              @else
                <span class="badge badge-gray">{{ __('admin.sliders.unpublished_badge') }}</span>
              @endif
            </td>
            <td>
              <div class="action-btns">
                <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="icon-btn icon-btn-edit" title="{{ __('admin.sliders.edit') }}">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                </a>
                <form method="POST" action="{{ route('admin.sliders.toggle', $slider->id) }}" style="display:inline;">
                  @csrf @method('PATCH')
                  <button type="submit" class="icon-btn {{ $slider->is_published ? 'icon-btn-accept' : 'icon-btn-reject' }}" title="{{ $slider->is_published ? __('admin.sliders.unpublish') : __('admin.sliders.publish') }}">
                    @if($slider->is_published)
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6"/><path d="M9 9l6 6"/></svg>
                    @else
                      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
                    @endif
                  </button>
                </form>
                <form method="POST" action="{{ route('admin.sliders.destroy', $slider->id) }}" style="display:inline;" onsubmit="return confirm('{{ __("admin.confirm_delete") }}')">
                  @csrf @method('DELETE')
                  <button type="submit" class="icon-btn icon-btn-delete" title="{{ __('admin.sliders.delete') }}">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6V20a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" y2="17"/><line x1="14" y1="11" y2="17"/></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4" style="text-align:center; padding:3rem; color:var(--muted);">{{ __('admin.sliders.no_sliders') }}</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection