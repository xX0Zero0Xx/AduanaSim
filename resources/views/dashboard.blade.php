<x-app-layout>

    <!-- Estado reactivo de Alpine.js para controlar la pestaña visible -->
    <div x-data="{ tab: 'perfil' }" class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Menú de Pestañas / Tarjetas -->
            <div class="border-b border-gray-200 mb-6">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button 
                        @click="tab = 'perfil'" 
                        :class="tab === 'perfil' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Perfil
                    </button>

                    <button 
                        @click="tab = 'pedimentos'" 
                        :class="tab === 'pedimentos' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Pedimentos
                    </button>

                    <button 
                        @click="tab = 'cove'" 
                        :class="tab === 'cove' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Cove
                    </button>

                    <button 
                        @click="tab = 'doda'" 
                        :class="tab === 'doda' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                        class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        Doda
                    </button>
                </nav>
            </div>

            <!-- Contenedor principal de Tarjetas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Tarjeta 1: Perfil -->
                <div x-show="tab === 'perfil'" x-transition.opacity>
                    @include('profile.partials.show-information-from')
                </div>

                <!-- Tarjeta 2: Pedimentos -->
                <div x-show="tab === 'pedimentos'" x-transition.opacity>
                    @include('capturas.pedimento-captura')
                </div>

                <!-- Tarjeta 3: Cove -->
                <div x-show="tab === 'cove'" x-transition.opacity>
                    @include('capturas.cove-captura')
                </div>

                <!-- Tarjeta 4: Doda -->
                <div x-show="tab === 'doda'" x-transition.opacity>
                    @include('capturas.doda-captura')
                </div>

            </div>
        </div>
    </div>
</x-app-layout>