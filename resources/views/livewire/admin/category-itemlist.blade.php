<div x-data="{ open: {{ $isOpen ? 'true' : 'false' }} }" class="mt-2 mb-4">


    <div @mousedown="toggle({{ $category->id }})" class="flex items-center justify-between cursor-pointer">
        <div @click="open = !open" class="flex items-center cursor-pointer">
            <div style="margin-left: {{ $depth * 30 }}px" class="flex">
                <div class="mr-2" x-show="!open">
                    <i class="fas fa-plus"></i>
                </div>
                <div class="mr-2" x-show="open">
                    <i class="fas fa-minus"></i>
                </div>
                <div class="flex-shrink-0 h-10 ml-2 mr-2 w-15">
                    @if ($category->image)
                        <img class="object-cover w-20 h-10 rounded-sm"
                            src="{{ url($category->image) }}" alt="{{ $category->name }}">
                        {{-- src="{{ Storage::url($brand->image) }}" storage//storage/brand/default.jpg  en la bd esta puesto esto 	/storage/brands/default.jpg > --}}
                        {{-- url($brand->image) muestra tal como es la ruta en la bd esta puesto esto 	/storage/brands/default.jpg --}}
                        {{--  {{ Storage::disk("s3")->url($brand->image) }} --}}
                    @else
                        <img class="object-cover h-6 rounded-full w-15"
                            src="{{ asset('storage/brands/category-default.jpg') }}"
                            alt="{{ $category->name }}" >
                    @endif
                </div>
                <div>
                    <span>{{ $category->name }} {{ $selectedParentCategory }}</span>
                </div>
            </div>

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

    {{-- <hr class="my-2 border-t border-gray-300 dotted"> --}}
    {{-- <hr class="w-full my-2 border-t border-gray-300 dotted"> --}}
    <hr class="w-full my-2 border-t border-gray-300 dotted" style="margin-left: {{ $depth * 30 }}px">

    <ul x-show="open" @click.away="open = true" >
        @foreach ($category->children as $child)
            <li>
                <div style="margin-left: {{ ($depth + 1) * 20 }}px">
                    <livewire:admin.category-itemlist :category="$child" :selectedParentCategory="$selectedParentCategory" :key="$child->id" />
                </div>
            </li>
        @endforeach
    </ul>

</div>

