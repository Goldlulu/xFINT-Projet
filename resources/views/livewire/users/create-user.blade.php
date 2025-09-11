<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Créer un utilisateur') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Ajouter un nouvel utilisateur</h3>

                    @if(session()->has('message'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="createUser">
                        <div class="space-y-6">
                            <!-- Email uniquement -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    Adresse email *
                                </label>
                                <input type="email"
                                       id="email"
                                       wire:model="email"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="utilisateur@supherman.com">
                                @error('email')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Rôle -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">
                                    Rôle *
                                </label>
                                <select id="role"
                                        wire:model="role"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Sélectionner un rôle</option>
                                    <option value="employee">Employé</option>
                                    <option value="manager">Manager</option>
                                    <option value="accounting">Comptabilité</option>
                                </select>
                                @error('role')
                                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Info mot de passe -->
                            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800">
                                            Mot de passe temporaire
                                        </h3>
                                        <div class="mt-2 text-sm text-blue-700">
                                            <p>Un mot de passe temporaire sera généré automatiquement. L'utilisateur devra le changer lors de sa première connexion.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Boutons -->
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('all-expense-reports') }}"
                                   class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Annuler
                                </a>
                                <button type="submit"
                                        wire:loading.attr="disabled"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50">
                                    <span wire:loading.remove wire:target="createUser">Créer l'utilisateur</span>
                                    <span wire:loading wire:target="createUser">Création en cours...</span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Liste des utilisateurs existants -->
                    @if($users->count() > 0)
                        <div class="mt-12 border-t pt-8">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Utilisateurs existants ({{ $users->count() }})</h4>
                            <div class="space-y-2">
                                @foreach($users as $user)
                                    <div class="border rounded p-3 flex justify-between items-center">
                                        <div>
                                            <div class="font-medium">{{ $user->email }}</div>
                                            <div class="text-sm text-gray-500">
                                                Rôle: {{ $user->roles->pluck('name')->implode(', ') ?: 'Aucun' }}
                                                @if($user->must_change_password)
                                                    <span class="ml-2 text-yellow-600">(Doit changer MDP)</span>
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                Créé le {{ $user->created_at->format('d/m/Y') }}
                                            </div>
                                        </div>
                                        @if($user->must_change_password)
                                            <button wire:click="resetPassword({{ $user->id }})"
                                                    class="text-indigo-600 hover:text-indigo-900 text-sm">
                                                Réinitialiser MDP
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Modal de succès -->
                    @if($showSuccessModal && $temporaryPassword)
                        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center">
                            <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
                                <div class="text-center">
                                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                                        <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <h3 class="mt-4 text-lg font-medium text-gray-900">Utilisateur créé avec succès !</h3>
                                    <div class="mt-4 bg-gray-50 p-4 rounded">
                                        <p class="text-sm text-gray-600 mb-2">Mot de passe temporaire :</p>
                                        <div class="bg-white p-2 border rounded font-mono text-sm text-center select-all">
                                            {{ $temporaryPassword }}
                                        </div>
                                        <p class="text-xs text-gray-500 mt-2">
                                            Sélectionnez le texte ci-dessus pour le copier. L'utilisateur devra changer ce mot de passe lors de sa première connexion.
                                        </p>
                                    </div>
                                    <div class="mt-6">
                                        <button wire:click="closeSuccessModal"
                                                class="w-full px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                            Fermer
                                        </button>
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
