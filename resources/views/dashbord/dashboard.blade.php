@extends('layouts.app')

@section('title', __('admin.dashboard'))
@section('page-title', __('admin.dashboard'))

@section('content')
<div class="content">
    <!-- Welcome Header -->
    <div class="welcome-header">
        <h1>{{ __('admin.dash.welcome') }}</h1>
        <p>{{ __('admin.dash.subtitle') }}</p>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-blue-50 text-blue-600">
                <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">{{ __('admin.dash.stats.total_users') }}</span>
                <div class="stat-row">
                    <span class="stat-value">{{ $stats['total_users'] }}</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-green-50 text-green-600">
                <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">{{ __('admin.dash.stats.total_programs') }}</span>
                <div class="stat-row">
                    <span class="stat-value">{{ $stats['total_programs'] }}</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-purple-50 text-purple-600">
                <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">{{ __('admin.dash.stats.total_articles') }}</span>
                <div class="stat-row">
                    <span class="stat-value">{{ $stats['total_articles'] }}</span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-orange-50 text-orange-600">
                <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-info">
                <span class="stat-label">{{ __('admin.dash.stats.pending_memberships') }}</span>
                <div class="stat-row">
                    <span class="stat-value">{{ $stats['pending_memberships'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="merchant-split">
        <!-- Quick Info / Alerts -->
        <div class="merchant-sidebar-info">
            <div class="glass-box p-6 mb-6">
                <h3 class="box-title text-gray-800">
                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none" class="text-orange-500" style="display:inline-block; vertical-align:middle; margin-left:6px;">
                        <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    {{ __('admin.dash.alerts.title') }}
                </h3>
                <div class="alert-list">
                    @if($stats['pending_memberships'] > 0)
                    <div class="alert-item bg-yellow-50 text-yellow-800 border-yellow-100">
                        <div class="alert-dot bg-yellow-500"></div>
                        <div>
                            <p class="alert-title">{{ __('admin.dash.alerts.pending_memberships', ['count' => $stats['pending_memberships']]) }}</p>
                            <p class="alert-desc">{{ __('admin.dash.alerts.pending_desc') }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="alert-item bg-blue-50 text-blue-800 border-blue-100">
                        <div class="alert-dot bg-blue-500"></div>
                        <div>
                            <p class="alert-title">{{ __('admin.dash.published_content') }}</p>
                            <p class="alert-desc">
                                {{ __('admin.dash.programs_label') }}: {{ $stats['total_programs'] }} | 
                                {{ __('admin.dash.articles_label') }}: {{ $stats['total_articles'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Membership Applications -->
        <div class="merchant-main-table">
            <div class="glass-box no-p overflow-hidden">
                <div class="table-header-row">
                    <h3 class="box-title">{{ __('admin.dash.recent_applications') }}</h3>
                    <a href="{{ route('admin.membership-applications') }}" class="text-link">{{ __('admin.dash.view_all') }}</a>
                </div>

                @if($recentApplications->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>{{ __('admin.dash.table.name') }}</th>
                            <th>{{ __('admin.dash.table.email') }}</th>
                            <th>{{ __('admin.dash.table.type') }}</th>
                            <th>{{ __('admin.dash.table.date') }}</th>
                            <th>{{ __('admin.dash.table.status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentApplications as $app)
                        <tr>
                            <td class="font-bold">{{ $app->full_name }}</td>
                            <td>{{ $app->email }}</td>
                            <td>{{ $app->membership_type }}</td>
                            <td>{{ $app->created_at->format('Y-m-d') }}</td>
                            <td>
                                <span class="status-pill 
                                    @if($app->status === 'approved') status-active
                                    @elseif($app->status === 'rejected') status-red
                                    @else status-new @endif">
                                    @php
                                        $statusKey = $app->status ?? 'new';
                                        if (!in_array($statusKey, ['new','pending','approved','rejected'])) $statusKey = 'new';
                                    @endphp
                                    {{ __('admin.dash.status.' . $statusKey) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="p-6 text-center text-muted">
                    {{ __('admin.dash.no_applications') }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Charts Section (inspired by static demo) -->
    <div class="charts-grid" style="margin-top: 1.5rem;">
        
        <!-- Bar Chart: Monthly Applications -->
        <div class="chart-card">
            <div class="chart-card-hdr">
                <span class="chart-card-title">{{ __('admin.dash.charts.monthly_applications') }}</span>
            </div>
            <div class="bar-chart" aria-label="{{ __('admin.dash.charts.monthly_applications') }}">
                @php
                    $months = collect();
                    for ($i = 5; $i >= 0; $i--) {
                        $month = now()->subMonths($i)->format('Y-m');
                        $months->put($month, $monthlyApps[$month] ?? 0);
                    }
                    $max = $months->max() ?: 1;
                @endphp
                
                @foreach($months as $month => $count)
                    @php
                        $height = round(($count / $max) * 90) + 10;
                        $label = \Carbon\Carbon::createFromFormat('Y-m', $month)->locale(app()->getLocale())->isoFormat('MMM');
                    @endphp
                    <div class="bar" style="height: {{ $height }}%" title="{{ $label }}: {{ $count }}"></div>
                @endforeach
            </div>
            <div class="bar-labels">
                @foreach($months as $month => $count)
                    @php $label = \Carbon\Carbon::createFromFormat('Y-m', $month)->locale('ar')->isoFormat('MMM'); @endphp
                    <span class="bar-label">{{ $label }}</span>
                @endforeach
            </div>
        </div>

        <!-- Donut Chart: Membership Types -->
        <div class="chart-card">
            <h3 class="chart-card-title" style="margin-bottom: 1rem;">{{ __('admin.dash.charts.membership_distribution') }}</h3>
            
            @php
                $total = $membershipByType->sum();
                $full = $membershipByType['full_member'] ?? 0;
                $student = $membershipByType['student_member'] ?? 0;
                $supporter = $membershipByType['supporter'] ?? 0;
            @endphp

            <div class="donut-wrap">
                <svg class="donut-svg" viewBox="0 0 100 100">
                    @if($total > 0)
                        @php
                            $fullPerc = round(($full / $total) * 100);
                            $studentPerc = round(($student / $total) * 100);
                            $supporterPerc = 100 - $fullPerc - $studentPerc;
                            
                            $fullDash = ($fullPerc / 100) * 238;
                            $studentDash = ($studentPerc / 100) * 238;
                            $supporterDash = ($supporterPerc / 100) * 238;
                        @endphp
                        
                        <!-- Full Member -->
                        <circle cx="50" cy="50" r="38" fill="none" stroke="#10b981" stroke-width="12"
                                stroke-dasharray="{{ $fullDash }} 238" stroke-dashoffset="0" />
                        
                        <!-- Student -->
                        <circle cx="50" cy="50" r="38" fill="none" stroke="#3b82f6" stroke-width="12"
                                stroke-dasharray="{{ $studentDash }} 238" stroke-dashoffset="-{{ $fullDash }}" />
                        
                        <!-- Supporter -->
                        <circle cx="50" cy="50" r="38" fill="none" stroke="#f59e0b" stroke-width="12"
                                stroke-dasharray="{{ $supporterDash }} 238" stroke-dashoffset="-{{ $fullDash + $studentDash }}" />
                    @endif
                </svg>
                
                <div class="donut-center">
                    <span class="donut-center-val">{{ $total }}</span>
                    <span class="donut-center-lbl">{{ __('admin.dash.charts.total') }}</span>
                </div>
            </div>

            <div class="cat-legend">
                <div class="cat-legend-item">
                    <div style="display:flex;align-items:center;">
                        <span class="cat-dot" style="background:#10b981;"></span>
                        {{ __('admin.membership_applications.full_member') }}
                    </div>
                    <span style="font-weight:700;color:var(--muted)">{{ $fullPerc ?? 0 }}%</span>
                </div>
                <div class="cat-legend-item">
                    <div style="display:flex;align-items:center;">
                        <span class="cat-dot" style="background:#3b82f6;"></span>
                        {{ __('admin.membership_applications.student_member') }}
                    </div>
                    <span style="font-weight:700;color:var(--muted)">{{ $studentPerc ?? 0 }}%</span>
                </div>
                <div class="cat-legend-item">
                    <div style="display:flex;align-items:center;">
                        <span class="cat-dot" style="background:#f59e0b;"></span>
                        {{ __('admin.membership_applications.supporter') }}
                    </div>
                    <span style="font-weight:700;color:var(--muted)">{{ $supporterPerc ?? 0 }}%</span>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
