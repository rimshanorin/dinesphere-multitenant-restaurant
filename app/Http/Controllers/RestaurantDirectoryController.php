<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Inertia\Inertia;
use Inertia\Response;

class RestaurantDirectoryController extends Controller
{
    public function index(): Response
    {
        $restaurants = Tenant::with('domains')->get()->map(function ($tenant) {
            $domain = $tenant->domains->first()?->domain;

            return [
                'name' => $tenant->name,
                'cuisine_type' => $tenant->cuisine_type,
                'url' => $domain ? "http://{$domain}:8000" : null,
            ];
        })->filter(fn ($restaurant) => $restaurant['url'] !== null)->values();

        return Inertia::render('Restaurants', [
            'restaurants' => $restaurants,
        ]);
    }
}
