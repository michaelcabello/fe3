<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Local Nuevo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">

                <div class="flex flex-wrap mt-4 -mx-4">
                    <div class="w-full px-4 mb-4 md:w-3/4">
                        <x-jet-label value="Nombre del Local" />
                        <x-jet-input type="text" class="w-full uppercase" wire:model="name" />
                        <x-jet-input-error for="name" />
                    </div>
                    <div class="w-full px-4 mb-4 md:w-1/4">
                        <x-jet-label value="Código Postal" />
                        <x-jet-input type="text" class="w-full uppercase" wire:model="codigopostal" />
                        <x-jet-input-error for="codigopostal" />
                    </div>
                    <div class="w-full px-4 mb-4 md:w-1/2">
                        <x-jet-label value="Dirección" />
                        <x-jet-input type="text" class="w-full uppercase" wire:model="address" />
                        <x-jet-input-error for="address" />
                    </div>
                    <div class="w-full px-4 mb-4 md:w-1/2">
                        <x-jet-label value="Email" />
                        <x-jet-input type="email" class="w-full lowercase" wire:model="email" />
                        <x-jet-input-error for="email" />
                    </div>
                    <div class="w-full px-4 mb-4 md:w-1/4">
                        <x-jet-label value="Teléfono" />
                        <x-jet-input type="text" class="w-full uppercase" wire:model="phone" />
                        <x-jet-input-error for="phone" />
                    </div>
                    <div class="w-full px-4 mb-4 md:w-1/4">
                        <x-jet-label value="Celular" />
                        <x-jet-input type="text" class="w-full uppercase" wire:model="movil" />
                        <x-jet-input-error for="movil" />
                    </div>
                    <div class="w-full px-4 mb-4 md:w-1/4">
                        <x-jet-label value="Anexo" />
                        <x-jet-input type="text" class="w-full uppercase" wire:model="anexo" />
                        <x-jet-input-error for="anexo" />
                    </div>
                    <div class="w-full px-4 mb-4 md:w-1/4">
                        <x-jet-label value="Estado" />
                        <x-jet-input type="checkbox" wire:model="state" />
                        <x-jet-input-error for="state" />
                    </div>


                    <div class="w-full px-4 mt-6 mb-4">
                        <x-jet-danger-button wire:click="save">
                            <i class="mx-2 fa-regular fa-floppy-disk"></i> {{ __('Crear Local') }}
                        </x-jet-button>

                        <x-jet-button wire:click="cancel">
                            <i class="mx-2 fa-regular fa-floppy-disk"></i> {{ __('Cancelar') }}
                        </x-jet-button>


                    </div>


                </div>

            </div>
        </div>
    </div>
</div>
