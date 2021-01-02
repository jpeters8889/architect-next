@props(['theme' => 'green'])

<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $theme }}-100 text-{{ $theme }}-800">
    {{ $slot }}
</span>
