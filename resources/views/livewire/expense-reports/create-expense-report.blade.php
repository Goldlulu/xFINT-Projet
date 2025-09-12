<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Créer une note de frais') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <form wire:submit.prevent="save">
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Titre -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700">
                                Titre de la note de frais *
                            </label>
                            <input type="text"
                                   id="title"
                                   wire:model="title"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Ex: Frais de déplacement client X">
                            @error('title')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Commentaire -->
                        <div>
                            <label for="comment" class="block text-sm font-medium text-gray-700">
                                Commentaire
                            </label>
                            <textarea id="comment"
                                      wire:model="comment"
                                      rows="4"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                      placeholder="Détails sur les frais engagés..."></textarea>
                            @error('comment')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Upload de fichiers -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Pièces justificatives *
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="newDocuments" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Ajouter des fichiers</span>
                                            <input id="newDocuments"
                                                   type="file"
                                                   wire:model="newDocuments"
                                                   multiple
                                                   accept=".pdf,.jpg,.jpeg,.png"
                                                   class="sr-only">
                                        </label>
                                        <p class="pl-1">ou glisser-déposer</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PDF, PNG, JPG jusqu'à 10MB chacun
                                    </p>
                                </div>
                            </div>
                            @error('documents')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                            @error('newDocuments.*')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                            @enderror
                            <!-- Liste des fichiers sélectionnés -->
                            @if(count($documents) > 0)
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">
                                        Pièces justificatives sélectionnées ({{ count($documents) }}) :
                                    </h4>
                                    <ul class="space-y-2">
                                        @foreach($documents as $index => $document)
                                            <li class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border">
                                                <div class="flex items-center space-x-3">
                                                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <div>
                                                        <span class="text-sm font-medium text-gray-900">{{ $document->getClientOriginalName() }}</span>
                                                        <div class="text-xs text-gray-500">
                                                            {{ number_format($document->getSize() / 1024, 1) }} KB
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="button"
                                                        wire:click="removeDocument({{ $index }})"
                                                        class="text-red-500 hover:text-red-700 p-1">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="mt-3">
                                        <label for="newDocuments-add" class="cursor-pointer inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Ajouter d'autres fichiers
                                            <input id="newDocuments-add"
                                                   type="file"
                                                   wire:model="newDocuments"
                                                   multiple
                                                   accept=".pdf,.jpg,.jpeg,.png"
                                                   class="sr-only">
                                        </label>
                                    </div>
                                </div>
                            @endif

                            <!-- Indicateur de chargement -->
                            <div wire:loading wire:target="newDocuments" class="mt-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Téléchargement en cours...
                                </div>
                            </div>
                        </div>
                            <!-- Aperçu des fichiers sélectionnés -->
                            @if($documents)
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-2">Fichiers sélectionnés :</h4>
                                    <ul class="space-y-2">
                                        @foreach($documents as $index => $document)
                                            <li class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                                <span class="text-sm text-gray-600">{{ $document->getClientOriginalName() }}</span>
                                                <button type="button"
                                                        wire:click="removeDocument({{ $index }})"
                                                        class="text-red-500 hover:text-red-700">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Indicateur de chargement -->
                            <div wire:loading wire:target="documents" class="mt-2">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Téléchargement en cours...
                                </div>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('my-expense-reports') }}"
                               class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Annuler
                            </a>
                            <button type="submit"
                                    wire:loading.attr="disabled"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                                <span wire:loading.remove wire:target="save">Créer la note</span>
                                <span wire:loading wire:target="save">Création en cours...</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
