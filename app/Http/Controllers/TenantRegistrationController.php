<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
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
            'owner_password' => ['required', 'string', 'min:8', 'confirmed'],
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

        // Create the owner's login account INSIDE the tenant's own database
        $tenant->run(function () use ($validated) {
            \App\Models\User::create([
                'name' => $validated['owner_name'],
                'email' => $validated['owner_email'],
                'password' => Hash::make($validated['owner_password']),
            ]);
        });

        return redirect('/')->with(
            'success',
            "Your restaurant site is ready! Visit http://{$validated['subdomain']}.localhost:8000 and log in with the email and password you just created."
        );
    }
}
