<div>
    <form wire:submit="submitIncident" class="p-4">
        <div>
            <label for="photo" class="block text-sm font-medium text-gray-700">Imagem</label>
            <div class="mt-1">
                <input type="file" id="photo" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" wire:model="photo">
            </div>
        </div>

        <div wire:loading wire:target="photo">Carregando foto, aguarde...</div>

        @if ($photo)
            <div class="mt-4">
                <div class="max-w-96 max-h-96 shadow-lg rounded-lg overflow-hidden">
                    <img src="{{ $photo->temporaryUrl() }}" class="object-cover">
                </div>
            </div>
        @endif

        <div class="mt-4">
            <label for="details" class="block text-sm font-medium text-gray-700">Detalhes</label>
            <div class="mt-1">
                <textarea rows="4" id="details" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" wire:model="photoDetailsRaw"></textarea>
            </div>
        </div>

        <div class="mt-4">
            <label for="category" class="block text-sm font-medium text-gray-700">Categoria</label>
            <div class="mt-1">
                <input type="text" id="category" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" wire:model="category">
            </div>
        </div>

        <button type="submit" class="mt-4 inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Registrar ocorrência</button>
    </form>
</div>
