@extends('site.layouts.app')

@section('title', __('site.hero_title'))

@section('content')
    @if($sliders->count() > 0)
    <!-- Hero Section with Slider -->
    <section class="hero-gradient text-white py-0 md:py-0">
        <div class="max-w-6xl mx-auto px-6 pt-16 pb-20 md:pt-20 md:pb-28">
            <div class="relative h-[400px] md:h-[500px] rounded-3xl overflow-hidden shadow-2xl mb-16">
                <div id="slider-container" class="h-full">
                    @foreach($sliders as $index => $slider)
                    <div class="slider-slide {{ $index === 0 ? '' : 'hidden' }} h-full">
                        <img src="{{ asset('storage/' . $slider->image) }}" alt="Slider image" class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-5xl md:text-6xl font-bold leading-tight tracking-tighter mb-6">
                    {!! __('site.hero_title') !!}
                </h1>
                <p class="text-xl md:text-2xl text-[rgb(41,34,92)] mb-10 max-w-2xl mx-auto">
                    {{ __('site.hero_subtitle') }}
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('site.membership') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-white text-[#29225c] font-semibold rounded-3xl hover:bg-gray-100 transition text-lg shadow-lg">
                        <i class="fas fa-user-plus ml-3"></i>
                        {{ __('site.join_member') }}
                    </a>
                    
                    <a href="{{ route('site.volunteer') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 border-2 border-white/70 hover:bg-white/10 font-semibold rounded-3xl transition text-lg">
                        <i class="fas fa-hands-helping ml-3"></i>
                        {{ __('site.join_volunteer') }}
                    </a>
                    
                    <a href="{{ route('site.programs') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 border-2 border-white/70 hover:bg-white/10 font-semibold rounded-3xl transition text-lg">
                        {{ __('site.our_programs') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Auto-slide only
        let currentSlide = 0;
        const slides = document.querySelectorAll('.slider-slide');
        
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('hidden', i !== index);
            });
            currentSlide = index;
        }
        
        if (slides.length > 1) {
            setInterval(() => {
                showSlide((currentSlide + 1) % slides.length);
            }, 5000);
        }
    </script>
    @else
    <!-- Hero Section -->
    <section class="hero-gradient text-white py-20 md:py-28">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-5xl md:text-6xl font-bold leading-tight tracking-tighter mb-6">
                    {!! __('site.hero_title') !!}
                </h1>
                <p class="text-xl md:text-2xl text-[rgb(41,34,92)] mb-10 max-w-2xl mx-auto">
                    {{ __('site.hero_subtitle') }}
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('site.membership') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 bg-white text-[#29225c] font-semibold rounded-3xl hover:bg-gray-100 transition text-lg shadow-lg">
                        <i class="fas fa-user-plus ml-3"></i>
                        {{ __('site.join_member') }}
                    </a>
                    
                    <a href="{{ route('site.volunteer') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 border-2 border-white/70 hover:bg-white/10 font-semibold rounded-3xl transition text-lg">
                        <i class="fas fa-hands-helping ml-3"></i>
                        {{ __('site.join_volunteer') }}
                    </a>
                    
                    <a href="{{ route('site.programs') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 border-2 border-white/70 hover:bg-white/10 font-semibold rounded-3xl transition text-lg">
                        {{ __('site.our_programs') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Stats -->
    <section class="max-w-5xl mx-auto px-6 -mt-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-3xl p-6 shadow-sm border">
                <div class="text-4xl font-bold text-[#29225c]">+120</div>
                <div class="text-sm text-gray-500 mt-1">{{ __('site.stats.volunteers') }}</div>
            </div>
            <div class="bg-white rounded-3xl p-6 shadow-sm border">
                <div class="text-4xl font-bold text-[#29225c]">18</div>
                <div class="text-sm text-gray-500 mt-1">{{ __('site.stats.programs') }}</div>
            </div>
            <div class="bg-white rounded-3xl p-6 shadow-sm border">
                <div class="text-4xl font-bold text-[#29225c]">+45</div>
                <div class="text-sm text-gray-500 mt-1">{{ __('site.stats.cities') }}</div>
            </div>
            <div class="bg-white rounded-3xl p-6 shadow-sm border">
                <div class="text-4xl font-bold text-[#29225c]">7</div>
                <div class="text-sm text-gray-500 mt-1">{{ __('site.stats.years') }}</div>
            </div>
        </div>
    </section>

    <!-- Programs Preview -->
    <section class="max-w-6xl mx-auto px-6 mt-16">
        <div class="flex justify-between items-end mb-8">
            <div>
                <span class="text-sm font-medium text-[#29225c]">{{ __('site.programs_label') }}</span>
                <h2 class="text-3xl font-bold tracking-tight">{{ __('site.programs_title') }}</h2>
            </div>
            <a href="{{ route('site.programs') }}" class="hidden md:flex items-center text-sm font-medium text-[#29225c] hover:underline">
                {{ __('site.our_programs') }} <i class="fas fa-arrow-left mr-2"></i>
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($programs->take(3) as $program)
                <div class="modern-card bg-white rounded-3xl overflow-hidden border shadow-sm">
                    @if($program->image)
                        <img src="{{ asset('storage/' . $program->image) }}" class="w-full h-48 object-cover" alt="">
                    @endif
                    <div class="p-6">
                        <h3 class="font-semibold text-xl mb-2">
                            {{ app()->getLocale() === 'en' && $program->title_en ? $program->title_en : $program->title }}
                        </h3>
                        <p class="text-gray-600 text-sm line-clamp-3">
                            {{ Str::limit( app()->getLocale() === 'en' && $program->description_en ? $program->description_en : $program->description , 120) }}
                        </p>
                        
                        <div class="mt-4">
                            <a href="{{ route('site.programs') }}" class="text-sm font-medium text-[#29225c] inline-flex items-center">
                                {{ __('site.read_more') }} <i class="fas fa-arrow-left mr-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Call to Action - Volunteer -->
    <section class="max-w-5xl mx-auto px-6 mt-20">
        <div class="bg-gradient-to-l from-[#29225c] to-[#372d70] rounded-3xl p-10 md:p-14 text-white flex flex-col md:flex-row items-center gap-8">
            <div class="flex-1">
                <h2 class="text-3xl font-bold mb-4">{{ __('site.cta_title') }}</h2>
                <p class="text-[#1cc6aa] text-lg">{{ __('site.cta_subtitle') }}</p>
            </div>
            <div>
                <a href="{{ route('site.volunteer') }}" 
                   class="inline-block bg-white text-[#29225c] font-bold px-9 py-4 rounded-3xl hover:bg-gray-100 transition shadow">
                    {{ __('site.cta_button') }}
                </a>
            </div>
        </div>
    </section>
@endsection
