@php
    $iconosArriba = [
        // Aqui o guardas las rutas o el PHP no se entera de nada que hay y ESTA ASI PARA QUE ESTÉN ORDENADOS DESPUES EN LA NAVBAR FIJA
        ['icono' => 'home.svg', 'ruta' => 'proyecto'], // HAY QUE CAMBIAR ESTO PARA QUE VAYA A LA PESTAÑA QUE TOCA
        ['icono' => 'calendario.svg', 'ruta' => 'prueba'], // HAY QUE CAMBIAR ESTO PARA QUE VAYA A LA PESTAÑA QUE TOCA
        ['icono' => 'time_tracker.svg', 'ruta' => 'prueba'], // HAY QUE CAMBIAR ESTO PARA QUE VAYA A LA PESTAÑA QUE TOCA
        ['icono' => 'star.svg', 'ruta' => 'prueba'], // HAY QUE CAMBIAR ESTO PARA QUE VAYA A LA PESTAÑA QUE TOCA
    ];
    // Y este es el amargado que está abajo solo
    $iconoAbajo = ['icono' => 'user_mas.svg', 'ruta' => 'prueba']; // HAY QUE CAMBIAR ESTO PARA QUE VAYA A LA PESTAÑA QUE TOCA
@endphp


{{-- Estilos que van dentro de la fixedbar aunque luego si es verdad que se cambian --}}
@props([
    'width' => 'w-full',
    'bg' => 'bg-[#191919]',
    'iconSize' => 'w-35 h-35',
    'marginLeft' => 'ml-[6px]',
    'marginBottom' => 'mb-[4px]',
    'marginRight' => 'mr-[6px]',
    'rounded' => 'rounded-[10px]',
    'padding' => 'p-5',
    'height' => 'h-[calc(100vh-156px)]',
])

<style>
@media (max-width: 700px) {
    .fixedbar-hide-700 { display: none !important; }
}
</style>
<div
        class="fixedbar-hide-700 flex flex-col items-center justify-between {{ $height }} {{ $width }} {{ $bg }} {{ $marginBottom }} {{ $marginRight }} {{ $rounded }} {{ $padding }} {{ $marginLeft }}">
    <div class="flex flex-col items-center pt-8" style="gap: 40px;" {{ $rounded }}>
        {{-- Aqui un bucle para la carpeta de fixedbar_icons para sacar todas las IMAGENES GUARDADAS en $iconosArriba --}}
        @foreach ($iconosArriba as $item)
            <a href="{{ route($item['ruta']) }}"
                class="hover:opacity-80 hover:scale-110 transition-all duration-200 ease-in-out">
                <img src="{{ asset('images/fixedbar_icons/' . $item['icono']) }}" alt="{{ $item['icono'] }}"
                    class="{{ $iconSize }}">
            </a>
        @endforeach
    </div>

    <div class="pb-8">
        {{-- Y otra vez el amargado donde entramos simplemente metiendole la ruta de $iconoabajo para no tener que hacer bucle porque solo hay 1 --}}
        <a href="{{ route($iconoAbajo['ruta']) }}"
            class="hover:opacity-80 hover:scale-105 transition-all duration-200 ease-in-out">
            <img src="{{ asset('images/fixedbar_icons/' . $iconoAbajo['icono']) }}" alt="{{ $iconoAbajo['icono'] }}"
                class="{{ $iconSize }}">
        </a>
    </div>
</div>
