<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
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
            $users = User::query()->where('name', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $users = User::latest()->paginate($perPage);
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|Redirector|RedirectResponse
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('admin'), 403, '403 Forbidden');

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required',
            'profile_photo_path' => 'image'
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        if ($request->hasFile('profile_photo_path')) {
            $data['profile_photo_path'] = $request->file('profile_photo_path')->storePublicly('profile-photos', ['disk' => 'public']);
        }

        User::query()->create($data);

        return redirect(route('users.index'))->with('flash_message', 'User added!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function show($id)
    {
        $user = User::query()->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|Response
     */
    public function edit($id)
    {
        $user = User::query()->findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function update(Request $request, $id)
    {
        abort_if(Gate::denies('admin'), 403, '403 Forbidden');

        $this->validate($request, [
            'name'  => 'required',
            'email' => 'required|string|max:255|email|unique:users,email,' . $id,
            'profile_photo_path' => 'image',
            'role' => 'in:admin,member'
        ]);

        $data = $request->except('password');
        if ($request->has('password')) {
            if (!is_null($request->get('password')))
                $data['password'] = bcrypt($request->password);
        }

        $user = User::query()->findOrFail($id);

        if ($request->hasFile('profile_photo_path')) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $data['profile_photo_path'] = $request->file('profile_photo_path')->storePublicly('profile-photos', ['disk' => 'public']);
        }

        $user->update($data);


        return redirect(route('users.index'))->with('flash_message', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('admin'), 403, '403 Forbidden');

        $user = User::query()->findOrFail($id);
        $user->delete();

        Storage::disk('public')->delete($user->profile_photo_path);

        return redirect(route('users.index'))->with('flash_message', 'User deleted!');
    }
}
