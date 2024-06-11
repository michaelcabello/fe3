<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Punto de Venta') }}
        </h2>
    </x-slot>


    <div class="grid px-4 mx-auto mt-4 max-w-7xl sm:px-6 lg:px-8">

        <div class="px-3 bg-white">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div>


                        {{-- <div class="py-2 mb-1" wire:ignore> --}}


                        <div
                            class="grid grid-cols-1 p-4 mt-4 ml-4 bg-blue-100 border border-gray-400 sm:grid-cols-2 md:grid-cols-6 lg:grid-cols-6">

                            <div class="mr-4 ">
                                <x-jet-label value="Tipo Documento" />
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
                                        class="w-full h-10 max-w-md uppercase" wire:keydown.enter="searchRuc" />
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


                        </div>

                        {{-- <div class="grid grid-cols-1 p-4 mt-4 ml-4 bg-blue-100 border border-gray-400 sm:grid-cols-2 md:grid-cols-6 lg:grid-cols-6"> --}}
                        <div class="grid grid-cols-1 p-4 mt-4 ml-4 bg-red-100 border border-gray-400 sm:grid-cols-2 md:grid-cols-6 lg:grid-cols-6">

                            {{-- <div class="flex-1 col-span-6 mb-4 mr-4">
                                <hr>
                            </div> --}}







                            {{-- <div class="mb-4 mr-4 ">

                                <x-jet-label value="Cliente" />

                                <select wire:model="customer_id"
                                    class="h-10 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 "
                                    data-placeholder="Selecccione un Proveedor" style="width:100%">
                                    <option value="" selected disabled>Seleccione</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->nomrazonsocial }}
                                        </option>
                                    @endforeach

                                </select>
                                <x-jet-input-error for="customer_id" />
                            </div> --}}


                            <div class="mb-4 mr-4 ">
                                {{-- <label>Proveedores </label> --}}
                                <x-jet-label value="comprobante" />
                                {{-- select2 --}}
                                <select wire:model="tipocomprobante_id"
                                    class="h-10 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 "
                                    data-placeholder="Selecccione tipo Comprobante" style="width:100%" disabled>
                                    <option value="" selected disabled>Seleccione</option>
                                    @foreach ($tipocomprobantes as $tipocomprobante)
                                        <option value="{{ $tipocomprobante->id }}">{{ $tipocomprobante->namecorto }}
                                        </option>
                                    @endforeach

                                </select>
                                <x-jet-input-error for="tipocomprobante_id" />


                            </div>



                            <div class="mb-1 mr-4">
                                <x-jet-label value="Serie" />
                                <x-jet-input type="text" placeholder="Serie" class="w-full h-10 uppercase"
                                    wire:model="serie" disabled />
                                <x-jet-input-error for="serie" />
                            </div>

                            <div class="mb-1 mr-4">
                                <x-jet-label value="Número" />
                                <x-jet-input type="text" placeholder="Número" class="w-full h-10 uppercase"
                                    wire:model="numero" disabled />
                                <x-jet-input-error for="numero" />
                            </div>


                            <div class="mb-1 mr-4">
                                <x-jet-label value="Forma de pago:" />

                                <select wire:model="paymenttype_id"
                                    class="h-10 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    data-placeholder="Selecccione forma de pago" style="width:100%">
                                    <option value="" selected disabled>Seleccione</option>

                                    <option value="1">Contado</option>

                                    <option value="2">Credito</option>
                                </select>
                                <x-jet-input-error for="paymenttype_id" />
                            </div>



                            {{--  <div class="mb-4 mr-4">
                                <x-jet-label value="Fecha de Emisión" />
                                <x-jet-input id="datepicker" type="text" wire:model="fechaemision" value="{{ old('fechaemision') }}"
                                     class="w-full h-10" placeholder="fecha de emisión" />
                                <x-jet-input-error for="fechaemision" />
                            </div> --}}

                            <div class="mb-4 mr-4">
                                <x-jet-label value="Fecha de Emisión" />
                                <x-jet-input type="date" max="{{ date('Y-m-d') }}"
                                    min="{{ date('Y-m-d', strtotime('-3 days')) }}" wire:model="fechaemision"
                                    value="{{ old('fechaemision') }}" class="w-full h-10"
                                    placeholder="fecha de emisión" />
                                <x-jet-input-error for="fechaemision" />
                            </div>


                            {{--  <div class="mb-4 mr-4" >
                                <x-jet-label value="Fecha de Vencimiento:" />
                                <x-jet-input id="datepicker2" type="text" wire:model="fechavencimiento" value="{{ old('fechavencimiento') }}"
                                class="w-full h-10" placeholder="fecha de pago"/>
                                <x-jet-input-error for="fechavencimiento" />

                            </div> --}}

                            <div class="mb-4 mr-4">
                                <x-jet-label value="Fecha de Vencimiento:" />
                                <x-jet-input type="date" min="{{ date('Y-m-d', strtotime('-3 days')) }}"
                                    wire:model="fechavencimiento" value="{{ old('fechavencimiento') }}"
                                    class="w-full h-10" placeholder="fecha de pago" />
                                <x-jet-input-error for="fechavencimiento" />

                            </div>




                            <div class="mb-1 mr-4">
                                <x-jet-label value="Moneda" />
                                <select wire:model="currency_id"
                                    class="h-10 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    data-placeholder="Selecccione la moneda" style="width:100%">
                                    <option value="" selected disabled>Seleccione</option>
                                    @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->abbreviation }}</option>
                                    @endforeach

                                </select>
                                <x-jet-input-error for="currency_id" />
                            </div>


                            <div class="mb-4 mr-4 ">
                                {{-- <label>Proveedores </label> --}}
                                <x-jet-label value="Tipo de Operación" />
                                {{-- select2 --}}
                                <select wire:model="tipodeoperacion_id"
                                    class="h-10 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 "
                                    data-placeholder="Selecccione" style="width:100%">
                                    <option value="" selected disabled>Seleccione</option>
                                    @foreach ($tipodeoperacions as $tipodeoperacion)
                                        <option value="{{ $tipodeoperacion->id }}">{{ $tipodeoperacion->descripcion }}
                                        </option>
                                    @endforeach

                                </select>
                                <x-jet-input-error for="tipodeoperacion_id" />
                            </div>



                            <div class="col-span-2 form-group {{ $errors->has('nota') ? 'text-danger' : '' }} ">
                                {{-- <label>Nota de la compra</label> --}}
                                <textarea rows="2" wire:model="nota" class="w-full form-control" placeholder="Ingrese Nota del Comprobante ">{{ old('nota') }}</textarea>
                                {!! $errors->first('nota', '<span class="help-block">:message</span>') !!}


                            </div>

                            {{-- <div class="mb-4 ml-3 mr-4">
                                <x-jet-label value="Sujeto a Detracción:" />

                                <x-jet-input type="checkbox" wire:model="detraccion" class="mx-2" />


                            </div> --}}


                        </div>


                        <hr class="mt-5 mb-5">

                        {{-- aqui ira los productos a vender --}}











                        <div class="flex mt-4">

                            <input type="text" id="code" class="block w-1/2 h-10 py-2 m-1 mr-2 bg-gray-100"
                                wire:keydown.enter.prevent="ScanCode($('#code').val())"
                                placeholder="Código de barras" />

                            <form class="relative w-1/2 mx-auto mr-2 text-gray-600" autocomplete="off">

                                <input wire:model="searchh" class="block w-full h-10 py-2 m-1 bg-gray-100"
                                    type="text" name="searchh" placeholder="Buscar">

                                @if ($searchh)
                                    <ul class="absolute left-0 w-full mt-1 overflow-hidden bg-white rounded-lg z-500 ">
                                        @forelse ($this->results as $result)
                                            <li class="px-5 text-sm leading-10 cursor-pointer hover:bg-gray-300">
                                                <a href="#"
                                                    wire:click.prevent="ScanCoded('{{ $result->id }}')">{{ $result->name }}
                                                </a>
                                            </li>
                                        @empty
                                            <li class="px-5 text-sm leading-10 cursor-pointer hover:bg-gray-300">
                                                No hay coincidencias
                                            </li>
                                        @endforelse

                                    </ul>

                                @endif

                            </form>

                            <a class="mb-4 btn btn-red" wire:click="$emit('limpiarTemporal')">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>

                        </div>


                        {{-- @if (session()->has('alert'))
                                    <p class="mt-2 text-red-500">{{ session('alert') }}</p>
                                    {{ session()->forget('alert') }}
                                @endif --}}


                        {{-- {{ $cart }} --}}

                        <section class="w-full px-4 mt-4 antialiased text-gray-600">
                            <div class="flex flex-col justify-center w-full h-full">
                                <!-- Table -->
                                @if ($total > 0)
                                    <div class="w-full mx-auto bg-white border border-gray-200 rounded-sm shadow-lg">
                                        <div class="p-3">
                                            <div class="overflow-x-auto">
                                                <table class="w-full table-auto">
                                                    <thead
                                                        class="text-xs font-semibold text-gray-400 uppercase bg-gray-50">
                                                        <tr>
                                                            <th class="p-2 whitespace-nowrap">
                                                                <div class="font-semibold text-left">Imagén
                                                                </div>
                                                            </th>
                                                            <th class="p-2 whitespace-nowrap">
                                                                <div class="font-semibold text-left">Código
                                                                </div>
                                                            </th>
                                                            <th class="p-2 whitespace-nowrap">
                                                                <div class="font-semibold text-left">Nombre
                                                                </div>
                                                            </th>
                                                            <th class="p-2 whitespace-nowrap">
                                                                <div class="font-semibold text-center">precio
                                                                </div>
                                                            </th>


                                                            <th class="p-2 whitespace-nowrap">
                                                                <div class="font-semibold text-center">cantidad
                                                                </div>
                                                            </th>
                                                            <th class="p-2 whitespace-nowrap">
                                                                <div class="font-semibold text-center">Subtotal
                                                                </div>
                                                            </th>
                                                            <th class="p-2 whitespace-nowrap">
                                                                <div class="font-semibold text-center">Acciones
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-sm divide-y divide-gray-100">


                                                        @foreach ($cart as $item)
                                                            <tr>
                                                                <td class="p-2 whitespace-nowrap">
                                                                    <div class="flex items-center">
                                                                        <div class="flex-shrink-0 w-10 h-10 mr-2 sm:mr-3">

                                                                            {{-- <img class="rounded"  src="{{ Storage::disk('s3')->url($item->image) }}"
                                                                                width="40" height="40"> --}}


                                                                            @if ($item->image)
                                                                                <img class="object-cover w-10 h-10 rounded-sm"
                                                                                    src="{{ Storage::disk('s3')->url($item->image) }}"
                                                                                    alt="Ticom Software">
                                                                            @else
                                                                                <img class="object-cover w-10 h-10 rounded-sm"
                                                                                    src="{{ asset('storage/products/productdefault.jpg') }}"
                                                                                    alt="Ticom Software" class="m-2">
                                                                            @endif




                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td class="p-2 whitespace-nowrap">
                                                                    <div class="text-left">
                                                                        {{ $item->codigobarras }}
                                                                    </div>
                                                                </td>
                                                                <td class="p-2 whitespace-nowrap">
                                                                    <div class="font-medium text-left text-green-500 whitespace-normal">
                                                                        {{ $item->name }} </div>
                                                                </td>



                                                                <td class="p-2 whitespace-nowrap">
                                                                    {{-- <div class="text-center">${{number_format($item->saleprice,2)}}</div> --}}
                                                                    <div class="w-20 text-lg text-center">
                                                                        <input type="text"
                                                                            id="p{{ $item->id }}"
                                                                            wire:change="updatePrice('{{ $item->id }}', $('#p' + '{{ $item->id }}').val(), $('#r' + '{{ $item->id }}').val())"
                                                                            style="font-size: 1rem!important"
                                                                            class="w-20 text-center form-control"
                                                                            value="{{ number_format($item->saleprice, 4) }}">
                                                                    </div>
                                                                </td>

                                                                <td class="p-2 whitespace-nowrap">
                                                                    <div class="w-20 text-lg text-center">
                                                                        <input type="number"
                                                                            id="r{{ $item->id }}"
                                                                            wire:change="updateQty('{{ $item->id }}', $('#p' + '{{ $item->id }}').val(), $('#r' + '{{ $item->id }}').val(), '{{ $item->mtovalorunitario }}')"
                                                                            style="font-size: 1rem!important"
                                                                            class="w-20 text-center form-control"
                                                                            value="{{ $item->quantity }}">
                                                                    </div>
                                                                </td>



                                                                <td class="p-2 whitespace-nowrap">
                                                                    <div class="text-lg text-right">
                                                                        {{ number_format($item->saleprice * $item->quantity, 4) }}
                                                                    </div>
                                                                </td>

                                                                <td class="p-2 whitespace-nowrap">


                                                                    <a class="btn btn-red"
                                                                        wire:click="$emit('deleteTemporal', {{ $item->id }})">
                                                                        <i class="fa-solid fa-trash-can"></i>
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="p-2 whitespace-nowrap">
                                                                <div class="text-lg text-right">
                                                                    SUB-TOTAL
                                                                </div>
                                                            </td>
                                                            <td class="p-2 whitespace-nowrap">
                                                                <div class="text-lg text-right">
                                                                    {{ $valorventa }}
                                                                </div>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="p-2 whitespace-nowrap">
                                                                <div class="text-lg text-right">
                                                                    ICBPER
                                                                </div>
                                                            </td>
                                                            <td class="p-2 whitespace-nowrap">
                                                                <div class="text-lg text-right">
                                                                    {{ $icbper }}
                                                                </div>
                                                            </td>
                                                            <td></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="p-2 whitespace-nowrap">
                                                                <div class="text-lg text-right">
                                                                    IGV
                                                                </div>
                                                            </td>
                                                            <td class="p-2 whitespace-nowrap">
                                                                <div class="text-lg text-right">
                                                                    {{ $mtoigv }}
                                                                </div>
                                                            </td>
                                                            <td></td>
                                                        </tr>

                                                    </tbody>

                                                    <tfoot>

                                                        <tr>

                                                            {{-- <td>{{ $valorventa }}</td>
                                                            <td>{{ $totalimpuestos }}</td>
                                                            <td>{{ $subtotall }}</td> --}}
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>{{ $totalenletras }}</td>
                                                            <td class="text-right">Total: {{ $moneda }}</td>
                                                            <td class="p-2 whitespace-nowrap">
                                                                <div class="text-lg text-right">
                                                                    {{ $subtotall }}
                                                                </div>
                                                            </td>

                                                            <td></td>
                                                        </tr>
                                                    </tfoot>

                                                </table>
                                                {{--  <div>
                                                    mtoigv = {{ $mtoigv }} /
                                                    mtoigvgratuitas = {{ $mtoigvgratuitas }}  /
                                                    icbper= {{ $icbper }}
                                                    totalimpuestos={{ $totalimpuestos }}
                                                    valorventa={{ $valorventa }}
                                                </div> --}}

                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <h5 class="text-center text-muted">Agrega productos para la venta</h5>
                                @endif


                            </div>
                        </section>


                        <div class="flex space-x-6">
                            <div class="m-2">
                                <input wire:model="sending_method" type="radio" id="a" name="drone"
                                    value="1" />
                                <label for="a">ENVIAR A SUNAT</label>
                            </div>

                            <div class="m-2">
                                <input wire:model="sending_method" type="radio" id="b" name="drone"
                                    value="2" />
                                <label for="b">GENERAR XML</label>
                            </div>

                            <div class="m-2">
                                <input wire:model="sending_method" type="radio" id="c" name="drone"
                                    value="3" />
                                <label for="c">CREAR</label>
                            </div>
                        </div>

                        {{ $sending_method }}

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

        {{-- <script>
            var datepicker = new Pikaday({
                field: document.getElementById('datepicker'),
                format: 'D MMM YYYY',
                onSelect: function(selectedDate) {
                    Livewire.emit('fechaemision', selectedDate);
                }
            });
        </script> --}}

        {{-- <script>
            var datepicker = new Pikaday({
                field: document.getElementById('datepicker'),
                format: 'D MMM YYYY',
                onSelect: function(selectedDate) {
                    @this.set('fechaemision', selectedDate);
                }
            });
        </script> --}}


        {{-- <script>
            var datepicker = new Pikaday({
                field: document.getElementById('datepicker'),
                format: 'D MMM YYYY',
                onSelect: function(selectedDate) {
                    var formattedDate = moment(selectedDate).format('DDMMYYYY');
                    Livewire.emit('fechaemision', formattedDate);
                }
            });
        </script> --}}


        <script>
            var datepicker = new Pikaday({
                field: document.getElementById('datepicker'),
                format: 'DD MM YYYY', // Cambiado a 'DD/MM/YYYY'//format: 'D MMM YYYY',
                onSelect: function(selectedDate) {
                    var formattedDate = moment(selectedDate).format('DD MM YYYY');
                    @this.set('fechaemision', formattedDate);
                }
            });

            var datepicker2 = new Pikaday({
                field: document.getElementById('datepicker2'),
                format: 'DD MM YYYY',
                onSelect: function(selectedDate) {
                    var formattedDate = moment(selectedDate).format('DD MM YYYY');
                    @this.set('fechavencimiento', formattedDate);
                }
            });


            /* var datepicker2 = new Pikaday({
                field: document.getElementById('datepicker2'),
                format: 'D MMM YYYY',
                onSelect: function(selectedDate) {
                    var formattedDate = moment(selectedDate).format('DD/MM/YYYY');
                    @this.set('fechavencimiento', formattedDate);
                }
            }); */
        </script>


        <script>
            CKEDITOR.replace('editor');
            CKEDITOR.config.height = 115;
        </script>


        {{-- para eliminar un item de la venta --}}
        <script>
            Livewire.on('deleteTemporal', temporalId => {
                Swal.fire({
                    title: 'Estas seguro?',
                    text: "No se podrá revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminar!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('admin.comprobante-create', 'delete', temporalId);

                        Swal.fire(
                            'Eliminado!',
                            'El Registro fue eliminado.',
                            'success'
                        )
                    }
                })
            })
        </script>

        {{-- para eliminar todo de la venta --}}
        <script>
            Livewire.on('limpiarTemporal', () => {
                Swal.fire({
                    title: 'Estas seguro?',
                    text: "No se podrá revertir!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Eliminar!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        Livewire.emitTo('admin.comprobante-create', 'limpiar');

                        Swal.fire(
                            'Eliminado!',
                            'El Registro fue eliminado.',
                            'success'
                        )
                    }
                })
            })
        </script>
    @endpush
</div>
