<div wire:poll>
    <x-slot name="title">Ocorrência {{ $incident->code }} - {{ config('app.name') }}</x-slot>

    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Ocorrência <i>{{ $incident->code }}</i></h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Detalhes da ocorrência</h2>
            <div class="max-w-96 max-h-96 shadow-lg rounded-lg overflow-hidden">
                <img src="{{ $incident->image }}" class="object-cover">
            </div>

            <livewire:up-incident-zone :incident="$incident" />

            <p class="mt-4"><strong>Código da ocorrência:</strong> {{ $incident->code }}</p>
            <p class="mt-4"><strong>Categoria:</strong> {{ $incident->category }}</p>
            <p class="mt-4"><strong>Registrada em:</strong> @longDate($incident->created_at)</p>

            <div class="flow-root mt-6">
                <ul role="list" class="-mb-8">
                    @foreach ($incident->history as $history)
                    <li wire:key="{{ $history->id }}">
                        <div class="relative pb-8">
                            @if (!$loop->last)
                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                            @endif
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white">
                                        <!-- Heroicon name: solid/user -->
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div class="text-sm text-gray-500">
                                        @markdown($history->message)
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                        <time datetime="{{ $history->created_at }}">@shortDate($history->created_at)</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="mt-6">
            <a href="/map" class="text-blue-500 hover:underline" wire:navigate>Voltar ao mapa</a>
        </div>
    </div>
</div>
