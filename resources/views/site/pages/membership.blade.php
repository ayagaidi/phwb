@extends('site.layouts.app')

@section('title', __('site.membership.title') . ' | ' . __('site.footer.org_name'))

@section('content')
<!-- Hero -->
<div class="bg-gradient-to-b from-[#1e3a8a] to-[#1e40af] text-white py-16">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <div class="inline-flex items-center gap-x-2 bg-white/10 px-4 py-1 rounded-full text-sm mb-4">
            <i class="fas fa-user-plus"></i>
            <span>{{ __('site.membership.hero_badge') }}</span>
        </div>
        <h1 class="text-5xl font-bold tracking-tight">{{ __('site.membership.title') }}</h1>
        <p class="mt-4 text-xl text-blue-100 max-w-lg mx-auto">
            {{ __('site.membership.hero_subtitle') }}
        </p>
    </div>
</div>

<div class="max-w-6xl mx-auto px-6 py-16">

    <!-- Benefits -->
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold">{{ __('site.membership.why_join_title') }}</h2>
        <p class="text-gray-600 mt-2">استفد من العديد من المزايا والفرص</p>
    </div>

    <div class="grid md:grid-cols-3 gap-6 mb-16">
        <div class="bg-white border rounded-3xl p-8 text-center modern-card">
            <div class="w-14 h-14 mx-auto bg-blue-100 text-[#1e3a8a] rounded-2xl flex items-center justify-center mb-5">
                <i class="fas fa-graduation-cap text-2xl"></i>
            </div>
            <h3 class="font-bold text-xl mb-2">{{ __('site.membership.benefits.professional.title') }}</h3>
            <p class="text-gray-600 text-sm">{{ __('site.membership.benefits.professional.desc') }}</p>
        </div>

        <div class="bg-white border rounded-3xl p-8 text-center modern-card">
            <div class="w-14 h-14 mx-auto bg-blue-100 text-[#1e3a8a] rounded-2xl flex items-center justify-center mb-5">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <h3 class="font-bold text-xl mb-2">{{ __('site.membership.benefits.network.title') }}</h3>
            <p class="text-gray-600 text-sm">{{ __('site.membership.benefits.network.desc') }}</p>
        </div>

        <div class="bg-white border rounded-3xl p-8 text-center modern-card">
            <div class="w-14 h-14 mx-auto bg-blue-100 text-[#1e3a8a] rounded-2xl flex items-center justify-center mb-5">
                <i class="fas fa-hand-holding-heart text-2xl"></i>
            </div>
            <h3 class="font-bold text-xl mb-2">{{ __('site.membership.benefits.impact.title') }}</h3>
            <p class="text-gray-600 text-sm">{{ __('site.membership.benefits.impact.desc') }}</p>
        </div>
    </div>

    <!-- Who can join -->
    <div class="max-w-3xl mx-auto bg-white border rounded-3xl p-10 mb-12">
        <h3 class="text-2xl font-bold mb-6 text-center">{{ __('site.membership.who_can_join_title') }}</h3>
        <ul class="space-y-3 text-gray-700 text-[15px]">
            <li class="flex gap-3"><i class="fas fa-check text-green-500 mt-1"></i> {{ __('site.membership.eligibility.pharmacists') }}</li>
            <li class="flex gap-3"><i class="fas fa-check text-green-500 mt-1"></i> {{ __('site.membership.eligibility.students') }}</li>
            <li class="flex gap-3"><i class="fas fa-check text-green-500 mt-1"></i> {{ __('site.membership.eligibility.health_workers') }}</li>
            <li class="flex gap-3"><i class="fas fa-check text-green-500 mt-1"></i> {{ __('site.membership.eligibility.supporters') }}</li>
        </ul>
    </div>

    <!-- Membership Application Form -->
    <div class="max-w-4xl mx-auto">
        @if(session('success'))
            <div class="mb-8 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl flex items-start gap-3">
                <i class="fas fa-check-circle mt-1 text-lg"></i>
                <div>
                    <div class="font-semibold">{{ session('success') }}</div>
                    <div class="text-sm mt-1">شكراً لاهتمامك بمنظمتنا. فريقنا سيراجع طلبك قريباً.</div>
                </div>
            </div>
        @endif

        <div class="bg-white border rounded-3xl shadow-xl p-8 md:p-12">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold">{{ __('site.membership.form_title') }}</h2>
                <p class="text-gray-600 mt-2">{{ __('site.membership.how_to_join_desc') }}</p>
            </div>

            <form action="{{ route('site.membership.store') }}" method="POST" class="space-y-8">
                @csrf

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-2xl text-sm">
                        {{ app()->getLocale() === 'en' ? 'Please correct the errors below.' : 'يرجى تصحيح الأخطاء في الحقول أدناه.' }}
                    </div>
                @endif

                <!-- البيانات الشخصية -->
                <div>
                    <h3 class="font-bold text-lg mb-4 text-[#1e3a8a] border-b pb-2">{{ __('site.membership.personal_info') }}</h3>
                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">الاسم الكامل <span class="text-red-500">*</span></label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}" required class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('full_name') border-red-400 @enderror">
                            @error('full_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">تاريخ الميلاد</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('date_of_birth') border-red-400 @enderror">
                            @error('date_of_birth')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">الجنس</label>
                            <select name="gender" class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('gender') border-red-400 @enderror">
                                <option value="">اختر</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>آخر</option>
                            </select>
                            @error('gender')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">رقم الهاتف <span class="text-red-500">*</span></label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" required class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('phone') border-red-400 @enderror">
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">رقم الواتساب</label>
                            <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('whatsapp') border-red-400 @enderror">
                            @error('whatsapp')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('email') border-red-400 @enderror">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">المدينة <span class="text-red-500">*</span></label>
                            <input type="text" name="city" value="{{ old('city') }}" required placeholder="طرابلس / بنغازي ..." class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('city') border-red-400 @enderror">
                            @error('city')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">العنوان التفصيلي</label>
                            <input type="text" name="address" value="{{ old('address') }}" class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('address') border-red-400 @enderror">
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- البيانات المهنية -->
                <div>
                    <h3 class="font-bold text-lg mb-4 text-[#1e3a8a] border-b pb-2">البيانات المهنية</h3>
                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">المؤهل العلمي</label>
                            <input type="text" name="qualification" value="{{ old('qualification') }}" placeholder="بكالوريوس صيدلة" class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('qualification') border-red-400 @enderror">
                            @error('qualification')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">الجامعة</label>
                            <input type="text" name="university" value="{{ old('university') }}" class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('university') border-red-400 @enderror">
                            @error('university')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">سنة التخرج</label>
                            <input type="text" name="graduation_year" value="{{ old('graduation_year') }}" placeholder="2023" class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('graduation_year') border-red-400 @enderror">
                            @error('graduation_year')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">رقم الترخيص الصيدلي</label>
                            <input type="text" name="license_number" value="{{ old('license_number') }}" class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('license_number') border-red-400 @enderror">
                            @error('license_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">مكان العمل الحالي</label>
                            <input type="text" name="current_workplace" value="{{ old('current_workplace') }}" placeholder="صيدلية / مستشفى ..." class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('current_workplace') border-red-400 @enderror">
                            @error('current_workplace')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">سنوات الخبرة</label>
                            <input type="text" name="years_experience" value="{{ old('years_experience') }}" placeholder="5 سنوات" class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('years_experience') border-red-400 @enderror">
                            @error('years_experience')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">التخصص / المجال الفرعي</label>
                            <input type="text" name="specialization" value="{{ old('specialization') }}" class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('specialization') border-red-400 @enderror">
                            @error('specialization')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- معلومات العضوية -->
                <div>
                    <h3 class="font-bold text-lg mb-4 text-[#1e3a8a] border-b pb-2">معلومات العضوية</h3>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">نوع العضوية المطلوبة <span class="text-red-500">*</span></label>
                        <select name="membership_type" required class="w-full border rounded-2xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('membership_type') border-red-400 @enderror">
                            <option value="full_member" {{ old('membership_type') == 'full_member' ? 'selected' : '' }}>عضو عامل (صيدلي مرخص)</option>
                            <option value="student_member" {{ old('membership_type') == 'student_member' ? 'selected' : '' }}>عضو طالب</option>
                            <option value="supporter" {{ old('membership_type') == 'supporter' ? 'selected' : '' }}>عضو داعم</option>
                        </select>
                        @error('membership_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">لماذا تريد الانضمام إلى صيادلة بلا حدود؟ <span class="text-red-500">*</span></label>
                        <textarea name="reason" rows="4" required placeholder="أكتب هنا باختصار..." class="w-full border rounded-3xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('reason') border-red-400 @enderror">{{ old('reason') }}</textarea>
                        @error('reason')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1">في أي مجالات يمكنك المساهمة؟</label>
                        <textarea name="contribution_areas" rows="3" placeholder="مثال: التدريب، الإعلام، المشاريع الميدانية، اللوجستيات..." class="w-full border rounded-3xl px-4 py-3 focus:outline-none focus:border-[#1e3a8a] @error('contribution_areas') border-red-400 @enderror">{{ old('contribution_areas') }}</textarea>
                        @error('contribution_areas')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="available_for_fieldwork" value="1" id="fieldwork" class="w-5 h-5 accent-[#1e3a8a]" {{ old('available_for_fieldwork') ? 'checked' : '' }}>
                        <label for="fieldwork" class="text-sm text-gray-700">أنا مستعد للمشاركة في الأنشطة والمشاريع الميدانية</label>
                    </div>
                </div>

                <div class="pt-4 border-t">
                    <button type="submit"
                            class="w-full md:w-auto inline-flex items-center justify-center px-12 py-4 bg-[#1e3a8a] hover:bg-[#1e40af] text-white font-bold text-lg rounded-3xl shadow-lg transition">
                        <i class="fas fa-paper-plane ml-3"></i>
                        إرسال طلب العضوية
                    </button>
                    <p class="text-xs text-gray-500 mt-4">بياناتك محمية ولن تُستخدم إلا لأغراض العضوية في المنظمة.</p>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
