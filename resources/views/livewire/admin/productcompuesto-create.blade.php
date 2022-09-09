<div>
    <x-slot name="header">
        <div class="flex items-center">
            <h2 class="text-xl font-semibold leading-tight text-gray-600">
                Producto Compuesto
            </h2>
        </div
    </x-slot>

    <div class="container py-12 mx-auto border-gray-400 max-w-7xl sm:px-6 lg:px-8">



            <x-table>

            @foreach ( $groupatributes as $groupatribute)
                <div>
                    <h2>{{  $groupatribute->name }}</h2>
                </div>
                @foreach ( $groupatribute->atributes as $atribute )
                
                    <x-jet-label>
                        <x-jet-checkbox
                    
                        wire:model.defer="editForm.categories"
                        wire:click="contadores"
                        name="atributes[]"
                        value="{{$atribute ->id}}" />
                        {{$atribute->name}}
                    </x-jet-label>
                @endforeach

            @endforeach

                
                    
            </x-table>
     
    </div>


    <x-slot name="footer">
        
            <h2 class="text-xl font-semibold leading-tight text-gray-600">
                Pie
            </h2>
    

    </x-slot>


    
</div>
