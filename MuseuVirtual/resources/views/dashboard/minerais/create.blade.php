<x-app-layout>
    {{-- Cabeçalho da página --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ __('Cadastrar Mineral') }}</h2>
    </x-slot>
    <x-slot name="slot">
        <form action="{{ route('minerais.store') }}" method="POST">
            @csrf
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <div class="mb-4">
                                <label for="nome" class="block mt-1 w-full">Nome</label>
                                <input type="text" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" id="nome" name="nome" required>
                            </div>
                            <div class="mb-4">
                                <label for="descricao" class="block mt-1 w-full">Descrição</label>
                                <textarea class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" id="descricao" name="descricao" rows="4" required></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="propriedades" class="block mt-1 w-full">Propriedades</label>
                                <textarea class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" id="propriedades" name="propriedades" rows="4" required></textarea>
                            </div>
                            <div class="flex items-center justify-end mt-6">
                                <x-primary-button type="submit" class="btn btn-primary">Criar</x-primary-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </x-slot>
</x-app-layout>