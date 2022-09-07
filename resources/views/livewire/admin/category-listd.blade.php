<div>
    
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-600">
                Lista de Categorias
            </h2>
        </div

    </x-slot>

    <!-- This example requires Tailwind CSS v2.0+ -->
    <div class="container py-12 mx-auto border-gray-400 max-w-7xl sm:px-6 lg:px-8">


                
                <x-table>

                        <div class="items-center px-6 py-4 bg-gray-200 sm:flex">



                            <h2>Hola</h2>


                        </div>


                        @if (count($categories))
                           
                            <ul class="mx-1">
                                @foreach ($categories as $category)
                                    <li class="flex-1 py-4 my-2 ml-6 space-y-2 bg-white shadow">{{ $category->name }}</li>
                                    <ul class="ml-6 space-y-2">
                                    @foreach ($category->childrenCategories as $childCategory)
                                         @include('child_category', ['child_category' => $childCategory]) 
                                    @endforeach
                                    </ul>
                                @endforeach
                            </ul>
                

                        @else
                            <div class="px-6 py-4">
                                No hay ningún registro coincidente
                            </div>
                        @endif

                   

                        @if ($categories->hasPages()) {{-- existe paginación --}}               
                            <div class="px-6 py-8">
                                {{ $categories->links() }}
                            </div>
                            
                        @endif

                </x-table>
         
    </div>


    <x-slot name="footer">
        
            <h2 class="text-xl font-semibold leading-tight text-gray-600">
                Pie
            </h2>
     

    </x-slot>



</div>