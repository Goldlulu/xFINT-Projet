<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Changement de mot de passe requis</h2>
            <p class="mt-2 text-sm text-gray-600">
                Pour des raisons de sécurité, vous devez changer votre mot de passe temporaire lors de votre première connexion.
            </p>
        </div>

        @if(session()->has('message'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="changePassword">
            <!-- Mot de passe actuel -->
            <div class="mb-4">
                <label for="current_password" class="block text-sm font-medium text-gray-700">
                    Mot de passe actuel *
                </label>
                <input type="password"
                       id="current_password"
                       wire:model="current_password"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="Votre mot de passe temporaire">
                @error('current_password')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nouveau mot de passe -->
            <div class="mb-4">
                <label for="new_password" class="block text-sm font-medium text-gray-700">
                    Nouveau mot de passe * <span class="text-xs text-gray-500">({{ strlen($new_password ?? '') }}/30)</span>
                </label>
                <input type="password"
                       id="new_password"
                       wire:model="new_password"
                       maxlength="30"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="8 à 30 caractères">
                @error('new_password')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirmation du nouveau mot de passe -->
            <div class="mb-6">
                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">
                    Confirmer le nouveau mot de passe *
                </label>
                <input type="password"
                       id="new_password_confirmation"
                       wire:model="new_password_confirmation"
                       maxlength="30"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="Retapez votre nouveau mot de passe">
                @error('new_password_confirmation')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Bouton -->
            <div class="flex justify-end">
                <button type="submit"
                        wire:loading.attr="disabled"
                        class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50">
                    <span wire:loading.remove wire:target="changePassword">Changer le mot de passe</span>
                    <span wire:loading wire:target="changePassword">Changement en cours...</span>
                </button>
            </div>
        </form>
    </div>
</div>
