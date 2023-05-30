<div>
    {{-- <div wire:init="loadBrands"> --}}


    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-600">
                Inventario Inicial
            </h2>

            <div class="mb-4 mr-4">
                <x-jet-label value="Fecha de Emisión" />
                <x-jet-input id="datepicker" name="aa" type="text" class="w-full"
                     placeholder="inicio" />
                {{-- <x-jet-input-error for="fechaemision" /> --}}
            </div>

            <div class="mb-4 mr-4">
                <x-jet-label value="Fecha de Vencimiento:" />
                <x-jet-input id="datepicker2" type="text" name="bb" placeholder="fin"
                    class="w-full" />
                <x-jet-input-error for="fechavencimiento" />
            </div>

            <div class="flex items-center justify-center" >
                <a href="" class="items-center justify-center sm:flex btn btn-orange">
                   <i class="mx-2 fa-regular fa-file"></i> Guardar
                </a>

            </div>
        </div </x-slot>

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
                        {{-- <x-jet-input type="text" wire:model="search"
                            class="flex items-center justify-center w-80 sm:w-full rounded-lg py-2.5"
                            placeholder="buscar" /> --}}

                            <input type="text" id="code" class="block w-full items-center justify-center sm:w-full rounded-lg py-2.5" wire:keydown.enter.prevent="ScanCode($('#code').val())"/>
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


                    {{-- @livewire('admin.productfamilie-created') --}}
                    {{-- funciona pero sin select2 --}}

                    {{--  /*esto no usaremos*/ --}}
                    {{-- <div class="flex items-center justify-center" >
                            <a href="{{ route('admin.create')}}" class="items-center justify-center sm:flex btn btn-orange" >
                               <i class="mx-2 fa-regular fa-file"></i> Nuevo
                            </a >

                        </div> --}}
                    {{-- /*esto no usaremos*/ --}}



                    {{-- <div>
                             <input type="checkbox" class="flex items-center mr-2 leading-tight" wire-model="state"> Activos
                        </div> --}}

                   {{--  <div class="flex items-center justify-center px-2 mt-2 mr-4 md:mt-0">

                        <x-jet-input type="checkbox" wire:model="state" class="mx-1" />
                        Activos
                    </div> --}}

                </div>

                {{-- @if ($brands->count()) --}}



                @if (count($localproductatributes))


                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>

                                <th scope="col"
                                    class="w-24 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer"
                                    wire:click="order('id')">

                                    ID

                                    @if ($sort == 'id')
                                        @if ($direction == 'asc')
                                            <i class="float-right mt-1 fas fa-sort-alpha-up-alt"></i>
                                        @else
                                            <i class="float-right mt-1 fas fa-sort-alpha-down-alt"></i>
                                        @endif
                                    @else
                                        <i class="float-right mt-1 fas fa-sort"></i>
                                    @endif
                                </th>


                                <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer"
                                wire:click="order('codigo')">

                                Código
                                @if ($sort == 'codigo')
                                    @if ($direction == 'asc')
                                        <i class="float-right mt-1 fas fa-sort-alpha-up-alt"></i>
                                    @else
                                        <i class="float-right mt-1 fas fa-sort-alpha-down-alt"></i>
                                    @endif
                                @else
                                    <i class="float-right mt-1 fas fa-sort"></i>
                                @endif

                            </th>



                                <th scope="col"
                                    class="w-24 px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                                    Producto
                                </th>

                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                                    Atributos
                                </th>

                                <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                                Stock Sistema
                                </th>

                                <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                                Stock Contado
                                </th>

                                <th scope="col"
                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase cursor-pointer">
                                Diferencia
                                </th>


                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">
                                    ACCIONES
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">

                            {{-- products es todo lo que esta en inventario ya contabilizado osea es localproductatributes --}}
                            @foreach ($localproductatributes as $productt)
                                <tr>

                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $productt->id }}
                                    </td>


                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">

                                        {{-- {{ $productt->productatribute->codigo }} --}}
                                        {{ $productt->pricesale }}

                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{-- {{ $productt->productatribute->productfamilie->name }} --}}
                                        {{ $productt->pricesale }}
                                    </td>




                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- @foreach ($productt->productatribute->atributes as $atribute)
                                        {{ $atribute->name }}
                                        @if (!$loop->last)
                                            -
                                        @endif
                                        @endforeach --}}

                                    </td>



                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">


                                        <input type="number" id="r{{$productt->id}}"
                                                    wire:change="updateQty({{$productt->id}}, $('#r' + {{$productt->id}}).val() )"
                                                    style="font-size: 1rem!important"
                                                    class="w-32 text-center form-control"
                                                    value="{{$productt->stock}}"
                                                    >


                                    </td>



                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">


                                        <input type="number" id="r{{$productt->id}}"
                                                    wire:change="updateQty({{$productt->id}}, $('#r' + {{$productt->id}}).val() )"
                                                    style="font-size: 1rem!important"
                                                    class="w-32 text-center form-control"
                                                    value="{{$productt->stock}}"
                                                    >


                                    </td>

                                    <td>dif</td>




                                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        {{-- <a class="btn btn-blue"
                                            href="{{ route('admin.productatribute.pricesale', $productt->productatribute->productfamilie->id) }}"><i
                                                class="fa-sharp fa-solid fa-eye"></i></a> --}}
                                        {{-- <a wire:click="edit({{ $productt }})" class="btn btn-green"><i class="fa-solid fa-pen-to-square"></i></a> --}}
                                        {{-- <a class="btn btn-red" wire:click="$emit('deleteProduct', {{ $productt->id }})">
                                            <i class="fa-solid fa-trash-can"></i>

                                        </a> --}}



                                    </td>
                                </tr>
                            @endforeach
                            <!-- More people... -->
                        </tbody>
                    </table>




                   {{--  @if ($products->hasPages())
                        <div class="px-6 py-4">
                            {{ $products->links() }}
                        </div>
                    @endif --}}
                @else
                    <div wire:init="loadProducts">

                    </div>


                    @if ($readyToLoad)
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-center">
                                No hay ningún registro coincidente
                            </div>
                        </div>
                    @else
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-center">
                                <svg class="w-10 h-10 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512" fill="blue">
                                    <!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                    <path
                                        d="M304 48c0-26.5-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48zm0 416c0-26.5-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48zM48 304c26.5 0 48-21.5 48-48s-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48zm464-48c0-26.5-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48zM142.9 437c18.7-18.7 18.7-49.1 0-67.9s-49.1-18.7-67.9 0s-18.7 49.1 0 67.9s49.1 18.7 67.9 0zm0-294.2c18.7-18.7 18.7-49.1 0-67.9S93.7 56.2 75 75s-18.7 49.1 0 67.9s49.1 18.7 67.9 0zM369.1 437c18.7 18.7 49.1 18.7 67.9 0s18.7-49.1 0-67.9s-49.1-18.7-67.9 0s-18.7 49.1 0 67.9z" />
                                </svg>
                            </div>
                        </div>

                        <div class="px-6 py-4">
                            <div class="flex items-center justify-center">
                                Cargando, espere un momento
                            </div>
                        </div>
                    @endif



                @endif




                @if ($localproductatributes->hasPages()) {{-- existe paginación --}}
                <div class="px-6 py-8">
                    {{ $localproductatributes->links() }}
                </div>
            @endif


            </x-table>

        </div>



        <x-slot name="footer">

            <h2 class="text-xl font-semibold leading-tight text-gray-600">
                Pie
            </h2>


        </x-slot>









    @push('styles')

        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    @endpush

    @push('scripts')


        <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>


        <script>
            new Pikaday({
                field: document.getElementById('datepicker'),
                format: 'D MMM YYYY',

            });

            new Pikaday({
                field: document.getElementById('datepicker2'),
                format: 'D MMM YYYY',

            });
        </script>





    @endpush




</div>

