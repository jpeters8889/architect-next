@props(['href', 'active' => false])

<a href="{{ $href }}"
   class="flex items-center mt-4 p-2 pl-4
    {{ $active ? 'bg-gray-700 bg-opacity-25 text-gray-100' : 'text-white text-opacity-80 hover:bg-gray-500 hover:bg-opacity-25 hover:text-gray-100' }}"
>
    {{ $slot }}
</a>
