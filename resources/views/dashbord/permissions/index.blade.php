@extends('layouts.app')

@section('title', __('admin.app_name') . ' | ' . __('admin.permissions.title'))
@section('page-title', __('admin.permissions.title'))

@section('content')
<div class="content" style="max-width: 900px; margin: 0 auto;">
    <div class="glass-box" style="padding: 2rem;">
        <p style="color: var(--muted); margin-bottom: 2rem; font-size: 0.95rem;">
            {{ __('admin.permissions.description') }}
        </p>

        <div style="display: grid; gap: 1rem;">
            @foreach($sections as $section => $actions)
                @php
                    $labelKey = 'admin.nav.' . $section;
                    $label = __($labelKey);
                    if ($label === $labelKey) {
                        $label = ucwords(str_replace('-', ' ', $section));
                    }
                @endphp
                <div style="background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 1.25rem;">
                    <div style="font-weight: 700; margin-bottom: 0.5rem; font-size: 0.95rem; color: #111827;">
                        {{ $label }}
                    </div>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.4rem;">
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
                            <span style="padding: 0.3rem 0.75rem; background: #fff; border: 1px solid #d1d5db; border-radius: 9999px; font-size: 0.8rem; font-weight: 600; color: #374151;">
                                {{ $actionLabel }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
