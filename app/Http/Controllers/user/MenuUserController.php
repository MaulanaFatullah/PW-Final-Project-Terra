<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuUserController extends Controller
{
    public function index()
    {
        $menus = Menu::where('is_available', true)->get();
        $categories = Menu::where('is_available', true)->distinct()->pluck('category')->filter()->values();
        return view('user.menus.index', compact('menus', 'categories'));
    }

    public function show(Menu $menus_user)
    {
        return response()->json($menus_user);
    }
}
