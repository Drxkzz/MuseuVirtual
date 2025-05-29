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
    <x-menu_site/>
    
    <h1 class="font-[Arial] text-[50px] ms-80 text-[#F1EEDD] pb-6 pt-16"><strong>Rochas</strong></h1>
    <div class="px-80">
        <img class= "pb-40 w-full object-cover" src="/assets/img/image (3).png" alt="Foto da rocha tal">
    </div>

     <div class="grid grid-cols-2 gap-8 ">
        <figure class="pl-80 w-full">
            <img class="object-cover" src="/assets/img/image (2).png" alt="Imagem da rocha tal">
            <div class="flex justify-between items-center p-4 text-white">
            <span class="font-[Arial] text-[30px] text-[#F1EEDD] font-bold">Rocha tal</span>
            <div class="flex space-x-4">
                <i class="text-2xl flex gap-2 cursor-pointer hover:text-gray-300 transition-colors duration-200">
                   <img class="" src="/assets/img/Vector.png" alt="curtir">
                   <img class="" src="/assets/img/Vector (1).png" alt="salvar">
                </i>
                <i class="fa-solid fa-download text-2xl cursor-pointer hover:text-gray-300 transition-colors duration-200"></i>
            </div>
        </figure>
        <figure class= "pb-20 w-full ">
            <img class="object-cover" src="/assets/img/image (2).png" alt="Imagem da rocha tal">
            <div class="flex justify-between items-center p-4 text-white">
            <span class="font-[Arial] text-[30px] text-[#F1EEDD] font-bold">Rocha tal</span>
            <div class="flex space-x-4">
                <i class="text-2xl flex gap-2 cursor-pointer hover:text-gray-300 transition-colors duration-200">
                   <img class="" src="/assets/img/Vector.png" alt="curtir">
                   <img class="" src="/assets/img/Vector (1).png" alt="salvar">
                </i>
                <i class="fa-solid fa-download text-2xl cursor-pointer hover:text-gray-300 transition-colors duration-200"></i>
            </div>
        </figure>
    </div>

    <figure class="pl-80 pb-20 w-[82%]">
            <img src="/assets/img/image (3).png" alt="Imagem da rocha tal">
            <div class="flex justify-between items-center p-4 text-white">
            <span class="font-[Arial] text-[30px] text-[#F1EEDD] font-bold">Rocha tal</span>
            <div class="flex space-x-4">
                <i class="text-2xl flex gap-2 cursor-pointer hover:text-gray-300 transition-colors duration-200">
                   <img class="" src="/assets/img/Vector.png" alt="curtir">
                   <img class="" src="/assets/img/Vector (1).png" alt="salvar">
                </i>
                <i class="fa-solid fa-download text-2xl cursor-pointer hover:text-gray-300 transition-colors duration-200"></i>
            </div>
        </figure>
    
    <div class="grid grid-cols-2 gap-8">
        <figure class="pl-80 ">
            <img src="/assets/img/image (2).png" alt="Imagem da rocha tal">
            <div class="flex justify-between items-center p-4 text-white">
            <span class="font-[Arial] text-[30px] text-[#F1EEDD] font-bold">Rocha tal</span>
            <div class="flex space-x-4">
                <i class="text-2xl flex gap-2 cursor-pointer hover:text-gray-300 transition-colors duration-200">
                   <img class="" src="/assets/img/Vector.png" alt="curtir">
                   <img class="" src="/assets/img/Vector (1).png" alt="salvar">
                </i>
                <i class="fa-solid fa-download text-2xl cursor-pointer hover:text-gray-300 transition-colors duration-200"></i>
            </div>
        </figure>
        <figure class="pl-2 pb-20">
            <img src="/assets/img/image (2).png" alt="Imagem da rocha tal">
            <div class="flex justify-between items-center p-4 text-white">
            <span class="font-[Arial] text-[30px] text-[#F1EEDD] font-bold">Rocha tal</span>
            <div class="flex space-x-4 ">
                <i class="text-2xl flex gap-2 cursor-pointer hover:text-gray-300 transition-colors duration-200">
                   <img class="" src="/assets/img/Vector.png" alt="curtir">
                   <img class="" src="/assets/img/Vector (1).png" alt="salvar">
                </i>
                <i class="fa-solid fa-download text-2xl cursor-pointer hover:text-gray-300 transition-colors duration-200"></i>
            </div>
        </figure>
    </div>
    <x-rodape_site></x-rodape_site>
</body>
</html>