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
                            <h2>Lista de Categorias</h2>
                        </div>

                        @if (count($categories))
                            <div>
                                <ul>
                                    @foreach($categories as $category)
                                    <div x-data="{ open: false }">
                                        <div @click="open = !open">
                                            <i class="fas fa-plus" x-show="!open"></i>
                                            <i class="fas fa-minus" x-show="open"></i>
                                            {{ $category->name }}
                                        </div>
                                        <ul x-show="open">
                                            @foreach($category->children as $child)
                                                <livewire:admin.category-item :category="$child" :key="$child->id"/>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="px-6 py-4">
                                No hay ningún registro coincidente
                            </div>
                        @endif

                        {{-- @if ($categories->hasPages())
                            <div class="px-6 py-8">
                                {{ $categories->links() }}
                            </div>

                        @endif --}}
                </x-table>
    </div>

    <x-slot name="footer">

            <h2 class="text-xl font-semibold leading-tight text-gray-600">
                Pie
            </h2>
    </x-slot>
</div>
