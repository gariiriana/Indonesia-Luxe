<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Category;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function show(Package $package)
    {
        $package->increment('views');
        $package->load(['vendor', 'category', 'reviews.user']);
        $related = Package::approved()
            ->where('category_id', $package->category_id)
            ->where('id', '!=', $package->id)
            ->limit(4)
            ->get();

        return view('pages.tour-detail', compact('package', 'related'));
    }

    public function search(Request $request)
    {
        $query = Package::approved()->with(['category', 'vendor']);

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->q}%")
                    ->orWhere('description', 'like', "%{$request->q}%");
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('name', $request->category));
        }

        if ($request->filled('min_price')) {
            $query->where('discounted_price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('discounted_price', '<=', $request->max_price);
        }

        if ($request->filled('sort')) {
            match ($request->sort) {
                'price_asc' => $query->orderBy('discounted_price', 'asc'),
                'price_desc' => $query->orderBy('discounted_price', 'desc'),
                'rating' => $query->orderBy('rating', 'desc'),
                'popular' => $query->orderBy('review_count', 'desc'),
                default => $query->latest(),
            };
        } else {
            $query->orderBy('rating', 'desc');
        }

        $packages = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('pages.search', compact('packages', 'categories'));
    }
}
