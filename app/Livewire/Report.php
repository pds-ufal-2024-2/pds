<?php

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Livewire\Component;

class Report extends Component
{
    use WithFileUploads;

    #[Reactive]
    public $lat;

    #[Reactive]
    public $lng;

    #[Validate('image|max:1024')] // 1MB Max
    public $photo;

    public function render()
    {
        return view('livewire.report');
    }

    public function savePhoto()
    {
        $this->photo->store(path: 'photos');
    }
}
