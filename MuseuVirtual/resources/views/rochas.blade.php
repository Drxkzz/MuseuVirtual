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

<body class="bg-[#363C27]">
    <x-menu_site />

    <h1 class="font-[Arial] text-[50px] ms-80 text-[#F1EEDD] pb-6 pt-16"><strong>Rochas</strong></h1>
    <div class="px-80">
        <img class= "pb-40 w-full object-cover" src="/assets/img/image (3).png" alt="Foto da rocha tal">
    </div>

    <div class="w-full xl:mx-auto grid grid-cols-1 justify-center grid-cols-2 gap-8">
        <div class="grid grid-cols-2 gap-8 ">
            @foreach ($rochas as $item)
                <figure class="w-full">
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
                        <img class="object-cover w-[500px] h-[500px]"
                            src="{{ asset('storage/' . $fotoExibir->caminho) }}" alt="Imagem da rocha tal">
                    @else
                        {{-- Opcional: Adicionar um placeholder se não houver fotos --}}
                        <img class="object-cover w-[500px] h-[500px]" src="{{ asset('assets/img/placeholder.png') }}"
                            alt="Nenhuma imagem disponível">
                    @endif

                    <div class="flex">
                        <div class="flex">
                            <img class="" src="/assets/img/Vector.png" alt="curtir">
                            <img class="" src="/assets/img/Vector (1).png" alt="salvar">
                        </div>
                        <figcaption>
                            <h2 class="font-[Arial] text-[30px] text-[#F1EEDD] pt-4"><strong>Rocha tal</strong></h2>
                        </figcaption>
                    </div>
                </figure>
            @endforeach

        </div>
    </div>

    <figure class="pl-80 pb-20 w-[82%]">
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
    </div>


    <div style="text-align: center;">
        <footer>
            <h3>Entre com sua conta no Museu Virtual</h3>
            <form class="formulario" action="" action="get">
                <input type="text" id="login" name="login" placeholder="Login">
                <br>
                <input type="text" id="Senha" name="Senha" placeholder="Senha">
                <br>
                <input type="button" value="Entrar">
                <br>
                <a href="">Ainda não se cadastrou? Cadastre-se aqui</a>
            </form>
            <img class="imagem_final" src="" alt="">
            <img class="imagem_final" src="" alt="">
        </footer>
    </div>

</body>

</html>
