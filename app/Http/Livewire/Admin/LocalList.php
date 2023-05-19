<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Local;
use Illuminate\Support\Facades\Storage;
use Illuminate\validation\Rule;
use Livewire\WithFileUploads;


class LocalList extends Component
{

    use WithPagination;
    use WithFileUploads;
    public $search, $image, $local, $state;
    public $sort='id';
    public $direction='desc';
    public $cant='10';
    public $open_edit = false;
    public $readyToLoad = false;//para controlar el preloader inicia en false


    public function render()
    {
        return view('livewire.admin.local-list');
    }
}
