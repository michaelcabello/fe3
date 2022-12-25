<div>
    {{-- <div wire:init="loadBrands"> --}}


        <x-slot name="header">
            <div class="flex items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-600">
                    Lista de Productos
                </h2>
            </div

        </x-slot>

        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="container py-12 mx-auto border-gray-400 max-w-7xl sm:px-6 lg:px-8">



                    <x-table>

                            <div class="items-center px-6 py-4 bg-gray-200 sm:flex">

                                <div class="flex items-center justify-center mb-2 md:mb-0">
                                    <span>Mostrar </span>
                                    <select wire:model="cant" class="block p-7 py-2.5 ml-3 mr-3 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                        <option value="10"> 10 </option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span class="mr-3">registros</span>
                                </div>


                                <div class="flex items-center justify-center mb-2 mr-4 md:mb-0 sm:w-full">
                                <x-jet-input type="text"
                                    wire:model="search"
                                    class="flex items-center justify-center w-80 sm:w-full rounded-lg py-2.5"
                                    placeholder="buscar" />
                                </div>



                                 {{-- @livewire('admin.productfamilie-create') --}} {{-- queda para mas adelante poder solicionar, el segundo select que no carga --}}

                               {{-- genera productos en 2 pasos y con selec2 --}}

                               {{--  @if ($withcategory[0])
                                     @livewire('admin.productfamilie-createa')
                                @else
                                    <div class="flex items-center justify-center" >
                                        <a href="{{ route('productfamilie.createaa', $category)}}" class="items-center justify-center sm:flex btn btn-orange" >
                                        <i class="mx-2 fa-regular fa-file"></i> Nuevo
                                        </a >
                                    </div>
                                @endif --}}
                               {{-- genera productos en 2 pasos y con selec2 --}}


                                 @livewire('admin.productfamilie-created')
                                {{-- funciona pero sin select2 --}}

                               {{--  /*esto no usaremos*/ --}}
         {{--                        <div class="flex items-center justify-center" >
                                    <a href="{{ route('admin.create')}}" class="items-center justify-center sm:flex btn btn-orange" >
                                       <i class="mx-2 fa-regular fa-file"></i> Nuevo
                                    </a >

                                </div> --}}
                                {{-- /*esto no usaremos*/ --}}



                           {{-- <div>
                                     <input type="checkbox" class="flex items-center mr-2 leading-tight" wire-model="state"> Activos
                                </div> --}}

                                <div class="flex items-center justify-center px-2 mt-2 mr-4 md:mt-0">

                                    <x-jet-input type="checkbox" wire:model="state" class="mx-1" />
                                    Activos
                                </div>

                            </div>

                            {{-- @if ($brands->count()) --}}

                        </x-table>

        </div>


        <x-slot name="footer">

                <h2 class="text-xl font-semibold leading-tight text-gray-600">
                    Pie
                </h2>


        </x-slot>

















    </div>


