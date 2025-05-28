<x-layouts.app>
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
                    <li>
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
                    {{-- <li>
                        <div class="relative pb-8">
                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
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
                                    <div>
                                        <p class="text-sm text-gray-500">Applied to <a href="#" class="font-medium text-gray-900">Front End Developer</a></p>
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                        <time datetime="2020-09-20">Sep 20</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="relative pb-8">
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white">
                                        <!-- Heroicon name: solid/check -->
                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Completed interview with <a href="#" class="font-medium text-gray-900">Katherine Snyder</a></p>
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                        <time datetime="2020-10-04">Oct 4</time>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li> --}}
                </ul>
            </div>
        </div>

        <div class="mt-6">
            <a href="/map" class="text-blue-500 hover:underline" wire:navigate>Voltar ao mapa</a>
        </div>
    </div>
</x-layouts.app>