@extends('site.layouts.app')

@section('title', __('site.org.title') . ' | ' . __('site.footer.org_name'))

@section('content')
<div class="max-w-7xl mx-auto px-6 py-14">
    <div class="text-center mb-10">
        <span class="px-4 py-1 bg-[#1cc6aa]/10 text-[#29225c] text-sm font-medium rounded-full">{{ __('site.org.badge') }}</span>
        <h1 class="text-4xl font-bold mt-3">{{ __('site.org.title') }}</h1>
        <p class="text-gray-600 mt-2 max-w-md mx-auto">{{ __('site.org.subtitle') }}</p>
    </div>

    <div class="org-chart-wrapper-public">
        <div class="org-chart-public" dir="ltr">
            @forelse($units as $unit)
                <x-org-chart-node :unit="$unit" :readonly="true" />
            @empty
                <div class="text-center py-12 text-gray-500">
                    {{ __('site.org.no_data') }}
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    /* Public Org Chart Styles (based on admin horizontal chart, enlarged for readability) */
    .org-chart-wrapper-public {
        background: #f8fafc;
        padding: 2rem 1rem;
        border-radius: 16px;
        overflow-x: auto;
        border: 1px solid #e2e8f0;
    }

    .org-chart-public {
        display: flex;
        justify-content: center;
        min-width: max-content;
    }

    .org-node-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        margin: 0 4px;
    }

    .org-node {
        background: white;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        padding: 10px 14px;
        min-width: 160px;
        text-align: center;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        z-index: 2;
    }

    .org-node-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .org-photo {
        width: 52px;
        height: 52px;
        border-radius: 9999px;
        object-fit: cover;
        border: 2px solid #e0f2fe;
        background: #f1f5f9;
    }

    .org-photo.placeholder {
        background: #dbeafe;
        color: #29225c;
        font-weight: 700;
        font-size: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .org-info {
        text-align: center;
    }

    .org-name {
        font-weight: 700;
        font-size: 14px;
        color: #1e293b;
        line-height: 1.3;
    }

    .org-title {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }

    /* .org-actions are omitted entirely when readonly=true in the component */

    /* Horizontal children row */
    .org-children-row {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 10px;
        position: relative;
        padding-top: 8px;
    }

    .org-node-wrapper > .org-children-row::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: 8px;
        background: #94a3b8;
    }

    .org-children-row::after {
        content: '';
        position: absolute;
        top: 8px;
        left: 4px;
        right: 4px;
        height: 2px;
        background: #94a3b8;
        z-index: 1;
    }

    .org-children-row > .org-node-wrapper::before {
        content: '';
        position: absolute;
        top: -8px;
        left: 50%;
        width: 2px;
        height: 8px;
        background: #94a3b8;
        z-index: 1;
    }
</style>
@endsection
