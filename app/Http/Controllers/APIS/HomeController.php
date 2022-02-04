<?php

namespace App\Http\Controllers\APIS;

use App\Http\Controllers\Controller;
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
        return response()->json($posts);
    }
}
