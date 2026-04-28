<div class="flex items-center space-x-1 text-sm">
    <a href="{{ route('language.switch', 'en') }}"
        class="px-2 py-1 rounded {{ app()->getLocale() === 'en' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-500 hover:text-gray-700' }}">
        EN
    </a>
    <span class="text-gray-300">|</span>
    <a href="{{ route('language.switch', 'de') }}"
        class="px-2 py-1 rounded {{ app()->getLocale() === 'de' ? 'bg-indigo-100 text-indigo-700 font-semibold' : 'text-gray-500 hover:text-gray-700' }}">
        DE
    </a>
</div>
