<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function dashboard(Request $request)
    {
        $keyword = $request->get('q');
        $perPage = 12;

        if (!empty($keyword)) {
            $posts = Post::query()->with('user')->where('description', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $posts = Post::query()->with('user')->latest()->paginate($perPage);
        }
        return view('dashboard', compact('posts'));
    }
}
