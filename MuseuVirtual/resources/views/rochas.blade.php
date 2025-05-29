<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rochas </title>
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-gradient-to-b from-[#ACB18E] from-0.5% via-[#73785C] via-5% to-[#363C27] to-20% ">
    <x-menu_site />

    <h1 class="font-[Arial] text-[50px] ms-80 text-[#F1EEDD] pb-6 pt-16"><strong>Rochas</strong></h1>
    <div class="px-80">
        <img class= "pb-40 w-full object-cover" src="/assets/img/image (3).png" alt="Foto da rocha tal">
    </div>

    {{-- tipo 1 --}}
    <div class="flex grid grid-cols-2 gap-6 mt-20">
        <h2 class="font-[Arial] text-[40px] text-[#F1EEDD]"><strong>tipo 1</strong></h2>
        <p class="font-[Arial] text-[20px] text-[#F1EEDD]">Ver mais</p>
    </div>
    <div class="w-full xl:mx-auto">
        <div class="grid grid-cols-2 gap-8 ">
            @foreach ($rochastipo1 as $item)
                <figure class="w-full ">
                    @php
                        $fotoExibir = null; // Inicializa como nulo
                        // Tenta encontrar uma foto com capa
                        foreach ($item->fotos as $foto) {
                            if ($foto->capa) {
                                $fotoExibir = $foto;
                                break; // Encontrou a capa, pode parar
                            }
                        }

                        // Se nenhuma capa foi encontrada, usa a primeira foto (se existir)
                        if (is_null($fotoExibir) && count($item->fotos) > 0) {
                            $fotoExibir = $item->fotos[0];
                        }
                    @endphp

                    @if ($fotoExibir)
                        {{-- Verifica se uma foto foi encontrada para exibir --}}
                        <img class="object-cover w-[500px] h-[500px] rounded-xl"
                            src="{{ asset('storage/' . $fotoExibir->caminho) }}" alt="Imagem da rocha tal">
                        <div class="flex">
                            {{-- <div class="flex">
                                <img class="" src="/assets/img/Vector.png" alt="curtir">
                                <img class="" src="/assets/img/Vector (1).png" alt="salvar">
                            </div> --}}
                            <figcaption>
                                <h2 class="font-[Arial] text-[30px] text-[#F1EEDD] pt-4">
                                    <strong>{{ $item->nome }}</strong></h2>
                            </figcaption>
                        </div>
                    @else
                        {{-- Opcional: Adicionar um placeholder se não houver fotos --}}
                        <img class="object-cover w-[500px] h-[500px] rounded-xl"
                            src="{{ asset('assets/img/placeholder.png') }}" alt="Nenhuma imagem disponível">
                        <div class="flex">
                            {{-- <div class="flex">
                                <img class="" src="/assets/img/Vector.png" alt="curtir">
                                <img class="" src="/assets/img/Vector (1).png" alt="salvar">
                            </div> --}}
                            <figcaption>
                                <h2 class="font-[Arial] text-[30px] text-[#F1EEDD] pt-4">
                                    <strong>{{ $item->nome }}</strong></h2>
                            </figcaption>
                        </div>
                    @endif

                </figure>
            @endforeach

        </div>
    </div>
    {{-- tipo 2 --}}
    <div class="flex grid grid-cols-2 gap-6 mt-20">
        <h2 class="font-[Arial] text-[40px] text-[#F1EEDD]"><strong>tipo 2</strong></h2>
        <p class="font-[Arial] text-[20px] text-[#F1EEDD]">Ver mais</p>
    </div>
    <div class="w-full xl:mx-auto">
        <div class="grid grid-cols-2 gap-8 ">
            @foreach ($rochastipo2 as $item)
                <figure class="w-full ">
                    @php
                        $fotoExibir = null; // Inicializa como nulo
                        // Tenta encontrar uma foto com capa
                        foreach ($item->fotos as $foto) {
                            if ($foto->capa) {
                                $fotoExibir = $foto;
                                break; // Encontrou a capa, pode parar
                            }
                        }

                        // Se nenhuma capa foi encontrada, usa a primeira foto (se existir)
                        if (is_null($fotoExibir) && count($item->fotos) > 0) {
                            $fotoExibir = $item->fotos[0];
                        }
                    @endphp

                    @if ($fotoExibir)
                        {{-- Verifica se uma foto foi encontrada para exibir --}}
                        <img class="object-cover w-[500px] h-[500px] rounded-xl"
                            src="{{ asset('storage/' . $fotoExibir->caminho) }}" alt="Imagem da rocha tal">
                        <div class="flex">
                            {{-- <div class="flex">
                                <img class="" src="/assets/img/Vector.png" alt="curtir">
                                <img class="" src="/assets/img/Vector (1).png" alt="salvar">
                            </div> --}}
                            <figcaption>
                                <h2 class="font-[Arial] text-[30px] text-[#F1EEDD] pt-4">
                                    <strong>{{ $item->nome }}</strong></h2>
                            </figcaption>
                        </div>
                    @else
                        {{-- Opcional: Adicionar um placeholder se não houver fotos --}}
                        <img class="object-cover w-[500px] h-[500px] rounded-xl"
                            src="{{ asset('assets/img/placeholder.png') }}" alt="Nenhuma imagem disponível">
                        <div class="flex">
                            {{-- <div class="flex">
                                <img class="" src="/assets/img/Vector.png" alt="curtir">
                                <img class="" src="/assets/img/Vector (1).png" alt="salvar">
                            </div> --}}
                            <figcaption>
                                <h2 class="font-[Arial] text-[30px] text-[#F1EEDD] pt-4">
                                    <strong>{{ $item->nome }}</strong></h2>
                            </figcaption>
                        </div>
                    @endif
                </figure>
            @endforeach

        </div>
    </div>
    {{-- tipo 3 --}}
    <div class="flex grid grid-cols-2 gap-6 mt-20">
        <h2 class="font-[Arial] text-[40px] text-[#F1EEDD]"><strong>tipo 3</strong></h2>
        <p class="font-[Arial] text-[20px] text-[#F1EEDD]">Ver mais</p>
    </div>
    <div class="w-full xl:mx-auto">
        <div class="grid grid-cols-2 gap-8 ">
            @foreach ($rochastipo3 as $item)
                <figure class="w-full ">
                    @php
                        $fotoExibir = null; // Inicializa como nulo
                        // Tenta encontrar uma foto com capa
                        foreach ($item->fotos as $foto) {
                            if ($foto->capa) {
                                $fotoExibir = $foto;
                                break; // Encontrou a capa, pode parar
                            }
                        }

                        // Se nenhuma capa foi encontrada, usa a primeira foto (se existir)
                        if (is_null($fotoExibir) && count($item->fotos) > 0) {
                            $fotoExibir = $item->fotos[0];
                        }
                    @endphp

                    @if ($fotoExibir)
                        {{-- Verifica se uma foto foi encontrada para exibir --}}
                        <img class="object-cover w-[500px] h-[500px] rounded-xl"
                            src="{{ asset('storage/' . $fotoExibir->caminho) }}" alt="Imagem da rocha tal">
                        <div class="flex">
                            {{-- <div class="flex">
                                <img class="" src="/assets/img/Vector.png" alt="curtir">
                                <img class="" src="/assets/img/Vector (1).png" alt="salvar">
                            </div> --}}
                            <figcaption>
                                <h2 class="font-[Arial] text-[30px] text-[#F1EEDD] pt-4">
                                    <strong>{{ $item->nome }}</strong></h2>
                            </figcaption>
                        </div>
                    @else
                        {{-- Opcional: Adicionar um placeholder se não houver fotos --}}
                        <img class="object-cover w-[500px] h-[500px] rounded-xl"
                            src="{{ asset('assets/img/placeholder.png') }}" alt="Nenhuma imagem disponível">

                        <div class="flex">
                            {{-- <div class="flex">
                                <img class="" src="/assets/img/Vector.png" alt="curtir">
                                <img class="" src="/assets/img/Vector (1).png" alt="salvar">
                            </div> --}}
                            <figcaption>
                                <h2 class="font-[Arial] text-[30px] text-[#F1EEDD] pt-4">
                                    <strong>{{ $item->nome }}</strong></h2>
                            </figcaption>
                        </div>
                    @endif
                    {{-- <div class="flex">
                        <div class="flex">
                            <img class="" src="/assets/img/Vector.png" alt="curtir">
                            <img class="" src="/assets/img/Vector (1).png" alt="salvar">
                        </div>
                        <figcaption>
                            <h2 class="font-[Arial] text-[30px] text-[#F1EEDD] pt-4"><strong>Rocha tal</strong></h2>
                        </figcaption>
                    </div> --}}
                </figure>
            @endforeach
        </div>
    </div>

    {{-- <figure class="pl-80 pb-20 w-[82%]">
        <img src="/assets/img/image (3).png" alt="Imagem da rocha tal">
        <figcaption>
            <h2 class="font-[Arial] text-[30px] text-[#F1EEDD] pt-4"><strong>Rocha tal</strong></h2>
        </figcaption>
    </figure>

    <div class="grid grid-cols-2 gap-8">
        <figure class="pl-80 ">
            <img src="/assets/img/image (2).png" alt="Imagem da rocha tal">
            <figcaption>
                <h2 class="font-[Arial] text-[30px] text-[#F1EEDD] pt-4"><strong>Rocha tal</strong></h2>
            </figcaption>
        </figure>
        <figure class="pl-2 pb-40">
            <img src="/assets/img/image (2).png" alt="Imagem da rocha tal">
            <figcaption>
                <h2 class="font-[Arial] text-[30px] text-[#F1EEDD] pt-4"><strong>Rocha tal</strong></h2>
            </figcaption>
        </figure>
    </div> --}}

    <x-rodape_site></x-rodape_site>
</body>

</html>
