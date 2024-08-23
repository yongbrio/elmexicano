<?php

namespace App\Livewire\Administracion\Log;

use Livewire\Attributes\On;
use Livewire\Component;

class Log extends Component
{
    public function render()
    {
        return view('livewire.administracion.log.log');
    }

    #[On('verLog')]
    public function datosLog($id) {

    }
}
