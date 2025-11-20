@props([
    'logo' => 'images/logo.svg',
    'alturalogo' => 'h-20',
    'fondoinput' => 'Buscar proyecto...',
])

<div class="grid grid-cols-12 gap-2 mt-[30px] mb-[30px] px-[40px]">

    {{-- Logo --}}
    <div class="col-span-2 flex items-center justify-start">
        <img src="{{ asset($logo) }}" alt="Logo" class="{{ $alturalogo }}">
    </div>

    {{-- Input + botón en un solo grupo --}}
    <div class="col-span-8 flex items-center justify-center w-full">
        <div class="flex w-full rounded-[10px] overflow-hidden border border-[#3A3A3A]">

            {{-- BOTÓN pegado al input --}}
            <button type="submit" class="bg-[#191919] text-white px-4 flex items-center">
                Buscar
            </button>

            {{-- INPUT ocupando el resto --}}
            <x-input 
                name="search" 
                type="text" 
                placeholder="{{ $fondoinput }}"
                heigth="h-[50px]"
                width="w-full"
                padding="p-[10px]"
                borderRadius="rounded-none" 
            />
        </div>
    </div>

</div>

{{-- Usuario + logout --}}
<div class="col-span-1 flex items-center justify-end gap-1">
    @if(Auth::check())
        <span class="text-white font-semibold text-base">{{ Auth::user()->nombre_usuario }}</span>
    @endif
</div>

<div class="col-span-1 flex items-center justify-end gap-1">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" style="background: none; border: none; padding: 0;">
            <img src="{{ asset('images/logout.svg') }}" alt="Logout" class="h-8 w-8 cursor-pointer hover:opacity-80 transition-opacity" />
        </button>
    </form>
</div>
