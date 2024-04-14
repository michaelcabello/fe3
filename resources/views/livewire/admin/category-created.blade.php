<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Nuava Categoria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">

                <div class="flex flex-wrap mx-4 mt-4">
                    <div class="w-full px-4 mb-4 md:w-4/4">
                        {{-- Renderizar los selectores de categorías --}}

                        <div>
                            <div class="mb-4">
                                <x-jet-label value="categoria" />
                                <x-jet-input type="text" class="w-full" wire:model="name" />
                                <x-jet-input-error for="name"/>
                            </div>

                            <h2>Seleccionar Categorías</h2>
                            {{-- @livewire('admin.category-selector') --}}
                            @livewire('admin.category-selector', ['categoryId' => $selectedCategory], key($selectedCategory))
                        </div>



                    </div>

                    {{-- Otros campos del formulario para crear una nueva categoría --}}
                    {{-- ... --}}

                    <div class="w-full px-4 mt-6 mb-4">
                        {{-- Botón para crear una nueva categoría --}}
                        <x-jet-danger-button wire:click="save">
                            <i class="mx-2 fa-regular fa-floppy-disk"></i> {{ __('Crear Categoria') }}
                            </x-jet-button>

                            {{-- Botón para cancelar la creación de una nueva categoría --}}
                            <x-jet-button wire:click="cancel">
                                <i class="mx-2 fa-regular fa-floppy-disk"></i> {{ __('Cancelar') }}
                            </x-jet-button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
