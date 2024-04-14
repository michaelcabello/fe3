<div x-data="{ open: {{ $isOpen ? 'true' : 'false' }} }">
    <div @click="open = !open" class="flex items-center cursor-pointer">
        <div style="margin-left: {{ $depth * 20 }}px">
            <div class="mr-2" x-show="!open">
                <i class="fas fa-plus"></i>
            </div>
            <div class="mr-2" x-show="open">
                <i class="fas fa-minus"></i>
            </div>
        </div>
        <span>{{ $category->name }} </span>
        <div class="ml-auto">

            {{-- <button @click="editCategory({{ $category->id }})" class="text-blue-500 mr-2">Editar</button> --}}
            <a href="{{ route('category.editd', ['categoryId' => $category->id]) }}" class="text-blue-500 mr-2">Editar</a>
            <button wire:click="confirmDeleteCategory({{ $category->id }})" class="text-red-500"> Eliminar</button>
        </div>
    </div>
    <ul x-show="open" @click.away="open = false">
        @foreach($category->children as $child)
            <li>
                <div style="margin-left: {{ ($depth + 1) * 20 }}px">
                    <livewire:admin.category-item :category="$child" :isOpen="$isOpen" :depth="$depth + 1" :key="$child->id"/>
                </div>
            </li>
        @endforeach
    </ul>
</div>


{{-- <div x-data="{ open: {{ $isOpen ? 'true' : 'false' }} }">
    <div @click="open = !open" class="flex items-center cursor-pointer">
        <div style="margin-left: {{ $depth * 20 }}px">
            <div class="mr-2" x-show="!open">
                <i class="fas fa-plus"></i>
            </div>
            <div class="mr-2" x-show="open">
                <i class="fas fa-minus"></i>
            </div>
        </div>
        <span>{{ $category->name }}</span>
    </div>
    <ul x-show="open">
        @foreach($category->children as $child)
            <li>
                <div style="margin-left: {{ ($depth + 1) * 20 }}px">
                    <livewire:admin.category-item :category="$child" :isOpen="$isOpen" :depth="$depth + 1" :key="$child->id"/>
                </div>
            </li>
        @endforeach
    </ul>
</div> --}}



