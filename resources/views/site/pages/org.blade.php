@extends('site.layouts.app')

@section('title', __('site.org.title') . ' | ' . __('site.footer.org_name'))

@section('content')
<!-- Hero Header -->
<div class="bg-gradient-to-b from-[#29225c] to-[#372d70] text-white py-16">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <div class="inline-flex items-center gap-x-2 bg-white/10 px-4 py-1 rounded-full text-sm mb-4">
            <i class="fas fa-sitemap"></i>
            <span>{{ __('site.org.badge') }}</span>
        </div>
        <h1 class="text-5xl font-bold tracking-tight">{{ __('site.org.title') }}</h1>
        <p class="mt-3 text-xl text-[#1cc6aa] max-w-xl mx-auto">{{ __('site.org.subtitle') }}</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-6 -mt-8 pb-16">
    <div class="org-chart-wrapper-public bg-white rounded-3xl shadow-2xl border border-gray-100 p-8 md:p-10 overflow-x-auto">
        <div class="org-chart-public flex justify-center min-w-max" dir="ltr">
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
    /* Beautiful compact Public Org Chart - smaller sizes so all units fit neatly in order */
    .org-chart-public {
        display: flex;
        justify-content: center;
        min-width: max-content;
        padding: 8px 2px;
    }

    .org-node-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        margin: 0 6px;
    }

    .org-node {
        background: white;
        border: 1.5px solid #e0f2fe;
        border-radius: 12px;
        padding: 9px 11px;
        min-width: 148px;
        text-align: center;
        box-shadow: 0 6px 10px -2px rgb(0 0 0 / 0.08), 0 3px 4px -2px rgb(0 0 0 / 0.08);
        z-index: 2;
        transition: all 0.25s cubic-bezier(0.4, 0.0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .org-node::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3.5px;
        background: linear-gradient(to right, #29225c, #1cc6aa);
    }

    .org-node:hover {
        transform: translateY(-3px) scale(1.01);
        box-shadow: 0 15px 25px -8px rgb(0 0 0 / 0.12);
        border-color: #1cc6aa;
    }

    .org-node-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        padding-top: 2px;
    }

    .org-photo {
        width: 46px;
        height: 46px;
        border-radius: 9999px;
        object-fit: cover;
        border: 2px solid #1cc6aa;
        background: #f8fafc;
        box-shadow: 0 2px 4px -1px rgb(0 0 0 / 0.1);
        transition: transform 0.25s ease;
    }

    .org-node:hover .org-photo {
        transform: scale(1.06);
    }

    .org-photo.placeholder {
        background: linear-gradient(145deg, #29225c, #1e293b);
        color: white;
        font-weight: 700;
        font-size: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #1cc6aa;
        letter-spacing: 0.5px;
    }

    .org-info {
        text-align: center;
    }

    .org-name {
        font-weight: 700;
        font-size: 13px;
        color: #1e293b;
        line-height: 1.15;
        letter-spacing: -0.1px;
    }

    .org-title {
        font-size: 10px;
        color: #475569;
        margin-top: 1px;
        line-height: 1.25;
        font-weight: 500;
    }

    /* Horizontal children row - tighter for better order */
    .org-children-row {
        display: flex;
        justify-content: center;
        gap: 6px;
        margin-top: 8px;
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
        background: linear-gradient(to bottom, #1cc6aa, #29225c);
        border-radius: 999px;
        z-index: 1;
    }

    .org-children-row::after {
        content: '';
        position: absolute;
        top: 8px;
        left: 6px;
        right: 6px;
        height: 2px;
        background: linear-gradient(to right, #1cc6aa, #29225c);
        z-index: 1;
        border-radius: 999px;
    }

    .org-children-row > .org-node-wrapper::before {
        content: '';
        position: absolute;
        top: -8px;
        left: 50%;
        width: 2px;
        height: 8px;
        background: linear-gradient(to bottom, #29225c, #1cc6aa);
        z-index: 1;
        border-radius: 999px;
    }
</style>
@endsection
