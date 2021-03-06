<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('รายชื่อสมาชิก') }}
        </h2>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('users.create') }}" 
                                class="btn btn-success"
                                   title="เพิ่มสมาชิก">
                                    <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มสมาชิก
                                </a>

                                <form action="{{ route('users.index') }}" autocomplete="off"
                                      class="form-inline float-right">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="q"
                                               placeholder="ค้นหา..."
                                               value="{{ request('search') }}">
                                        <span class="input-group-append">
                                                <button class="btn btn-secondary" type="submit">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                    </div>
                                </form>

                                <p></p>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>รหัส</th>
                                            <th>รูปภาพ</th>
                                            <th>ชื่อผู้ใช้งาน</th>
                                            <th>อีเมล</th>
                                            <th>สิทธิใช้งาน</th>
                                            <th>เครื่องมือ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($users as $item)
                                            <tr>
                                                <th scope="row">{{ $item->id }}</th>
                                                <td><img src="{{ $item->profile_photo_url }}" alt="{{ $item->name }}" class="rounded-full h-10 w-10 object-cover" height="16px"></td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->role }}</td>
                                                <td>
                                                    <a href="{{ route('users.show', $item->id) }}" title="View">
                                                        <button class="btn btn-info btn-sm">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('users.edit', $item->id) }}" title="Edit">
                                                        <button class="btn btn-primary btn-sm">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                        </button>
                                                    </a>
                                                    <form action="{{ route('users.destroy', $item->id) }}" method="post" style="display:inline">
                                                        @csrf
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit"
                                                                class="btn btn-danger btn-sm"
                                                                title="Delete"
                                                                onclick="return confirm('Confirm delete?')">
                                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="pagination-wrapper"> {!! $users->appends(['search' => Request::get('search')])->render() !!} </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
