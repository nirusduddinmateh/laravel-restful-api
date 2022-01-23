<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">Edit Post</div>
                            <div class="card-body">
                                <a href="{{ route('me.index') }}" title="Back">
                                    <button class="btn btn-warning">
                                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                                    </button>
                                </a>
                                <br/>
                                <br/>

                                @if ($errors->any())
                                    <ul class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                <form action="{{ route('me.update', $post->id) }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                                    @csrf
                                    {{ method_field('PATCH') }}
                                    @include ('admin.me.form', ['formMode' => 'edit', 'model'=> $post])
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
