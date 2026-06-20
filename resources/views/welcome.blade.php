@extends('layout.base')

@section('content')
    <div class="h-dvh overflow-y-scroll snap-y snap-mandatory scroll-smooth">
        <div id="hola" class="snap-start h-dvh w-full bg-black relative">
            <img class="h-full w-full object-cover opacity-80 absolute top-0"
                src="{{ Vite::asset('resources/images/pinguino.webp') }}" alt="pinguino">
            <div class="absolute top-0 flex flex-col gap-5 p-5 xl:p-10 text-white place-content-between h-full">
                <h2 class="text-8xl xl:text-9xl tracking-wide w-fit fade-in">¡Hola!</h2>
                <div class="flex flex-col items-center self-start gap-3">
                    <p class="text-lg xl:text-xl font-thin xl:font-normal tracking-widest rotate-180"
                        style="writing-mode: vertical-rl;">¡Deslízate!</p>
                    <a href="#voy" class="animate-bounce text-5xl xl:text-7xl mt-2">&darr;</a>
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
            class="snap-start min-h-dvh w-full bg-gradient-to-br from-red-600 to-red-800 xl:content-center  p-5 text-white relative">
            <div class="flex flex-col gap-5 xl:max-w-2xl mx-auto">

                <h2 class="text-4xl xl:text-7xl uppercase fade-in">Los <span class="text-gray-900">peligros</span> que
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
            <a href="#sobre" class="animate-bounce text-5xl xl:text-7xl absolute bottom-0">&darr;</a>
        </div>
        <div id="voy" class="snap-start min-h-dvh w-full bg-white  p-5 xl:p-7 text-gray-900 gap-5 relative">
            <div class="flex flex-col gap-5">
                <h2 class="text-4xl xl:text-7xl fade-in">Publicación de anuncios
                </h2>
                <p class="max-w-5xl text-sm xl:text-base text-gray-600 leading-relaxed fade-in">
                    En cumplimiento de lo previsto en el <strong>artículo 11 ter de la Ley de Sociedades de
                        Capital</strong>,
                    la sociedad pone a disposición de los interesados la documentación publicada en esta página web,
                    garantizando el acceso gratuito a su consulta, descarga e impresión, así como la autenticidad de los
                    documentos insertados y la constancia de su fecha de publicación.
                </p>
                @if($documentos->isNotEmpty())
                    <ul>
                        @foreach($documentos as $documento)
                            <li>
                                <a class="text-gray-600 hover:text-gray-900 hover:underline"
                                    href="{{ asset('storage/' . $documento->path) }}">{{ $loop->iteration }}.
                                    {{ $documento->titulo }} versión {{ $documento->version }}.0
                                    <span class="text-xs">{{$documento->publicado_at->format('d/m/Y')}}</span>
                                    @if($documento->estado != 'publicado')
                                        <span class="text-xs">({{ $documento->estado }} el
                                            {{$documento->retirado_at->format('d/m/Y')}})</span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No hay documentos disponibles.</p>
                @endif
            </div>
            <a href="#como" class="animate-bounce text-5xl xl:text-7xl absolute bottom-0">&darr;</a>
        </div>
        <div id="sobre" class="snap-start h-dvh w-full bg-black relative">
            <img class="h-full w-full object-cover opacity-20 absolute top-0 blur"
                src="{{ Vite::asset('resources/images/yo.webp') }}" alt="yo">
            <div class="absolute top-0 p-5 text-white relative h-full xl:content-center">
                <div class="flex flex-col gap-5 xl:max-w-2xl mx-auto">

                    <h2 class="text-4xl xl:text-7xl fade-in">AHORA UN POCO <span class="text-red-600">SOBRE MÍ</span>
                    </h2>
                    <p class=" xl:text-xl fade-in">Nací en las frías tierras del noreste, donde dirigí mi propia
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
                <a href="#hola" class="animate-bounce text-5xl xl:text-7xl absolute top-5">&uarr;</a>
            </div>
        </div>
    </div>
    <script src="./script.js"></script>
@endsection