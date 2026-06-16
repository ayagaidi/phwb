@extends('site.layouts.app')

@section('title', __('site.contact.title') . ' | ' . __('site.footer.org_name'))

@section('content')
@php
$locale = app()->getLocale();
$addrKey = 'address_' . $locale;
$whKey = 'working_hours_' . $locale;
$addressVal = $contact->{$addrKey} ?? $contact->address_ar ?? __('site.contact.not_available');
$workingVal = $contact->{$whKey} ?? $contact->working_hours_ar ?? __('site.contact.not_available');
$mapAddress = $contact->{$addrKey} ?? $contact->address_ar ?? __('site.contact.location_label');
@endphp
<!-- Hero Header -->
<div class="bg-gradient-to-b from-[#1cc6aa] to-[#1cc6aa] text-white py-16">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <div class="inline-flex items-center gap-x-2 bg-white/10 px-4 py-1 rounded-full text-sm mb-4">
            <i class="fas fa-headset"></i>
            <span>{{ __('site.contact.hero_badge') }}</span>
        </div>
        <h1 class="text-5xl font-bold tracking-tight">{{ __('site.contact.hero_title') }}</h1>
        <p class="mt-3 text-xl text-[rgb(45,37,98)] max-w-md mx-auto">{{ __('site.contact.hero_subtitle') }}</p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-6 -mt-10 pb-16">
    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
        <div class="grid md:grid-cols-2">

            <!-- Contact Info -->
            <div class="p-10 md:p-12">
                <h2 class="text-2xl font-semibold text-gray-900 mb-8">{{ __('site.contact.info_title') }}</h2>

                <div class="space-y-8 text-[15px]">
                    <!-- Phone -->
                    <div class="flex gap-4">
                        <div class="w-11 h-11 flex-shrink-0 bg-[#1cc6aa]/10 text-[#29225c] rounded-2xl flex items-center justify-center">
                            <i class="fas fa-phone text-xl"></i>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">{{ __('site.contact.phone') }}</div>
                            <a href="tel:{{ preg_replace('/\s+/', '', $contact->phone ?? '') }}" 
                               class="font-semibold text-lg text-gray-900 hover:text-[#29225c] transition-colors">
                                {{ $contact->phone ?? __('site.contact.not_available') }}
                            </a>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex gap-4">
                        <div class="w-11 h-11 flex-shrink-0 bg-[#1cc6aa]/10 text-[#29225c] rounded-2xl flex items-center justify-center">
                            <i class="fas fa-envelope text-xl"></i>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">{{ __('site.contact.email') }}</div>
                            <a href="mailto:{{ $contact->email }}" 
                               class="font-semibold text-lg text-gray-900 hover:text-[#29225c] transition-colors">
                                {{ $contact->email ?? __('site.contact.not_available') }}
                            </a>
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <div class="flex gap-4">
                        <div class="w-11 h-11 flex-shrink-0 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center">
                            <i class="fab fa-whatsapp text-2xl"></i>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">{{ __('site.contact.whatsapp') }}</div>
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $contact->whatsapp ?? '') }}" target="_blank"
                               class="font-semibold text-lg text-gray-900 hover:text-green-600 transition-colors">
                                {{ $contact->whatsapp ?? __('site.contact.not_available') }}
                            </a>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="flex gap-4">
                        <div class="w-11 h-11 flex-shrink-0 bg-[#1cc6aa]/10 text-[#29225c] rounded-2xl flex items-center justify-center">
                            <i class="fas fa-map-marker-alt text-xl"></i>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">{{ __('site.contact.address') }}</div>
                            <div class="font-semibold text-lg leading-tight text-gray-900">
                                {{ $addressVal }}
                            </div>
                        </div>
                    </div>

                    <!-- Working Hours -->
                    <div class="flex gap-4">
                        <div class="w-11 h-11 flex-shrink-0 bg-[#1cc6aa]/10 text-[#29225c] rounded-2xl flex items-center justify-center">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div>
                            <div class="text-gray-500 text-sm">{{ __('site.contact.working_hours') }}</div>
                            <div class="font-semibold text-lg text-gray-900">
                                {{ $workingVal }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Action Buttons -->
                <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @if($contact->phone)
                        <a href="tel:{{ preg_replace('/\s+/', '', $contact->phone) }}" 
                           class="flex items-center justify-center gap-x-2 bg-[#29225c] hover:bg-[#372d70] text-white font-semibold py-3.5 rounded-2xl transition-all">
                            <i class="fas fa-phone"></i>
                            <span>{{ __('site.contact.call_now') }}</span>
                        </a>
                    @endif

                    @if($contact->whatsapp)
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $contact->whatsapp) }}" target="_blank"
                           class="flex items-center justify-center gap-x-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-3.5 rounded-2xl transition-all">
                            <i class="fab fa-whatsapp text-lg"></i>
                            <span>{{ __('site.contact.whatsapp_button') }}</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Map -->
            <div class="relative bg-gray-100 min-h-[420px] md:min-h-full">
                <div id="map" class="absolute inset-0 z-10"></div>
                <div class="absolute bottom-4 right-4 bg-white/95 backdrop-blur px-3 py-1.5 rounded-xl text-xs shadow text-gray-600 z-20">
                    {{ __('site.contact.location_label') }}
                </div>
            </div>

        </div>
    </div>

    <!-- Social Media -->
    @if($contact->facebook || $contact->instagram)
    <div class="mt-8 text-center">
        <div class="text-sm text-gray-500 mb-3">{{ __('site.contact.follow_us') }}</div>
        <div class="flex justify-center gap-3">
            @if($contact->facebook)
                <a href="{{ $contact->facebook }}" target="_blank"
                   class="inline-flex items-center gap-x-2 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl text-sm font-medium transition-all">
                    <i class="fab fa-facebook-f"></i>
                    <span>{{ __('site.contact.facebook') }}</span>
                </a>
            @endif
            @if($contact->instagram)
                <a href="{{ $contact->instagram }}" target="_blank"
                   class="inline-flex items-center gap-x-2 px-6 py-2.5 bg-gradient-to-r from-pink-500 to-purple-600 hover:brightness-110 text-white rounded-2xl text-sm font-medium transition-all">
                    <i class="fab fa-instagram"></i>
                    <span>{{ __('site.contact.instagram') }}</span>
                </a>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Leaflet Map (CDN) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Coordinates for Al-Sarraj, Tripoli (approx)
        const lat = 32.8872;
        const lng = 13.1913;

        const map = L.map('map', {
            zoomControl: false,
            attributionControl: false
        }).setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // Marker
        const marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup(`
            <div style="font-size:13px; line-height:1.4; min-width:180px">
                <strong>{{ __('site.contact.org_name_map') }}</strong><br>
                {{ e($mapAddress) }}<br>
                <span style="color:#64748b">{{ __('site.contact.libya') }}</span>
            </div>
        `).openPopup();

        // Add zoom control in top-right
        L.control.zoom({ position: 'topright' }).addTo(map);
    });
</script>
@endsection
