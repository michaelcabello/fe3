<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Menu General') }}
        </h2>
    </x-slot>




    <section class="">

        <div class="py-12">
           {{--  <div class="mx-auto max-w-7xl sm:px-6 lg:px-8"> --}}
                {{-- <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg"> --}}

                        <div class="grid grid-cols-1 px-4 mx-auto mt-4 max-w-7xl sm:px-6 lg:px-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-x-6 gap-y-8">

                                @can('Configuration View')
                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/configuraciones.jpg')}}" alt="Configuraciones">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700">Configuraciones</h1>
                                    </header>

                                </article>
                                @endcan

                                @can('User View')
                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/usuarios.jpg')}}" alt="">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700"><a href="{{route('admin.user.index')}}">Usuarios</a></h1>
                                    </header>

                                </article>
                                @endcan

                                @can('Permission View')
                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/permisos.jpg')}}" alt="">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700"><a href="{{route('permission.list')}}">Permisos</a></h1>
                                    </header>

                                </article>
                                @endcan

                                @can('Role View')
                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/roles.jpg')}}" alt="">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700"><a href="{{route('admin.role.index')}}">Roles</a></h1>
                                    </header>

                                </article>
                                @endcan


                                @can('Brand View')
                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/brands.jpg')}}" alt="">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700"><a href="{{route('brand.list')}}">Marcas</a></h1>
                                    </header>

                                </article>
                                @endcan

                                @can('Category View')
                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/categories.jpg')}}" alt="">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700"><a href="{{route('category.list')}}">Categorias</a></h1>

                                    </header>

                                </article>
                                @endcan

                                @can('Modelo View')
                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/modelos.jpg')}}" alt="">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700"><a href="{{route('modelo.list')}}">Modelos</a></h1>
                                    </header>

                                </article>
                                @endcan


                                @can('Product View')
                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/products.jpg')}}" alt="">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700"><a href="{{route('product.list')}}">Productos</a></h1>
                                    </header>

                                </article>
                                @endcan

                                @can('Initialinventory View')
                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/inventarioinicial.jpg')}}" alt="">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700"><a href="{{route('inventory.list')}}">Inventario Inicial</a></h1>
                                    </header>

                                </article>
                                @endcan

                                @can('Inventory View')
                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/inventario2.jpg')}}" alt="">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700"><a href="{{route('inventory.list2')}}">Inventarios</a></h1>
                                    </header>

                                </article>
                                @endcan

                                @can('Shopping View')
                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/compras.jpg')}}" alt="">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700"><a href="{{route('admin.shopping.index')}}">Compras</a></h1>
                                    </header>

                                </article>
                                @endcan

                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/ingresodemercaderias.jpg')}}" alt="">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700">Ingreso de Mercaderias</h1>
                                    </header>

                                </article>

                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/trasladodemercaderias.jpg')}}" alt="Envio de Mercaderias">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700"><a href="{{route('admin.shipment.index')}}">Envío de Mercaderias</a></h1>
                                    </header>

                                </article>


                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/recepciondemercaderias.jpg')}}" alt="Recepción de Mercaderias">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700"><a href="{{route('admin.reception.index')}}">Recepción de Mercaderias</a></h1>
                                    </header>

                                </article>

                                @can('Sale View')
                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/pos.jpg')}}" alt="">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700"><a href="{{route('admin.sale.index')}}">POS</a></h1>
                                    </header>

                                </article>
                                @endcan


                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/ecommerce.jpg')}}" alt="">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700">Web</h1>
                                    </header>

                                </article>

                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/stockdeproductos.jpg')}}" alt="">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700"><a href="{{route('localproductatributestock.list', auth()->user()->employee->local->id )}}">Stock</a></h1>
                                    </header>

                                </article>

                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/1.jpg')}}" alt="">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700">Marcas</h1>
                                    </header>

                                </article>

                                <article>
                                    <figure>
                                        <img class="object-cover w-full rounded-xl h-36" src="{{asset('img/1.jpg')}}" alt="">
                                    </figure>
                                    <header class="mt-2">
                                        <h1 class="text-xl text-center text-gray-700">Sub-Categorias</h1>
                                    </header>

                                </article>


                        </div>
                {{-- </div> --}}
            {{-- </div> --}}
        </div>




    </section>



    <section>
        <div class="mt-4 bg-white shadow">
            hola
        </div>
    </section>

</x-app-layout>
