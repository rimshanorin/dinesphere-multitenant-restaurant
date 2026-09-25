<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class MenuItemController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Tenant/Dashboard', [
            'menuItems' => MenuItem::latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
            'category' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'], // max 2MB
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('menu-items', 'public');
        }

        unset($validated['image']);

        MenuItem::create($validated);

        return back()->with('success', 'Menu item added successfully!');
    }

    public function update(Request $request, MenuItem $menuItem): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
            'category' => ['required', 'string', 'max:255'],
            'is_available' => ['boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($menuItem->image_path) {
                Storage::disk('public')->delete($menuItem->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('menu-items', 'public');
        }

        unset($validated['image']);

        $menuItem->update($validated);

        return back()->with('success', 'Menu item updated successfully!');
    }

    public function destroy(MenuItem $menuItem): RedirectResponse
    {
        if ($menuItem->image_path) {
            Storage::disk('public')->delete($menuItem->image_path);
        }

        $menuItem->delete();

        return back()->with('success', 'Menu item deleted successfully!');
    }
}
