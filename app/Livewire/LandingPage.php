<?php

namespace App\Livewire;

use Livewire\Component;

class LandingPage extends Component
{
    public $featuredProducts;

    public function mount()
    {
        $this->featuredProducts = \App\Models\Product::where('is_available', true)
            ->where('stock', '>', 0)
            ->inRandomOrder()
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.landing-page');
    }
}
