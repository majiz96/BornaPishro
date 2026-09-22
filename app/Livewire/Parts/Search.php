<?php

namespace App\Livewire\Parts;

use App\Models\Article;
use App\Models\Product;
use App\Models\Service;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Search extends Component
{
    public $panel = 0;
    public $search;
    public $filter;

    public $modalSearch = 0;
    public $showProducts;
    public $showArticles;
    public $showServices;

    #[On('searchToggled')]
    public function showSearchPanel()
    {
        $this->panel = 1;
        $this->search = '';
    }
    #[On('modalSearchToggled')]
    public function showModalSearchPanel()
    {
        $this->modalSearch = 1;
        $this->search = '';

    }

    public function closeSearch()
    {
        $this->panel = 0;
        $this->search = '';
    }
    public function closeModalSearch()
    {
        $this->modalSearch = 0;
        $this->search = '';
    }
    public function eraseSearch()
    {
        $this->search = '';
    }

    #[Computed]
    public function getProducts()
    {
      if (empty($this->search))
      {
          return collect();
      }

      return Product::where('name', 'like', '%' . $this->search . '%')
          ->where('show',1)
          ->limit(10)
          ->orderBy('created_at','DESC')
          ->get();
    }
    #[Computed]
    public function getArticles()
    {
      if (empty($this->search))
      {
          return collect();
      }

      return Article::where('title', 'like', '%' . $this->search . '%')
          ->orWhere('intro', 'like', '%' . $this->search . '%')
          ->where('show',1)
          ->limit(10)
          ->orderBy('created_at','DESC')
          ->get();
    }
    #[Computed]
    public function getServices()
    {
      if (empty($this->search))
      {
          return collect();
      }

      return Service::where('title', 'like', '%' . $this->search . '%')
          ->orWhere('intro', 'like', '%' . $this->search . '%')
          ->where('show',1)
          ->limit(10)
          ->orderBy('created_at','DESC')
          ->get();
    }

    public function render()
    {
        return view('livewire.parts.search');
    }
}
