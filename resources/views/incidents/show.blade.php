<x-layouts.app>
    <x-slot name="title">Ocorrência {{ $incident->code }} - {{ config('app.name') }}</x-slot>

    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Ocorrência <i>{{ $incident->code }}</i></h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Detalhes da ocorrência</h2>
            <div class="max-w-96 max-h-96 shadow-lg rounded-lg overflow-hidden">
                <img src="{{ Storage::url($incident->image) }}" class="object-cover">
            </div>
            <p class="mt-4"><strong>Código da ocorrência:</strong> {{ $incident->code }}</p>
            <p class="mt-4"><strong>Categoria:</strong> {{ $incident->category }}</p>
            <p class="mt-4"><strong>Registrada em:</strong> {{ $incident->created_at }}</p>
        </div>

        <div class="mt-6">
            <a href="/map" class="text-blue-500 hover:underline" wire:navigate>Voltar ao mapa</a>
        </div>
    </div>
</x-layouts.app>