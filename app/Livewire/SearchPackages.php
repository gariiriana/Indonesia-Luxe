<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Package;
use App\Models\Category;
use App\Models\Destination;

class SearchPackages extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategories = [];
    public $selectedDestinations = [];
    public $minRating = 0;
    public $priceRange = [0, 10000000];
    public $sortBy = 'recommended';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategories' => ['except' => []],
        'selectedDestinations' => ['except' => []],
        'minRating' => ['except' => 0],
        'sortBy' => ['except' => 'recommended'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleCategory($categoryId)
    {
        if (in_array($categoryId, $this->selectedCategories)) {
            $this->selectedCategories = array_diff($this->selectedCategories, [$categoryId]);
        } else {
            $this->selectedCategories[] = $categoryId;
        }
        $this->resetPage();
    }

    public function toggleDestination($destinationId)
    {
        if (in_array($destinationId, $this->selectedDestinations)) {
            $this->selectedDestinations = array_diff($this->selectedDestinations, [$destinationId]);
        } else {
            $this->selectedDestinations[] = $destinationId;
        }
        $this->resetPage();
    }

    public function setRating($rating)
    {
        $this->minRating = $this->minRating == $rating ? 0 : $rating;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedCategories = [];
        $this->selectedDestinations = [];
        $this->minRating = 0;
        $this->priceRange = [0, 10000000];
        $this->sortBy = 'recommended';
        $this->resetPage();
    }

    public function getPackagesProperty()
    {
        $query = Package::with(['category', 'destination', 'vendor'])
            ->approved();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhereHas('destination', function ($d) {
                        $d->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if (!empty($this->selectedCategories)) {
            $query->whereIn('category_id', $this->selectedCategories);
        }

        if (!empty($this->selectedDestinations)) {
            $query->whereIn('destination_id', $this->selectedDestinations);
        }

        if ($this->minRating > 0) {
            $query->where('rating', '>=', $this->minRating);
        }

        $query->whereBetween('discounted_price', $this->priceRange);

        switch ($this->sortBy) {
            case 'price-low':
                $query->orderBy('discounted_price', 'asc');
                break;
            case 'price-high':
                $query->orderBy('discounted_price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'popular':
                $query->orderBy('review_count', 'desc');
                break;
            default:
                $query->latest();
        }

        return $query->paginate(12);
    }

    public function render()
    {
        return view('livewire.search-packages', [
            'packages' => $this->packages,
            'categories' => Category::all(),
            'destinations' => Destination::all(),
        ]);
    }
}
