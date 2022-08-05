<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Book;

class HomepageBooks extends Component
{
    public function render()
    {
        return view('livewire.homepage-books', [
            'books' => Book::paginate(10),
        ]);
    }
}
