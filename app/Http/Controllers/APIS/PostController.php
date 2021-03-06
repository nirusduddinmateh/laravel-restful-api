<?php

namespace App\Http\Controllers\APIS;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $keyword = $request->get('q');
        $perPage = 15;

        if (!empty($keyword)) {
            $posts = Post::query()->where('name', 'LIKE', "%$keyword%")
                ->latest()
                ->paginate($perPage);
        } else {
            $posts = Post::query()
                ->latest()
                ->paginate($perPage);
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

        $post = Post::query()->create($data);

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
        $post = Post::query()->findOrFail($id);

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
        $post = Post::query()->findOrFail($id);

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
        $post = Post::query()->findOrFail($id);
        Storage::disk('public')->delete($post->img);
        $post->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
