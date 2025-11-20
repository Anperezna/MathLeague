@props([
    'placeholder' => '',
    'type' => 'text',
    'name' => '',
    'value' => '',
    'border_color' => '#3a3a3a',
    'width' => 'w-[200px]',
    'heigth' => 'h-[30px]',
    'padding' => 'p-[5px]',
    'borderRadius' => 'rounded-[10px]',
    'backgroundColor' => 'bg-[#191919]',
])

<input type="{{ $type }}" name="{{ $name }}" value="{{ $value }}"
    placeholder="{{ $placeholder }}"
    class="border border-[{{ $border_color }}] text-white font-medium  {{ $heigth }} {{ $width }} {{ $padding }} {{ $borderRadius }} {{ $backgroundColor }} transition-all duration-200 outline-none placeholder-gray-400"
