<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        return view('admin.me.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.me.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|Redirector|RedirectResponse
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

        Auth::user()->posts()->create($data);

        return redirect(route('me.index'))->with('flash_message', 'Post added!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application
     */
    public function show($id)
    {
        $post = Auth::user()->posts()->findOrFail($id);

        return view('admin.me.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application
     */
    public function edit($id)
    {
        $post = Auth::user()->posts()->findOrFail($id);

        return view('admin.me.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Application|RedirectResponse|Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'description'  => 'required',
            'img' => 'image',
        ]);

        $post = Auth::user()->posts()->findOrFail($id);

        if ($request->hasFile('img')) {
            Storage::disk('public')->delete($post->profile_photo_path);
            $data['img'] = $request->file('img')->storePublicly('posts', ['disk' => 'public']);
        }

        $post->update($data);

        return redirect(route('me.index'))->with('flash_message', 'Post updated!');
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

        return redirect(route('me.index'))->with('flash_message', 'Post deleted!');
    }
}
