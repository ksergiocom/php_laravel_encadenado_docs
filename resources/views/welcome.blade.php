@extends('layout.base')

@section('content')
    <div class="h-dvh overflow-y-scroll snap-y snap-mandatory scroll-smooth">
        <div id="hola" class="snap-start h-dvh w-full bg-black relative">
            <video class="h-full w-full object-cover opacity-80 absolute top-0" autoplay muted loop playsinline>
                <source src="{{ Vite::asset('resources/videos/vacas-opt.mp4') }}" type="video/mp4">
            </video>
            <div class="absolute top-0 flex flex-col gap-5 p-5 xl:p-10 text-white place-content-between h-full">
                <h2 class="text-8xl xl:text-9xl tracking-wide w-fit fade-in">¡Hola!</h2>
                <div class="flex flex-col items-center self-start gap-3">
                    <p class="text-lg xl:text-xl font-thin xl:font-normal tracking-widest rotate-180"
                        style="writing-mode: vertical-rl;">¡Deslízate!</p>
                    <a href="#como" class="animate-bounce text-5xl xl:text-7xl mt-2">&darr;</a>
                </div>
            </div>
        </div>
        <div id="como" class="snap-start min-h-dvh w-full bg-black xl:content-center  p-5 text-white gap-5 relative">
            <div class="flex flex-col gap-5 xl:max-w-2xl mx-auto">

                <h2 class="text-4xl xl:text-7xl fade-in">¿CÓMO PUDO NADAR <span class="text-red-600">TAN LEJOS</span>?
                </h2>
                <p class="xl:text-xl fade-in">Pues bien, por una parte, y aunque cada especie tiene unas características
                    algo
                    distintas, todas
                    ellas poseen un&nbsp;plumaje especial y una gruesa capa de grasa que <strong>les permite repeler el
                        agua y aislarse del frío</strong>, manteniendo una temperatura corporal de unos 40 grados
                    centígrados.</p>
                <p class="xl:text-xl fade-in">Por otra parte, los pingüinos <strong>pueden beber agua salada</strong>, a
                    diferencia de muchos
                    animales. Esto les permite beber del agua del mar, que procesan mediante la glándula supraorbital.
                    Así, a pesar de su largo viaje, era factible que este ejemplar de pingüino emperador sobreviviera y
                    llegara hacia costas tan lejanas como las de Australia.&nbsp;</p>
            </div>
            <a href="#peligros" class="animate-bounce text-5xl xl:text-7xl absolute bottom-0">&darr;</a>
        </div>
        <div id="peligros"
            class="snap-start min-h-dvh w-full bg-gradient-to-br bg-black xl:content-center  p-5 text-white relative">
            <img class="h-full w-full object-cover absolute top-0 left-0 opacity-40"
                src="{{ Vite::asset('resources/images/granaja.jpg') }}" alt="granja">
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="flex flex-col gap-5 xl:max-w-2xl mx-auto relative z-10">

                <h2 class="text-4xl xl:text-7xl uppercase fade-in">Los <span class="text-red-500">peligros</span> que
                    acechan a
                    los
                    pingüinos
                </h2>
                <p class="xl:text-xl fade-in">Cada 25 de abril se celebra el<strong> Día Mundial del Pingüino</strong>,
                    una
                    iniciativa
                    internacional
                    ideada para <strong>concienciar a la población sobre la importancia de proteger a estas
                        aves</strong>,
                    cuya población ha disminuido drásticamente en el último siglo.</p>
                <p class="xl:text-xl fade-in">De las 18 especies de pingüino que habita el planeta, <strong>10 se
                        encuentran
                        amenazadas, y de
                        estas, 5
                        están catalogadas como ‘en peligro’ </strong>por la <strong>Unión Internacional de Conservación
                        de
                        la Naturaleza</strong>, de ahí la importancia de llevar a cabo medidas efectivas que ayuden a
                    combatir sus principales amenazas: el calentamiento global, la contaminación de los océanos, la
                    expansión de especies invasoras o la sobrepesca.</p>
            </div>
            <a href="#sobre" class="animate-bounce text-5xl xl:text-7xl absolute bottom-0 z-10">&darr;</a>
        </div>
        <div id="sobre" class="snap-start h-dvh w-full bg-black relative">
            <img class="h-full w-full object-cover opacity-20 absolute top-0"
                src="{{ Vite::asset('resources/images/vaca.jpg') }}" alt="vaca">
            <div class="absolute top-0 p-5 text-white relative h-full xl:content-center">
                <div class="flex flex-col gap-5 xl:max-w-2xl mx-auto">

                    <h2 class="text-4xl xl:text-7xl fade-in">AHORA UN POCO <span class="text-red-600">SOBRE MÍ</span>
                    </h2>
                    <p class="xl:text-xl fade-in">Nací en las frías tierras del noreste, donde dirigí mi propia
                        empresa. Durante años, el <strong>mundo de los negocios</strong> fue mi
                        vida, pero en el fondo siempre sentí una <strong>atracción irresistible por la
                            tecnología</strong>.
                        Un día, decidí dejar todo atrás y sumergirme en el universo de la informática, donde descubrí mi
                        verdadera pasión: Linux, la programación y las redes.</p>
                    <p class="xl:text-xl fade-in">Desde entonces, me he vuelto casi obsesivo con el aprendizaje.
                        Exploro cada
                        rincón
                        del software, desarrollo proyectos y profundizo en la seguridad. Ahora estudio con el solo
                        objetivo
                        en mente de <strong class="text-red-600">entender y desafiar</strong> los límites del océano
                        informático.</p>
                </div>
                <a href="#anuncios" class="animate-bounce text-5xl xl:text-7xl absolute bottom-0">&darr;</a>
            </div>
        </div>
        <div id="anuncios" class="snap-start min-h-dvh w-full bg-gray-50  p-5 xl:p-7 text-gray-900 gap-5 relative">
            <div class="flex flex-col gap-5">
                <h2 class="text-4xl xl:text-7xl">TABLÓN DE ANUNCIOS
                </h2>
                <p class="max-w-5xl mt-3 mb-7 text-sm xl:text-xl text-gray-800 leading-relaxed">
                    En cumplimiento de lo previsto en el <strong>artículo 11 ter de la Ley de Sociedades de
                        Capital</strong>,
                    la sociedad pone a disposición de los interesados la documentación publicada en esta página web,
                    garantizando el acceso gratuito a su consulta, descarga e impresión, así como la autenticidad de los
                    documentos insertados y la constancia de su fecha de publicación.
                </p>
                @if($documentos->isNotEmpty())
                    <div class="grid gap-4">
                        @foreach($documentos as $documento)
                            <article
                                class="group border border-gray-200 p-4 xl:p-5  transition bg-white">
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
        <footer class="mt-1 text-center bg-black snap-start w-full p-5 xl:p-7 text-gray-200 gap-5 relative">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis, modi!
        </footer>
    </div>
    <script src="./script.js"></script>
@endsection