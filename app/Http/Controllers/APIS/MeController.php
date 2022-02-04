<?php

namespace App\Http\Controllers\APIS;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class MeController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('q');
        $perPage = 15;

        if (!empty($keyword)) {
            $posts = Auth::user()->posts()->where('description', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $posts = Auth::user()->posts()->latest()->paginate($perPage);
        }

        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required',
            'img' => 'required|image'
        ]);

        $data = $request->all();

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->storePublicly('posts', ['disk' => 'public']);
        }

        $post = Auth::user()->posts()->create($data);

        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $post = Auth::user()->posts()->findOrFail($id);

        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'description'  => 'required',
            'img' => 'image',
        ]);

        $data = $request->all();
        $post = Auth::user()->posts()->findOrFail($id);

        if ($request->hasFile('img')) {
            Storage::disk('public')->delete($post->profile_photo_path);
            $data['img'] = $request->file('img')->storePublicly('posts', ['disk' => 'public']);
        }

        $post->update($data);

        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        $post = Auth::user()->posts()->findOrFail($id);
        Storage::disk('public')->delete($post->img);
        $post->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
