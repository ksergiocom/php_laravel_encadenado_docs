@extends('layout.base')

@section('content')
    <div class="h-dvh overflow-y-scroll snap-y snap-mandatory scroll-smooth">
        <div id="hola" class="snap-start h-dvh w-full bg-black relative">
            <video class="h-full w-full object-cover opacity-30 absolute top-0" autoplay muted loop playsinline>
                <source src="{{ Vite::asset('resources/videos/vacas-opt.mp4') }}" type="video/mp4">
            </video>
            <div class="w-full absolute top-0 flex flex-col gap-5 p-5 xl:p-10 text-white place-content-between h-full">
                <h2 class="text-6xl xl:max-w-2/3 xl:text-9xl tracking-wide w-fit fade-in">Ganadería de Razas <span
                        class="text-green-500">Selectas</span></h2>
                <div class="flex justify-between gap-5">
                    <div class="w-fit flex flex-col items-center gap-3 self-end">
                        <p class="text-lg xl:text-xl font-normal tracking-widest rotate-180"
                            style="writing-mode: vertical-rl;">¡Conócenos!</p>
                        <a href="#como" class="animate-bounce text-5xl xl:text-7xl mt-2">&darr;</a>
                    </div>

                    <p class="p-3 xl:p-10 max-w-3/4 sm:max-w-sm sm:self-end flex text-right">Lorem, ipsum dolor sit amet
                        consectetur adipisicing elit. Quod laborum illum accusamus, rem quia quae architecto labore odio vel
                        natus? Aperiam qui corporis, fugit libero quidem sunt doloremque id maiores?</p>
                </div>
            </div>
        </div>
        <div id="como" class="snap-start min-h-dvh w-full bg-black xl:content-center p-5 text-gray-100 gap-5 relative">
            <div class="flex flex-col md:flex-row gap-5 min-h-dvh h-full w-full">
                <div class="flex flex-col gap-5 xl:max-w-2xl mx-auto">

                    <h2 class="text-4xl xl:text-7xl fade-in">¿QUIÉNES <span class="text-green-500">SOMOS</span>?
                    </h2>
                    <p class="xl:text-xl fade-in">Ganadería de Razas Selectas, S.A. es una explotación dedicada a la
                        <strong>cría y selección de ganado de alto valor genético</strong> en el corazón de Castilla y León,
                        combinando tradición y manejo profesional.
                    </p>
                    <p class="xl:text-xl fade-in">Cuidamos cada detalle del <strong>bienestar animal</strong> y de la
                        alimentación para garantizar ejemplares sanos, robustos y de calidad contrastada.</p>
                    <h2 class="text-2xl xl:text-5xl fade-in mt-9">Algo gracioso adicional</h2>
                    <p class="xl:text-xl fade-in">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur
                        nesciunt porro provident earum maiores quis dolores voluptate? Expedita minus nisi sit, praesentium
                        fugiat nulla possimus temporibus, vel, dicta rem id culpa ad asperiores ratione nesciunt. Ad
                        consectetur numquam vero quo?</p>
                    <p class="xl:text-xl fade-in pb-5">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aspernatur
                        nesciunt porro provident earum maiores quis dolores voluptate? Expedita minus nisi sit, praesentium
                        fugiat nulla possimus temporibus, vel, dicta rem id culpa ad asperiores ratione nesciunt. Ad
                        consectetur numquam vero quo?</p>
                </div>
                <img class="pb-15 md:pb-0 w-full h-full object-center object-cover" src="{{ Vite::asset('resources/images/vaca.jpg') }}"
                    alt="vaca">
            </div>
            <a href="#peligros" class="animate-bounce text-5xl xl:text-7xl absolute bottom-0">&darr;</a>
        </div>
        <div id="peligros"
            class="snap-start min-h-dvh w-full bg-gradient-to-br bg-black xl:content-center  p-5 text-white relative">
            <img class="h-full w-full object-cover absolute top-0 left-0 opacity-40"
                src="{{ Vite::asset('resources/images/granaja.jpg') }}" alt="granja">
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="flex flex-col gap-5 xl:max-w-2xl mx-auto relative z-10">

                <h2 class="text-4xl xl:text-7xl uppercase fade-in">Nuestra <span class="text-red-500">actividad</span>
                </h2>
                <p class="xl:text-xl fade-in">Desarrollamos una <strong>actividad agrícola ganadera integrada</strong>:
                    cultivamos nuestros propios forrajes y cerramos el ciclo con la cría del ganado, controlando el
                    origen de cada recurso.</p>
                <p class="xl:text-xl fade-in">Apostamos por una <strong>gestión sostenible</strong> de la tierra y del
                    rebaño, respetando los ritmos naturales y el entorno rural que nos rodea.</p>
            </div>
            <a href="#sobre" class="animate-bounce text-5xl xl:text-7xl absolute bottom-0 z-10">&darr;</a>
        </div>
        <div id="sobre" class="snap-start h-dvh w-full bg-black relative">
            <img class="h-full w-full object-cover opacity-20 absolute top-0"
                src="{{ Vite::asset('resources/images/vaca.jpg') }}" alt="vaca">
            <div class="top-0 p-5 text-white relative h-full xl:content-center">
                <div class="flex flex-col gap-5 xl:max-w-2xl mx-auto">

                    <h2 class="text-4xl xl:text-7xl fade-in">UN POCO <span class="text-red-600">SOBRE NOSOTROS</span>
                    </h2>
                    <p class="xl:text-xl fade-in">Nacimos como un <strong>proyecto familiar</strong> y hoy somos una
                        sociedad consolidada con domicilio en Valladolid, fieles a nuestras raíces ganaderas.</p>
                    <p class="xl:text-xl fade-in">Nuestro compromiso es ofrecer <strong class="text-red-600">razas
                            selectas con plena trazabilidad</strong>, transparencia y respeto por el animal y la tierra.</p>
                </div>
                <a href="#anuncios" class="animate-bounce text-5xl xl:text-7xl absolute bottom-0">&darr;</a>
            </div>
        </div>
        <div id="anuncios" class="snap-start min-h-dvh w-full bg-gray-50  p-5 xl:p-7 text-gray-900 gap-5 relative">
            <div class="flex flex-col gap-5">
                <h2 class="text-4xl xl:text-5xl mb-3">TABLÓN DE ANUNCIOS
                </h2>

                @if($documentos->isNotEmpty())
                    <div class="grid gap-4">
                        @foreach($documentos as $documento)
                            <article class="group border border-gray-200 p-4 xl:p-5  transition bg-white">
                                <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between gap-4">

                                    <div class="flex-1 min-w-0">

                                        <a href="{{ asset('storage/' . $documento->path) }}"
                                            class="block text-lg xl:text-xl font-medium text-gray-900 hover:underline line-clamp-2">
                                            {{ $documento->titulo }}
                                        </a>

                                        <div class="mt-3 flex flex-wrap gap-2 text-xs text-gray-500">
                                            <span class="bg-gray-100 px-2 py-1">
                                                Versión v.{{ $documento->version }}.0
                                            </span>

                                            <span class="bg-gray-100 px-2 py-1">
                                                Publicado el {{ $documento->publicado_at?->format('d/m/Y') }}
                                            </span>

                                            <span class="bg-gray-100 px-2 py-1">
                                                {{ $documento->estado }}
                                            </span>

                                            @if($documento->estado != 'publicado' && $documento->retirado_at)
                                                <span class="bg-gray-100 px-2 py-1">
                                                    {{ ucfirst($documento->estado) }} el {{ $documento->retirado_at->format('d/m/Y') }}
                                                </span>
                                            @endif
                                        </div>

                                        @if(!empty($documento->file_hash))
                                            <details class="mt-3 text-xs text-gray-500">
                                                <summary class="cursor-pointer select-none hover:text-gray-900 hover:underline">
                                                    Ver huella de verificación SHA-256
                                                </summary>

                                                <div
                                                    class="mt-2 w-fit  bg-gray-50 border border-gray-200 p-3 font-mono break-all text-gray-600">
                                                    {{ $documento->file_hash }}
                                                </div>
                                            </details>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="max-w-5xl rounded-xl border border-dashed border-gray-300 p-6 text-gray-500">
                        No hay documentos disponibles en este momento.
                    </div>
                @endif
            </div>
        </div>
        <footer
            class="flex flex-col gap-2 mt-1 text-xs sm:text-sm text-center bg-black snap-start w-full p-3 xl:p-5 text-gray-200 relative">
            <span>GANADERÍA DE RAZAS SELECTAS, S.A. — CIF A47411285.</span> <span class="text-xs">Inscrita en el Registro
                Mercantil de
                Valladolid, Tomo
                752, Folio 52, Hoja 9167. Domicilio: 47015 Valladolid. Actividad: agrícola ganadera.</span>
        </footer>
    </div>
    <script src="./script.js"></script>
@endsection