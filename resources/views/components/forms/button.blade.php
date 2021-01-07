@props(['type' => 'submit', 'label' => 'Submit'])

<button type="{{ $type }}"
        class="md:w-32 bg-indigo-600 hover:bg-blue-dark text-white font-bold py-3 px-6 rounded-lg mt-3 hover:bg-indigo-500 transition ease-in-out duration-300">
    {{ $label }}
</button>
