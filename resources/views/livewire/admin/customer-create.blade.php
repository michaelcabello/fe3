<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Creación de un Cliente') }}
        </h2>
    </x-slot>


    <div class="grid px-4 mx-auto mt-4 max-w-7xl sm:px-6 lg:px-8">

        <div class="px-3 bg-white">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div>


                        <div class="grid grid-cols-1 p-4 mt-4 ml-4 bg-blue-100 border border-gray-400 sm:grid-cols-2 md:grid-cols-6 lg:grid-cols-6">

                            <div class="mr-4 ">
                                <x-jet-label value="Tipo Documento"  />

                                {{-- select2 --}}
                                <select wire:model="tipodocumento_id"

                                    class="h-10 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 "
                                    data-placeholder="Selecccione un Proveedor" style="width:100%">
                                    <option value="" selected disabled>Seleccione</option>
                                    @foreach ($tipodocumentos as $tipodocumento)
                                        <option value="{{ $tipodocumento->id }}">{{ $tipodocumento->abbreviation }}
                                        </option>
                                    @endforeach

                                </select>
                                <x-jet-input-error for="tipodocumento_id" />

                            </div>


                            <div class="flex items-center col-span-2 mr-4">

                                <div class="flex-1 mr-1">
                                    <x-jet-label value="Número(RUC, DNI, ...)" />
                                    <x-jet-input wire:model="ruc" type="text" placeholder="RUC, dni, ..."
                                        class="w-full h-10 max-w-md uppercase" wire:keydown.enter="searchRuc" :disabled="!$isDocumentTypeSelected"  />
                                    <x-jet-input-error for="ruc" />
                                </div>

                                <div>
                                    <x-jet-label value="Buscar" />
                                    <x-jet-secondary-button class="h-10 ml-1 mr-1" wire:click="searchRuc">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </x-jet-secondary-button>
                                </div>

                            </div>

                            <div class="flex-1 col-span-3 mb-1 mr-4">
                                <x-jet-label value="Razón Social" />
                                <x-jet-input wire:model.defer="razon_social" type="text" placeholder="Razón Social"
                                    class="w-full h-10 uppercase" disabled/>
                                <x-jet-input-error for="razon_social" />
                            </div>

                            <div class="flex-1 mb-1 mr-4">
                                <x-jet-label value="Nombre Comercial" />
                                <x-jet-input wire:model.defer="nombre_comercial" type="text"
                                    placeholder="Nom Comercial" class="w-full h-10 max-w-md uppercase" disabled />
                                <x-jet-input-error for="nombre_comercial" />
                            </div>

                            <div class="flex-1 col-span-2 mb-4 mr-4">
                                <x-jet-label value="Dirección" />
                                <x-jet-input wire:model.defer="direccion" type="text" placeholder="Dirección"
                                    class="w-full h-10 max-w-md uppercase" disabled />
                                <x-jet-input-error for="direccion" />
                            </div>

                            <div class="flex-1 mb-4 mr-4">
                                <x-jet-label value="Departamento" />
                                <x-jet-input wire:model.defer="departamento" type="text" placeholder="Departamento"
                                    class="w-full h-10 max-w-md uppercase" disabled />
                                <x-jet-input-error for="Departamento" />
                            </div>

                            <div class="flex-1 mb-4 mr-4">
                                <x-jet-label value="Provincia" />
                                <x-jet-input wire:model.defer="provincia" type="text" placeholder="Provincia"
                                    class="w-full h-10 max-w-md uppercase" disabled />
                                <x-jet-input-error for="provincia" />
                            </div>

                            <div class="flex-1 mb-4 mr-4">
                                <x-jet-label value="Distrito" />
                                <x-jet-input wire:model.defer="distrito" type="text" placeholder="Distrito"
                                    class="w-full h-10 max-w-md uppercase" disabled />
                                <x-jet-input-error for="distrito" />
                            </div>





                            <div class="flex-1 mb-1 mr-4">
                                <x-jet-label value="Teléfono" />
                                <x-jet-input wire:model.defer="phone" type="text"
                                    placeholder="Nom Comercial" class="w-full h-10 max-w-md uppercase"  />
                                <x-jet-input-error for="phone" />
                            </div>

                            <div class="flex-1 mb-1 mr-4">
                                <x-jet-label value="Celular" />
                                <x-jet-input wire:model.defer="movil" type="text"
                                    placeholder="Nom Comercial" class="w-full h-10 max-w-md uppercase"  />
                                <x-jet-input-error for="movil" />
                            </div>

                            <div class="flex-1 col-span-2 mb-4 mr-4">
                                <x-jet-label value="Email" />
                                <x-jet-input wire:model.defer="email" type="text" placeholder="Email"
                                    class="w-full h-10 max-w-md uppercase" />
                                <x-jet-input-error for="email" />
                            </div>

                            <div class="flex-1 col-span-2 mb-4 mr-4">
                                <x-jet-label value="Contacto" />
                                <x-jet-input wire:model.defer="contact" type="text" placeholder="contact"
                                    class="w-full h-10 max-w-md uppercase" />
                                <x-jet-input-error for="contact" />
                            </div>



                        </div>





                        <x-jet-danger-button wire:click="save" wire:loading.attr="disabled" wire:target="save"
                            class="w-full mt-4 mb-3 disabled:opacity-25">
                            <i class="mx-2 fa-regular fa-floppy-disk"></i> Guardar
                        </x-jet-danger-button>



                    </div>
                </div>

            </div>



        </div>

    </div>

    {{-- </form> --}}






    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    @endpush

    @push('scripts')
        <script src="sweetalert2.all.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.slim.js"></script>
        <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
        {{--  <script src="/adminlte/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> --}}

        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
        <script src="pikaday.js"></script>

        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>






        <script>
            CKEDITOR.replace('editor');
            CKEDITOR.config.height = 115;
        </script>


    @endpush
</div>
