@extends('layouts.app')

@section('title', __('admin.app_name') . ' | ' . __('admin.permissions.title'))
@section('page-title', __('admin.permissions.title'))

@section('content')
<div class="content" style="max-width: 800px; margin: 0 auto;">
    <div class="glass-box" style="padding: 2rem;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 1px solid #e5e7eb;">
            <div style="width: 48px; height: 48px; border-radius: 12px; background: var(--accent-light); color: var(--accent); display: flex; align-items: center; justify-content: center;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2z"/>
                    <path d="M12 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                </svg>
            </div>
            <div>
                <h2 style="margin: 0; font-size: 1.25rem; font-weight: 700;">{{ __('admin.permissions.assign_for', ['name' => $user->name]) }}</h2>
                <p style="margin: 0.25rem 0 0; color: var(--muted); font-size: 0.875rem;">{{ $user->email }}</p>
            </div>
        </div>

        @if($user->role === 'owner')
            <div style="background: #fef3c7; border: 1px solid #fcd34d; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem; color: #92400e; font-size: 0.875rem;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline; vertical-align: middle; margin-left: 6px;">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                {{ __('admin.permissions.owner_all_permissions') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.permissions.update', $user->id) }}">
            @csrf
            @method('PUT')

            <div style="display: grid; gap: 1.5rem;">
                @foreach($sections as $sectionKey => $actions)
                    <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1.25rem;">
                        <div style="font-weight: 600; margin-bottom: 0.75rem; font-size: 0.95rem; color: #111827;">
                            @php
                                $sectionLabelKey = 'admin.nav.' . $sectionKey;
                                $sectionLabel = __($sectionLabelKey);
                                if ($sectionLabel === $sectionLabelKey) {
                                    $sectionLabel = ucwords(str_replace('-', ' ', $sectionKey));
                                }
                            @endphp
                            {{ $sectionLabel }}
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                            @foreach($actions as $action)
                                @php
                                    $actionLabelKey = 'admin.permissions.actions.' . $action;
                                    $actionLabel = __($actionLabelKey);
                                    if ($actionLabel === $actionLabelKey) {
                                        $actionLabels = [
                                            'view' => 'عرض',
                                            'create' => 'إضافة',
                                            'edit' => 'تعديل',
                                            'delete' => 'حذف',
                                            'update' => 'تحديث',
                                            'export' => 'تصدير',
                                        ];
                                        $actionLabel = $actionLabels[$action] ?? $action;
                                    }
                                @endphp
                                <label style="display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.375rem 0.75rem; background: #fff; border: 1px solid #d1d5db; border-radius: 9999px; font-size: 0.8rem; cursor: pointer; user-select: none;">
                                    <input type="checkbox"
                                           name="permissions[{{ $sectionKey }}][]"
                                           value="{{ $action }}"
                                           class="permission-checkbox"
                                        @if(in_array($action, $userPermissions[$sectionKey] ?? [])) checked @endif
                                        @if($user->role === 'owner') disabled checked @endif
                                    />
                                    <span>{{ $actionLabel }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="display: flex; gap: 0.75rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
                <button type="submit" class="btn btn-primary" style="padding: 0.65rem 1.5rem; border-radius: 12px; background: var(--accent); color: #fff; font-weight: 700; font-size: 0.875rem; border: none; cursor: pointer;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="display: inline; vertical-align: middle; margin-left: 4px;">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    {{ __('admin.permissions.save') }}
                </button>
                <a href="{{ route('admin.users') }}" class="btn" style="padding: 0.65rem 1.5rem; border-radius: 12px; background: #f3f4f6; color: #374151; font-weight: 600; font-size: 0.875rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.375rem;">
                    {{ __('admin.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
