<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Mineral') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Formulário de edição --}}
                    <form action="{{ route('minerais.update', $mineral->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nome --}}
                        <div class="mb-4">
                            <x-input-label for="nome" :value="__('Nome')" />
                            <x-text-input id="nome" name="nome" type="text" class="block mt-1 w-full"
                                        :value="old('nome', $mineral->nome)" />
                        </div>

                        {{-- Descrição --}}
                        <div class="mb-4">
                            <x-input-label for="descricao" :value="__('Descrição')" />
                            <textarea id="descricao" name="descricao" rows="4"
                                      class="block mt-1 w-full border-gray-300 dark:border-gray-700 
                                      dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 
                                      dark:focus:border-indigo-600 focus:ring-indigo-500 
                                      dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                {{ old('descricao', $mineral->descricao) }}
                            </textarea>
                        </div>

                        {{-- Propriedades --}}
                        <div class="mb-4">
                            <x-input-label for="propriedades" :value="__('Propriedades')" />
                            <textarea id="propriedades" name="propriedades" rows="4"
                                      class="block mt-1 w-full border-gray-300 dark:border-gray-700 
                                      dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 
                                      dark:focus:border-indigo-600 focus:ring-indigo-500 
                                      dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                {{ old('propriedades', $mineral->propriedades) }}
                            </textarea>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Salvar Alterações') }}
                            </x-primary-button>
                        </div>
                    </form>

                    {{-- Exibição das fotos do mineral --}}
                    <div class="mt-6">
                        <h2 class="text-xl font-semibold">{{ __('Fotos do Mineral') }}</h2>
                        <div class="flex flex-wrap">
                            @if ($mineral->fotos->isEmpty())
                                <p>Não há fotos cadastradas para este mineral.</p>
                            @else
                                @foreach ($mineral->fotos as $foto)
                                    <div class="p-2 border rounded-md mx-2">
                                        <img src="{{ asset('storage/' . $foto->caminho) }}" alt="Foto do Mineral" class="h-32 w-32 object-cover mb-2">
                                        <div class="flex gap-2">
                                            <a href="{{ route('fotos-edit', $foto->id) }}" class="text-blue-500">Editar</a>
                                            <form action="{{ route('fotos-destroy', $foto->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta foto?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500">Excluir</button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
