<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RochaEspecifica </title>
    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-gradient-to-b from-[#ACB18E] from-0.5% via-[#73785C] via-5% to-[#363C27] to-20% ">
    <x-menu_site />
    <div class="w-[1600px] mx-auto">

        {{-- @dd($mineral) --}}

        <h1 class= "font-[Arial] text-[50px] text-[#F1EEDD] pt-16"><strong>{{ $mineral->nome }}</strong></h1>
        @foreach ($mineral->fotos as $item)
            @php
                $fotoExibir = null;
                if ($item->capa) {
                    $fotoExibir = $item;
                    break;
                }
                if (is_null($fotoExibir) && count($mineral->fotos) > 0) {
                    $fotoExibir = $mineral->fotos[0];
                }
            @endphp
        @endforeach
        <img class="w-[1600px] h-[832px] rounded-xl" src="{{ asset('storage/' . $fotoExibir->caminho) }}" alt="">

            <div class="flex pt-4 justify-center">
                @foreach ($mineral->fotos as $item)
                    <div class="pr-4">
                        <img class="size-60 rounded-xl" src="{{ asset('storage/' . $item->caminho) }}" alt="">
                    </div>
                @endforeach
            </div>
            <div class="pt-6">
                <h2 class="text-[20px] font-[arial] text-[#F1EEDD]"> <strong> Descrição: </strong>{{ $mineral->descricao}}</h2>
                <br>
                <h2 class="text-[20px] font-[arial] text-[#F1EEDD]"><strong> Composição do mineral: </strong>
                    {{ $mineral->composicao }}</h2>
            </div>
        <x-rodape_site></x-rodape_site>
    </div>
</body>
</html>
