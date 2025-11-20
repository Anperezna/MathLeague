@props([
    'color' => 'blue',
    'text' => '',
    'size' => 'md',
    'type' => 'button',
    'href' => null,
    'img' => null,
    'height' => 'normal',
    'border_color' => 'black',
    'text_color' => '#FFFFFF',
    'onclick' => '',
])

@if ($href)
    <a href="{{ $href }}"
        class="flex items-center gap-2 bg-[{{ $color }}] border-2 border-[{{ $border_color }}] hover:brightness-75 hover:scale-95 text-[{{ $text_color }}] font-medium rounded-lg px-{{ $size == 'sm' ? '3' : ($size == 'lg' ? '6' : '5') }} py-{{ $height == 'small' ? '2' : ($height == 'large' ? '6' : ($height == 'xlarge' ? '8' : '3')) }} text-{{ $size }} transition-all duration-200 inline-block text-center">
        @if ($img)
            <img src="{{ asset($img) }}" alt="icon" class="w-5 h-5">
        @endif
        {{ $text }}
    </a>
@else
    <button type="{{ $type }}" @if ($onclick) onclick="{{ $onclick }}" @endif
        class="flex items-center gap-2 bg-[{{ $color }}] border-2 border-[{{ $border_color }}] hover:brightness-75 hover:scale-95 text-[{{ $text_color }}] font-medium rounded-lg px-{{ $size == 'sm' ? '3' : ($size == 'lg' ? '6' : '5') }} py-{{ $height == 'small' ? '2' : ($height == 'large' ? '6' : ($height == 'xlarge' ? '8' : '3')) }} text-{{ $size }} transition-all duration-200">
        @if ($img)
            <img src="{{ asset($img) }}" alt="icon" class="w-5 h-5">
        @endif
        {{ $text }}
    </button>
@endif
