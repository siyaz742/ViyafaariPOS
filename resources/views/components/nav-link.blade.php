@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none
                    border-main-light text-main-light focus:border-main-light'

            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 focus:outline-none transition duration-150 ease-in-out
                                        text-accent-dark focus:border-main-light focus:text-main-light hover:text-accent-light hover:border-accent-verylight';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
