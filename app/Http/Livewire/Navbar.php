<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Navbar extends Component
{
	/**
	 * The component's listeners.
	 *
	 * @var array
	 */
	protected $listeners = [
		'refresh-navigation-menu' => '$refresh',
	];

    public function render()
    {
        return view('livewire.navbar');
    }
}
