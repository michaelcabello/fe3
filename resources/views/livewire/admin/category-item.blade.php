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
</div>


{{-- <div x-data="{ open: {{ $isOpen ? 'true' : 'false' }} }" x-bind:style="{ 'margin-left': $category->depth * 20 + 'px' }">
    <div @click="open = !open">
        <i class="fas fa-plus" x-show="!open"></i>
        <i class="fas fa-minus" x-show="open"></i>
        {{ $category->name }}
    </div>
    <ul x-show="open">
        @foreach($category->children as $child)
            <livewire:admin.category-item :category="$child" :isOpen="$isOpen" :key="$child->id"/>
        @endforeach
    </ul>
</div> --}}
