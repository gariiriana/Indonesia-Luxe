<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredPackages = Package::approved()
            ->with(['category', 'vendor'])
            ->where('rating', '>=', 4.0)
            ->orderBy('review_count', 'desc')
            ->limit(8)
            ->get();

        $categories = Category::withCount(['packages' => fn($q) => $q->where('status', 'approved')])
            ->having('packages_count', '>', 0)
            ->get();

        $popularDestinations = [
            ['name' => 'Bali', 'image' => 'https://images.unsplash.com/photo-1594805938422-b330ad42a7bb?w=600', 'count' => $this->packageCountByLocation('Bali')],
            ['name' => 'Labuan Bajo', 'image' => 'https://images.unsplash.com/photo-1694271486260-1a1859d4c745?w=600', 'count' => $this->packageCountByLocation('Labuan Bajo')],
            ['name' => 'Raja Ampat', 'image' => 'https://images.unsplash.com/photo-1696855179868-9c40f02b4706?w=600', 'count' => $this->packageCountByLocation('Raja Ampat')],
            ['name' => 'Yogyakarta', 'image' => 'https://images.unsplash.com/photo-1620549146396-9024d914cd99?w=600', 'count' => $this->packageCountByLocation('Yogyakarta')],
            ['name' => 'Bromo', 'image' => 'https://images.unsplash.com/photo-1559628233-e9287b161a30?w=600', 'count' => $this->packageCountByLocation('Bromo')],
            ['name' => 'Lombok', 'image' => 'https://images.unsplash.com/photo-1613278103929-b945a707411a?w=600', 'count' => $this->packageCountByLocation('Lombok')],
        ];

        return view('pages.home', compact('featuredPackages', 'categories', 'popularDestinations'));
    }

    private function packageCountByLocation(string $location): int
    {
        return Package::approved()->where('title', 'like', "%{$location}%")->count();
    }
}
