@extends('layouts.app')

@section('title', __('admin.app_name') . ' | ' . __('admin.users.management'))
@section('page-title', __('admin.users.title'))

@section('content')
@if(session('success'))
  <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="stats-cards-row mb-4">
  <div class="stat-card-users">
    <div class="top">
      <div class="ic orange">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
      </div>
    </div>
    <p class="lbl">{{ __('admin.users.total_users') }}</p>
    <p class="val">{{ $users->count() }}</p>
  </div>
  <div class="stat-card-users">
    <div class="top">
      <div class="ic green">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
      </div>
      <span class="badge-pill">{{ $users->count() > 0 ? round(($users->where('is_active', true)->count() / $users->count()) * 100) : 0 }}%</span>
    </div>
    <p class="lbl">{{ __('admin.users.active') }}</p>
    <p class="val">{{ $users->where('is_active', true)->count() }}</p>
  </div>
  <div class="stat-card-users">
    <div class="top">
      <div class="ic red">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M15 9l-6 6"/><path d="M9 9l6 6"/></svg>
      </div>
      <span class="badge-pill" style="background:#f3f4f6;color:#6b7280;">{{ $users->count() > 0 ? round(($users->where('is_active', false)->count() / $users->count()) * 100) : 0 }}%</span>
    </div>
    <p class="lbl">{{ __('admin.users.inactive') }}</p>
    <p class="val">{{ $users->where('is_active', false)->count() }}</p>
  </div>
</div>

<div class="table-card">
  <div class="table-card-hdr">
    <h3 class="table-card-title">{{ __('admin.users.users_list') }}</h3>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary" style="display:inline-flex; align-items:center; gap:0.5rem; padding:0.65rem 1.35rem; border-radius:20px; background:var(--accent); color:#fff; font-size:0.875rem; font-weight:700; text-decoration:none;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      {{ __('admin.users.add_user') }}
    </a>
  </div>
  <div class="table-responsive">
    <table class="data-table">
      <thead>
        <tr>
          <th>#</th>
          <th>{{ __('admin.users.user') }}</th>
          <th class="tc">{{ __('admin.users.email') }}</th>
          <th class="tc">{{ __('admin.users.role') }}</th>
          <th class="tc">{{ __('admin.users.status') }}</th>
          <th class="tl">{{ __('admin.users.actions') }}</th>
        </tr>
      </thead>
      <tbody>
        @forelse($users as $index => $user)
          <tr>
            <td>{{ $index + 1 }}</td>
            <td>
              <div class="cell-name">
                <div class="cell-icon" style="background:var(--accent-light); color:var(--accent);">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <div>
                  <strong>{{ $user->name }}</strong>
                  @if($user->email)
                    <small>{{ $user->email }}</small>
                  @endif
                </div>
              </div>
            </td>
            <td class="tc">{{ $user->email }}</td>
            <td class="tc">
              <span class="badge badge-orange">{{ $user->role ?? __('admin.users.default_role') }}</span>
            </td>
            <td class="tc">
              @if($user->is_active)
                <span class="badge badge-green">{{ __('admin.users.active') }}</span>
              @else
                <span class="badge badge-gray">{{ __('admin.users.inactive') }}</span>
              @endif
            </td>
            <td>
              <div class="action-btns">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="icon-btn icon-btn-edit" title="{{ __('admin.users.edit') }}">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                </a>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="icon-btn" title="{{ __('admin.users.change_password') }}" style="color:#f59e0b;">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </a>
                @if($user->id !== 1)
                <a href="{{ route('admin.users.permissions', $user->id) }}" class="icon-btn" title="{{ __('admin.permissions.title') }}" style="color:#6366f1;">
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2z"/><path d="M12 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg>
                </a>
                @endif
                <form method="POST" action="{{ route('admin.users.toggle', $user->id) }}" style="display:inline;">
                  @csrf @method('PATCH')
                  <button type="submit" class="icon-btn {{ $user->is_active ? 'icon-btn-accept' : 'icon-btn-reject' }}" title="{{ $user->is_active ? __('admin.users.disable') : __('admin.users.enable') }}">
                    @if($user->is_active)
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
            <td colspan="6" style="text-align:center; padding:3rem; color:var(--muted);">
              {{ __('admin.users.no_users') }}
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
