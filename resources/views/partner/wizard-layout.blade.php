<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'List your property — ' . config('domains.app_name', 'Inselor'))</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        [x-cloak] { display: none !important; }
    </style>

    <style type="text/tailwindcss">
        @layer components {
            .wiz-page         { @apply max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-12; }
            .wiz-page-wide    { @apply max-w-5xl mx-auto px-4 sm:px-6 py-8 sm:py-12; }

            .wiz-eyebrow      { @apply text-sm font-medium text-[#0071c2] uppercase tracking-wide mb-2; }
            .wiz-h1           { @apply text-2xl sm:text-3xl font-bold text-gray-900 leading-tight; }
            .wiz-h2           { @apply text-lg sm:text-xl font-semibold text-gray-900; }
            .wiz-help         { @apply text-sm text-gray-600 leading-relaxed; }

            .wiz-card         { @apply block w-full text-left bg-white border-2 border-gray-200 rounded-xl p-5 transition-all hover:border-[#0071c2]/40 hover:shadow-sm cursor-pointer relative; }
            .wiz-card-selected { @apply border-[#0071c2] bg-[#f5f9fc] shadow-sm; }
            .wiz-card-check   { @apply absolute top-4 right-4 w-6 h-6 rounded-full bg-[#0071c2] text-white flex items-center justify-center text-xs; }

            .wiz-label        { @apply block text-sm font-semibold text-gray-700 mb-2; }
            .wiz-input        { @apply w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-base text-gray-900 placeholder-gray-400 focus:border-[#0071c2] focus:ring-2 focus:ring-[#0071c2]/20 outline-none transition; }
            .wiz-textarea     { @apply w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-base text-gray-900 placeholder-gray-400 focus:border-[#0071c2] focus:ring-2 focus:ring-[#0071c2]/20 outline-none transition resize-y min-h-[120px]; }
            .wiz-select       { @apply w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-base text-gray-900 focus:border-[#0071c2] focus:ring-2 focus:ring-[#0071c2]/20 outline-none transition; }
            .wiz-help-input   { @apply mt-2 text-xs text-gray-500; }

            .wiz-btn-primary  { @apply inline-flex items-center justify-center font-semibold rounded-lg transition-all focus:outline-none focus:ring-2 focus:ring-offset-1 bg-[#0071c2] hover:bg-[#005c9c] text-white px-6 py-3 text-sm sm:text-base focus:ring-[#0071c2]/40 disabled:opacity-50 disabled:cursor-not-allowed; }
            .wiz-btn-secondary{ @apply inline-flex items-center justify-center font-semibold rounded-lg transition-all bg-white border border-gray-300 hover:border-gray-400 hover:bg-gray-50 text-gray-700 px-5 py-3 text-sm sm:text-base; }
            .wiz-btn-link     { @apply text-[#0071c2] hover:text-[#005c9c] font-medium hover:underline; }

            .wiz-tip          { @apply bg-[#ebf3ff] border border-[#cfdfff] rounded-xl p-4 text-sm text-gray-700; }
            .wiz-tip-title    { @apply font-semibold text-gray-900 mb-1 flex items-center gap-2; }

            .wiz-empty        { @apply border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 p-10 text-center text-sm text-gray-500; }
            .wiz-actions      { @apply flex items-center justify-between pt-6 mt-8 border-t border-gray-200; }

            .wiz-progress-track { @apply h-1 bg-gray-100; }
            .wiz-progress-fill  { @apply h-1 bg-[#0071c2] transition-all duration-300; }

            .wiz-topbar       { @apply sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-gray-200; }
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-50 text-gray-900 antialiased">

    {{-- Sticky brand bar --}}
    <header class="wiz-topbar">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-14 flex items-center justify-between">
            <a href="{{ route('partner.dashboard') }}" class="flex items-center gap-3 group">
                @php $brandName = config('app.name', 'Inselor'); @endphp
                <span class="text-xl font-bold tracking-tight text-[#003b95] group-hover:text-[#0071c2] transition">{{ $brandName }}</span>
                <span class="hidden sm:inline-block text-xs font-medium uppercase tracking-wider text-gray-400">Partner</span>
            </a>

            <div class="flex items-center gap-3 sm:gap-5">
                <a href="#" class="hidden sm:inline-flex text-sm text-gray-600 hover:text-gray-900">
                    <i class="far fa-circle-question mr-1.5 text-gray-400"></i> Help
                </a>
                <a href="{{ route('partner.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 hidden sm:inline-block">
                    Save &amp; exit
                </a>
                <a href="{{ route('partner.dashboard') }}" class="sm:hidden text-gray-500 hover:text-gray-900" aria-label="Save and exit">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </div>

        {{-- Optional progress bar slot --}}
        @hasSection('progress')
            <div class="wiz-progress-track">@yield('progress')</div>
        @endif
    </header>

    {{-- Main content --}}
    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
