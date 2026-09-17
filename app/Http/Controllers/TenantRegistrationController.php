<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

class TenantRegistrationController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('TenantRegister');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'restaurant_name' => ['required', 'string', 'max:255'],
            'owner_name' => ['required', 'string', 'max:255'],
            'owner_email' => ['required', 'email', 'max:255'],
            'cuisine_type' => ['required', 'string', 'max:255'],
            'subdomain' => [
                'required',
                'string',
                'max:63',
                'alpha_dash',
                'lowercase',
                'unique:tenants,id',
            ],
        ]);

        $tenant = Tenant::create([
            'id' => $validated['subdomain'],
            'name' => $validated['restaurant_name'],
            'slug' => Str::slug($validated['restaurant_name']),
            'owner_name' => $validated['owner_name'],
            'owner_email' => $validated['owner_email'],
            'cuisine_type' => $validated['cuisine_type'],
        ]);

        $tenant->domains()->create([
            'domain' => $validated['subdomain'] . '.localhost',
        ]);

        return redirect('/')->with(
            'success',
            "Your restaurant site is ready! Visit http://{$validated['subdomain']}.localhost:8000"
        );
    }
}
