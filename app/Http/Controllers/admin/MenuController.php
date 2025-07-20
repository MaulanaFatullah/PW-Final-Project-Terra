<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menus.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'menu_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:50',
            'is_available' => 'boolean',
        ]);

        $data = $request->except('menu_image');

        if ($request->hasFile('menu_image')) {
            $imagePath = $request->file('menu_image')->store('menu_images', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        Menu::create($data);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan!');
    }

    public function show(Menu $menu)
    {
        return response()->json($menu);
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'item_name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'menu_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string|max:50',
            'is_available' => 'boolean',
        ]);

        $data = $request->except('menu_image');

        if ($request->hasFile('menu_image')) {
            if ($menu->image_url) {
                Storage::delete(str_replace('/storage/', 'public/', $menu->image_url));
            }
            $imagePath = $request->file('menu_image')->store('menu_images', 'public');
            $data['image_url'] = Storage::url($imagePath);
        }

        $menu->update($data);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui!');
    }

    public function destroy(Menu $menu)
    {
        if ($menu->image_url) {
            Storage::delete(str_replace('/storage/', 'public/', $menu->image_url));
        }
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus!');
    }
}
