<div>

    <!-- Encabezado de la vista -->
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-600">
                Lista de Categorías
            </h2>
        </div>
    </x-slot>

    <!-- Contenedor principal -->
    <div class="container py-12 mx-auto border-gray-400 max-w-7xl sm:px-6 lg:px-8">

        <!-- Componente de tabla -->
        <x-table>

            <!-- Encabezado de la tabla -->
            <div class="items-center px-6 py-4 bg-gray-200 sm:flex">

                <a href="{{ route('category.createt') }}" class="items-center justify-center sm:flex btn btn-orange" >
                    <i class="mx-2 fa-regular fa-file"></i> Nuevo
                 </a >


            </div>

            <!-- Comprobación de existencia de categorías -->
            @if (count($categories))
                <div class="mt-4">
                    <ul>
                        <!-- Iteración sobre las categorías -->
                        @foreach ($categories as $category)
                            <!-- Div contenedor con estado -->
                            <div x-data="{ open: false }">
                                <!-- Elemento de categoría con iconos de expansión y contracción -->

                                <div @click="open = !open" class="flex items-center justify-between cursor-pointer">
                                    <div class="flex">
                                        <i class="fas fa-plus" x-show="!open"></i>
                                        <i class="fas fa-minus" x-show="open"></i>
                                        <div class="flex-shrink-0 h-10 ml-2 mr-2 w-15 ">
                                            @if ($category->image)
                                                <img class="object-cover w-20 h-10 rounded-sm"
                                                    src="{{ url($category->image) }}" alt="{{ $category->name }}">
                                                {{-- src="{{ Storage::url($brand->image) }}" storage//storage/brand/default.jpg  en la bd esta puesto esto 	/storage/brands/default.jpg > --}}
                                                {{-- url($brand->image) muestra tal como es la ruta en la bd esta puesto esto 	/storage/brands/default.jpg --}}
                                                {{--  {{ Storage::disk("s3")->url($brand->image) }} --}}
                                            @else
                                                <img class="object-cover h-6 rounded-full w-15"
                                                    src="{{ asset('storage/brands/category-default.jpg') }}"
                                                    alt="{{ $category->name }}" class="m-2">
                                            @endif
                                        </div>
                                        {{ $category->name }} ({{ $category->children->count() }})<!-- Nombre de la categoría -->
                                    </div>
                                    <div class="px-6 text-sm font-medium text-right whitespace-nowrap">
                                        <!-- Botones de edición y eliminación -->


                                        <a href="{{ route('category.editd', ['categoryId' => $category->id]) }}" class="btn btn-green">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <a class="btn btn-red" wire:click="$emit('deleteCategory', {{ $category->id }})">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </div>




                                {{-- <hr class="my-4 border-t border-gray-300"> --}}
                                {{-- <hr class="w-full my-4 border-t border-gray-300"> --}}
                                <hr class="w-full my-2 border-t border-gray-300 dotted">
                                <!-- Lista de hijos de la categoría, mostrada si está abierta -->
                                <ul x-show="open">
                                    <!-- Iteración sobre los hijos de la categoría -->

                                    @foreach ($category->children as $child)
                                        <!-- Componente de categoría para cada hijo -->
                                        <livewire:admin.category-itemlist :category="$child" :key="$child->id" />
                                    @endforeach
                                </ul>

                            </div>
                        @endforeach
                    </ul>
                </div>
            @else
                <!-- Mensaje si no hay categorías -->
                <div class="px-6 py-4">
                    No hay ningún registro coincidente
                </div>
            @endif

            {{-- Comprobación de paginación de categorías --}}
            {{--  @if ($categories->hasPages())
                <div class="px-6 py-8">
                    {{ $categories->links() }}
                </div>
            @endif --}}
        </x-table>
    </div>

    <!-- Pie de la vista -->
    <x-slot name="footer">
        <h2 class="text-xl font-semibold leading-tight text-gray-600">
            Pie
        </h2>
    </x-slot>
</div>
