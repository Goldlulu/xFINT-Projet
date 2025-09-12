<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes notes de frais') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            Mes notes de frais
                        </h3>
                        <a href="{{ route('create-expense-report') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Créer une note
                        </a>
                    </div>

                    @if($reports->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Titre
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reports as $report)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $report->title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if($report->status === 'created') bg-yellow-100 text-yellow-800
                                                @elseif($report->status === 'validated') bg-green-100 text-green-800
                                                @elseif($report->status === 'rejected') bg-red-100 text-red-800
                                                @else bg-blue-100 text-blue-800 @endif">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $report->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button wire:click="viewReport({{ $report->id }})"
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                Voir détails
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">Aucune note de frais trouvée.</p>
                            <a href="{{ route('create-expense-report') }}"
                               class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Créer ma première note
                            </a>
                        </div>
                    @endif

                    {{-- Modal pour les détails --}}
                    @if($showModal && $selectedReport)
                        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                <div class="mt-3">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            {{ $selectedReport->title }}
                                        </h3>
                                        <button wire:click="$set('showModal', false)"
                                                class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <strong class="text-sm text-gray-600">Commentaire:</strong>
                                            <p class="text-sm text-gray-900">{{ $selectedReport->comment ?: 'Aucun commentaire' }}</p>
                                        </div>

                                        <div>
                                            <strong class="text-sm text-gray-600">Statut:</strong>
                                            <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($selectedReport->status === 'created') bg-yellow-100 text-yellow-800
                                            @elseif($selectedReport->status === 'validated') bg-green-100 text-green-800
                                            @elseif($selectedReport->status === 'rejected') bg-red-100 text-red-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ ucfirst($selectedReport->status) }}
                                        </span>
                                        </div>

                                        @if($selectedReport->manager_comment)
                                            <div>
                                                <strong class="text-sm text-gray-600">Commentaire du manager:</strong>
                                                <p class="text-sm text-gray-900">{{ $selectedReport->manager_comment }}</p>
                                            </div>
                                        @endif

                                        @if($selectedReport->documents->count() > 0)
                                            <div>
                                                <strong class="text-sm text-gray-600">Pièces justificatives:</strong>
                                                <ul class="mt-1 text-sm text-gray-900">
                                                    @foreach($selectedReport->documents as $document)
                                                        <li class="flex items-center justify-between space-x-2 py-1">
                                                            <div class="flex items-center space-x-2">
                                                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                <span>{{ $document->original_name }}</span>
                                                            </div>
                                                            <a href="{{ route('download.document', $document) }}"
                                                               class="text-indigo-600 hover:text-indigo-900 text-xs">
                                                                Télécharger
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
