<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Profil utilisateur') }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Informations du profil</h3>

                    <div class="space-y-6">
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Adresse email
                            </label>
                            <div class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-50 text-gray-900">
                                {{ auth()->user()->email }}
                            </div>
                        </div>

                        <!-- Rôle -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Rôle
                            </label>
                            <div class="mt-1">
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                    @if(auth()->user()->hasRole('manager')) bg-blue-100 text-blue-800
                                    @elseif(auth()->user()->hasRole('accounting')) bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    @if(auth()->user()->hasRole('manager'))
                                        Manager
                                    @elseif(auth()->user()->hasRole('accounting'))
                                        Comptabilité
                                    @else
                                        Employé
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="border-t pt-6">
                            <div class="flex space-x-3">
                                <a href="{{ route('my-expense-reports') }}"
                                   class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Retour aux notes de frais
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
