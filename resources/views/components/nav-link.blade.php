@props(['active' => false])

<a {{ $attributes->merge([
    'class' => $active 
            ? 'bg-gradient-to-r from-[#05C1FF] to-[#0FA3FF] text-[#FAFAFA] text-white drop-shadow-xl rounded-e-lg' 
            : 'hover:rounded-r-lg hover:bg-[#C1C1C1]/50 text-[#718295] border-white transform transition duration-100 ease-in-out'
]) }}>
    {{ $slot }}
</a>