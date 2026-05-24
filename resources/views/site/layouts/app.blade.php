<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'صيادلة بلا حدود')</title>
    
    <!-- Modern Tailwind via CDN for quick beautiful design -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700;900&amp;display=swap');
        
        :root {
            --primary: #29225c;
            --font: "IBM Plex Sans Arabic", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        
        body {
            font-family: var(--font);
        }

        .nav-link {
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: #372d70;
            transform: translateY(-1px);
        }
        
        .section-header {
            position: relative;
            display: inline-block;
        }
        
        .section-header:after {
            content: '';
            position: absolute;
            bottom: -8px;
            right: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(to left, #29225c, #3b82f6);
            border-radius: 3px;
        }
        
        .org-chart {
            font-size: 0.95rem;
        }
        
        .modern-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .modern-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #29225c 0%, #372d70 100%);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-24">
                <!-- Logo -->
                <div class="flex items-center gap-x-3">
                    <img src="{{ asset('logo.png') }}" alt="صيادلة بلا حدود" class="h-[4.75rem] w-auto">
                    
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-x-8 text-sm font-medium">
                    <a href="{{ route('site.home') }}" class="nav-link text-gray-700 hover:text-[#29225c]">{{ __('site.nav.home') }}</a>
                    <a href="{{ route('site.programs') }}" class="nav-link text-gray-700 hover:text-[#29225c]">{{ __('site.nav.programs') }}</a>
                    <a href="{{ route('site.volunteer') }}" class="nav-link text-gray-700 hover:text-[#29225c]">{{ __('site.nav.volunteer') }}</a>
                    <a href="{{ route('site.membership') }}" class="nav-link text-gray-700 hover:text-[#29225c]">{{ __('site.nav.membership') }}</a>
                    <a href="{{ route('site.articles') }}" class="nav-link text-gray-700 hover:text-[#29225c]">{{ __('site.nav.articles') }}</a>
                    <a href="{{ route('site.org') }}" class="nav-link text-gray-700 hover:text-[#29225c]">{{ __('site.nav.org') }}</a>
                    <a href="{{ route('site.contact') }}" class="nav-link text-gray-700 hover:text-[#29225c]">{{ __('site.nav.contact') }}</a>
                </div>

                <!-- Right Side -->
                <div class="flex items-center gap-x-4">
                    <!-- Language Switcher -->
                    <div class="hidden md:flex items-center text-xs font-semibold border border-gray-200 rounded-full overflow-hidden">
                        <a href="{{ route('lang.switch', 'ar') }}" 
                           class="px-3 py-1 transition {{ app()->getLocale() == 'ar' ? 'bg-[#29225c] text-white' : 'hover:bg-gray-50' }}">AR</a>
                        <a href="{{ route('lang.switch', 'en') }}" 
                           class="px-3 py-1 border-l transition {{ app()->getLocale() == 'en' ? 'bg-[#29225c] text-white' : 'hover:bg-gray-50' }}">EN</a>
                    </div>

                    <a href="/admin" 
                       class="hidden md:inline-flex items-center px-5 py-2.5 text-sm font-semibold rounded-2xl bg-[#29225c] text-white hover:bg-[#372d70] transition-all shadow-sm">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        {{ __('site.nav.dashboard') }}
                    </a>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden text-gray-700 p-2">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        <div class="px-6 py-4 flex flex-col gap-y-1 text-sm">
            <a href="{{ route('site.home') }}" class="py-3 px-4 hover:bg-gray-100 rounded-xl">{{ __('site.nav.home') }}</a>
            <a href="{{ route('site.programs') }}" class="py-3 px-4 hover:bg-gray-100 rounded-xl">{{ __('site.nav.programs') }}</a>
            <a href="{{ route('site.volunteer') }}" class="py-3 px-4 hover:bg-gray-100 rounded-xl">{{ __('site.nav.volunteer') }}</a>
            <a href="{{ route('site.membership') }}" class="py-3 px-4 hover:bg-gray-100 rounded-xl">{{ __('site.nav.membership') }}</a>
            <a href="{{ route('site.articles') }}" class="py-3 px-4 hover:bg-gray-100 rounded-xl">{{ __('site.nav.articles') }}</a>
            <a href="{{ route('site.org') }}" class="py-3 px-4 hover:bg-gray-100 rounded-xl">{{ __('site.nav.org') }}</a>
            <a href="{{ route('site.contact') }}" class="py-3 px-4 hover:bg-gray-100 rounded-xl">{{ __('site.nav.contact') }}</a>
            
            <div class="pt-4 border-t mt-2">
                <!-- Mobile Language Switch -->
                <div class="flex justify-center mb-3">
                    <div class="flex text-xs font-semibold border border-gray-200 rounded-full overflow-hidden">
                        <a href="{{ route('lang.switch', 'ar') }}" 
                           class="px-4 py-1.5 {{ app()->getLocale() == 'ar' ? 'bg-[#29225c] text-white' : 'hover:bg-gray-100' }}">AR</a>
                        <a href="{{ route('lang.switch', 'en') }}" 
                           class="px-4 py-1.5 border-l {{ app()->getLocale() == 'en' ? 'bg-[#29225c] text-white' : 'hover:bg-gray-100' }}">EN</a>
                    </div>
                </div>

                <a href="/admin" class="block w-full text-center py-3 bg-[#29225c] text-white rounded-2xl font-semibold">
                    {{ __('site.nav.dashboard') }}
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[#29225c] text-white mt-16">
        <div class="max-w-7xl mx-auto px-6 py-14">
            <div class="grid md:grid-cols-4 gap-10">
                <div>
                    <div class="flex items-center gap-x-3 mb-4">
                        <img src="{{ asset('logo.png') }}" class="h-9 brightness-0 invert" alt="">
                        <span class="font-bold text-xl">{{ __('site.footer.org_name') }}</span>
                    </div>
                    <p class="text-sm text-[#1cc6aa]/80 leading-relaxed">
                        {{ __('site.footer.description') }}
                    </p>
                </div>

                <div>
                    <h5 class="font-semibold mb-4 text-sm tracking-wider">{{ __('site.footer.quick_links') }}</h5>
                    <div class="space-y-2 text-sm text-[#1cc6aa]/80">
                        <a href="{{ route('site.programs') }}" class="block hover:text-white">{{ __('site.footer.programs') }}</a>
                        <a href="{{ route('site.volunteer') }}" class="block hover:text-white">{{ __('site.footer.join_volunteer') }}</a>
                        <a href="{{ route('site.articles') }}" class="block hover:text-white">{{ __('site.footer.news') }}</a>
                        <a href="{{ route('site.contact') }}" class="block hover:text-white">{{ __('site.footer.contact_us') }}</a>
                    </div>
                </div>

                <div>
                    <h5 class="font-semibold mb-4 text-sm tracking-wider">{{ __('site.footer.contact_us') }}</h5>
                    <div class="space-y-2 text-sm text-[#1cc6aa]/80">
                        <div><i class="fas fa-phone ml-2"></i> {{ $contact->phone ?? '+218 21 444 1234' }}</div>
                        <div><i class="fas fa-envelope ml-2"></i> {{ $contact->email ?? 'info@phwb.org' }}</div>
                    </div>
                </div>

                <div>
                    <h5 class="font-semibold mb-4 text-sm tracking-wider">{{ __('site.footer.follow_us') }}</h5>
                    <div class="flex gap-3">
                        @if($contact->facebook)
                            <a href="{{ $contact->facebook }}" target="_blank" class="w-9 h-9 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if($contact->instagram)
                            <a href="{{ $contact->instagram }}" target="_blank" class="w-9 h-9 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="border-t border-white/20 mt-10 pt-6 text-center text-xs text-[#1cc6aa]/60">
                © {{ date('Y') }} {{ __('site.footer.org_name') }}. {{ __('site.footer.copyright') }}
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const mobileBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileBtn && mobileMenu) {
            mobileBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>
</body>
</html>
