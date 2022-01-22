<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">Create New User</div>
                            <div class="card-body">
                                <a href="{{ route('users.index') }}" title="Back">
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

                                <form action="{{ route('users.store') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                                    @csrf
                                    @include ('admin.users.form', ['formMode' => 'create'])
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
