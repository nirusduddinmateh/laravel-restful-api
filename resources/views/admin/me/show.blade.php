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
                            <div class="card-header">User ID:{{ $post->id }}</div>
                            <div class="card-body">

                                <a href="{{ route('me.index') }}" title="Back">
                                    <button class="btn btn-warning btn-sm">
                                        <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
                                    </button>
                                </a>
                                <a href="{{ route('me.edit', $post->id) }}" title="Edit">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                    </button>
                                </a>
                                <form action="{{ route('me.destroy', $post->id) }}" method="post"
                                      style="display:inline">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            title="Delete"
                                            onclick="return confirm('Confirm delete?')">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                    </button>
                                </form>
                                <br/>
                                <br/>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <th style="width: 20%"> Photo</th>
                                            <td> <img src="{{ Storage::url($post->img) }}" alt="{{ $post->description }}" class="h-100 w-100 object-cover"></td>
                                        </tr>
                                        <tr>
                                            <th> Description</th>
                                            <td> {{ $post->description }} </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
