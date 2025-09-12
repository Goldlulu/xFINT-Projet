<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des notes de frais') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            @if(auth()->user()->hasRole('manager'))
                                Toutes les notes de frais
                            @else
                                Notes de frais à traiter
                            @endif
                        </h3>

                        <!-- Filtres -->
                        <div class="flex space-x-4">
                            <select wire:model="statusFilter" class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Tous les statuts</option>
                                <option value="created">Créées</option>
                                <option value="validated">Validées</option>
                                <option value="rejected">Refusées</option>
                                <option value="processed">Traitées</option>
                            </select>
                        </div>
                    </div>

                    @if($reports->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Employé
                                    </th>
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
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $report->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $report->user->email }}</div>
                                        </td>
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
                                            {{ $report->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <button wire:click="viewReport({{ $report->id }})"
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                Voir
                                            </button>

                                            @if(auth()->user()->hasRole('manager'))
                                                @if($report->status === 'created')
                                                    <button wire:click="showValidateModal({{ $report->id }})"
                                                            class="text-green-600 hover:text-green-900">
                                                        Valider
                                                    </button>
                                                    <button wire:click="showRejectModal({{ $report->id }})"
                                                            class="text-red-600 hover:text-red-900">
                                                        Refuser
                                                    </button>
                                                @endif
                                            @endif

                                            @if(auth()->user()->hasRole('accounting'))
                                                @if($report->status === 'validated')
                                                    <button wire:click="processReport({{ $report->id }})"
                                                            class="text-blue-600 hover:text-blue-900">
                                                        Marquer comme traitée
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-gray-500">
                                @if(auth()->user()->hasRole('manager'))
                                    Aucune note de frais trouvée.
                                @else
                                    Aucune note de frais à traiter.
                                @endif
                            </p>
                        </div>
                    @endif

                    {{-- Modal de détails --}}
                    @if($showModal && $selectedReport)
                        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                <div class="mt-3">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            {{ $selectedReport->title }}
                                        </h3>
                                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="space-y-3">
                                        <div>
                                            <strong class="text-sm text-gray-600">Employé:</strong>
                                            <p class="text-sm text-gray-900">{{ $selectedReport->user->name }} ({{ $selectedReport->user->email }})</p>
                                        </div>

                                        <div>
                                            <strong class="text-sm text-gray-600">Commentaire:</strong>
                                            <p class="text-sm text-gray-900">{{ $selectedReport->comment ?: 'Aucun commentaire' }}</p>
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
                                                                <span class="text-xs text-gray-500">({{ number_format($document->size / 1024, 1) }} KB)</span>
                                                            </div>
                                                            <a href="{{ route('download.document', $document) }}"
                                                               class="text-indigo-600 hover:text-indigo-900 text-xs font-medium">
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

                    {{-- Modal de validation --}}
                    @if($showValidationModal)
                        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Valider la note de frais</h3>
                                <p class="text-sm text-gray-600 mb-4">
                                    Êtes-vous sûr de vouloir valider cette note de frais ?
                                </p>
                                <div class="flex justify-end space-x-3">
                                    <button wire:click="closeValidationModal"
                                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        Annuler
                                    </button>
                                    <button wire:click="validateReport"
                                            class="px-4 py-2 bg-green-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-green-700">
                                        Valider
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Modal de refus --}}
                    @if($showRejectionModal)
                        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Refuser la note de frais</h3>

                                <div class="mb-4">
                                    <label for="rejectionComment" class="block text-sm font-medium text-gray-700 mb-2">
                                        Commentaire (optionnel)
                                    </label>
                                    <textarea id="rejectionComment"
                                              wire:model="rejectionComment"
                                              rows="3"
                                              class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                              placeholder="Motif du refus..."></textarea>
                                </div>

                                <div class="flex justify-end space-x-3">
                                    <button wire:click="closeRejectionModal"
                                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        Annuler
                                    </button>
                                    <button wire:click="rejectReport"
                                            class="px-4 py-2 bg-red-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-red-700">
                                        Refuser
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
