<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="row mb-2">
                    <div class="col">
                        <form action="{{ route('dashboard') }}" autocomplete="off" class="form-inline float-right">
                            <div class="input-group ">
                                <input type="text"
                                       class="form-control"
                                       name="q"
                                       placeholder="ค้นหา..."
                                       value="{{ request('q') }}">
                                <span class="input-group-append">
                                                <button class="btn btn-secondary" type="submit">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mb-2">
                    @foreach($posts as $item)
                        <div class="col-sm-12 col-md-6 col-lg-3 mb-3">
                            <div class="card">
                                <img src="{{ Storage::url($item->img) }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <small class="mb-2 text-primary">รูปโดย: {{ $item->user->name }}</small>
                                    <p class="card-text">{{ $item->description }}</p>
                                    {{--<a href="#" class="btn btn-sm btn-secondary">ดูรูปภาพ</a>--}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col">
                        <div class="pagination-wrapper"> {!! $posts->appends(['search' => Request::get('search')])->render() !!} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
