<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('q');
        $perPage = 15;

        if (!empty($keyword)) {
            $posts = Post::query()->where('description', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $posts = Post::latest()->paginate($perPage);
        }

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required',
            'img' => 'image'
        ]);

        $data = $request->all();

        if ($request->hasFile('img')) {
            $data['img'] = $request->file('img')->storePublicly('posts', ['disk' => 'public']);
        }

        Post::query()->create($data);

        return redirect(route('posts.index'))->with('flash_message', 'Post added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View|Response
     */
    public function show($id)
    {
        $post = Post::query()->findOrFail($id);

        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View|Response
     */
    public function edit($id)
    {
        $post = Post::query()->findOrFail($id);

        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'description'  => 'required',
            'img' => 'image',
        ]);

        $post = Post::query()->findOrFail($id);

        if ($request->hasFile('img')) {
            Storage::disk('public')->delete($post->profile_photo_path);
            $data['img'] = $request->file('img')->storePublicly('posts', ['disk' => 'public']);
        }

        $post->update($data);

        return redirect(route('posts.index'))->with('flash_message', 'Post updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy($id)
    {
        $post = Post::query()->findOrFail($id);
        Storage::disk('public')->delete($post->img);
        $post->delete();
        return redirect(route('posts.index'));
    }
}
