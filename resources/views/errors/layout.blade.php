<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'صيادلة بلا حدود')</title>

    <!-- Tailwind CDN (same as public site) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700;900&display=swap');
        
        :root {
            --primary: #29225c;
        }
        
        body {
            font-family: "IBM Plex Sans Arabic", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .error-code {
            font-size: 8rem;
            line-height: 1;
            font-weight: 900;
            background: linear-gradient(135deg, #1cc6aa 0%, #1cc6aa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @media (max-width: 640px) {
            .error-code {
                font-size: 6rem;
            }
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Simple Navbar (matching site style) -->
    <nav class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-center h-20">
                <a href="/" class="flex items-center gap-x-3">
                    <img src="{{ asset('logo.png') }}" alt="صيادلة بلا حدود" class="h-12 w-auto">
                </a>
                
                <div class="flex items-center gap-x-4">
                    <a href="/" 
                       class="px-4 py-2 text-sm font-medium text-white bg-[#29225c] rounded-xl hover:bg-[#1f1a47] transition">
                        {{ app()->getLocale() === 'en' ? 'Back to Home' : 'العودة للرئيسية' }}
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-[calc(100vh-5rem)] flex items-center justify-center px-6">
        <div class="text-center max-w-lg">
            
            <!-- Error Code -->
            <div class="error-code mb-4">
                @yield('code', 'Error')
            </div>

            <!-- Message -->
            <h1 class="text-3xl font-bold text-[#29225c] mb-4">
                @yield('message', 'Something went wrong')
            </h1>

            <p class="text-gray-600 mb-8 text-lg">
                @yield('description', 
                    app()->getLocale() === 'en' 
                        ? 'The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.'
                        : 'الصفحة التي تبحث عنها قد تكون محذوفة أو تم تغيير اسمها أو غير متاحة حالياً.'
                )
            </p>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/" 
                   class="inline-flex items-center justify-center px-8 py-3 bg-[#29225c] text-white font-semibold rounded-2xl hover:bg-[#1f1a47] transition">
                    <i class="fas fa-home ml-2"></i>
                    {{ app()->getLocale() === 'en' ? 'Go to Homepage' : 'الذهاب للرئيسية' }}
                </a>

                <a href="javascript:history.back()" 
                   class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 text-gray-700 font-medium rounded-2xl hover:bg-gray-100 transition">
                    <i class="fas fa-arrow-left ml-2"></i>
                    {{ app()->getLocale() === 'en' ? 'Go Back' : 'العودة للخلف' }}
                </a>
            </div>

        </div>
    </div>

</body>
</html>
