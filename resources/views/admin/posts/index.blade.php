<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('รายการอัพโหลด') }}
        </h2>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm"
                                   title="Add New User">
                                    <i class="fa fa-plus" aria-hidden="true"></i> อัปโหลดรูปภาพ
                                </a>

                                <form action="{{ route('posts.index') }}" autocomplete="off"
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
                                            <th>รูป</th>
                                            <th>คำอธิบาย</th>
                                            <th>เครื่องมือ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($posts as $item)
                                            <tr>
                                                <th scope="row">{{ $item->id }}</th>
                                                <td><img src="{{ Storage::url($item->img) }}" class="h-16 w-16 object-cover"></td>
                                                <td>{{ $item->description }}</td>
                                                <td>
                                                    <a href="{{ route('posts.show', $item->id) }}" title="View">
                                                        <button class="btn btn-info btn-sm">
                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                        </button>
                                                    </a>
                                                    <a href="{{ route('posts.edit', $item->id) }}" title="Edit">
                                                        <button class="btn btn-primary btn-sm">
                                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                        </button>
                                                    </a>
                                                    <form action="{{ route('posts.destroy', $item->id) }}" method="post" style="display:inline">
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
                                    <div class="pagination-wrapper"> {!! $posts->appends(['search' => Request::get('search')])->render() !!} </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
