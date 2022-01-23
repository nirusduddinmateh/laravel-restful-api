{{--@if ($formMode === 'edit')
    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
        <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
            <!-- Profile Photo File Input -->
            <input type="file" class="hidden"
                   wire:model="photo"
                   x-ref="photo"
                   x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            "/>

            <x-jet-label for="photo" value="{{ __('Photo') }}"/>

            <!-- Current Profile Photo -->
            <div class="mt-2" x-show="! photoPreview">
                <img src="{{ $model->profile_photo_url }}" alt="{{ $model->name }}"
                     class="rounded-full h-20 w-20 object-cover">
            </div>

            <!-- New Profile Photo Preview -->
            <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
            </div>

            <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
                {{ __('Select A New Photo') }}
            </x-jet-secondary-button>

            @if ($model->profile_photo_path)
                <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                    {{ __('Remove Photo') }}
                </x-jet-secondary-button>
            @endif

            <x-jet-input-error for="photo" class="mt-2"/>
        </div>
    @endif
@endif--}}

<div class="form-group{{ $errors->has('name') ? 'has-error' : ''}}">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" name="name" value="{{ $formMode === 'edit' ? $model->name : '' }}"
           required>
    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email">Email address</label>
    <input type="email" class="form-control" id="email" name="email"
           value="{{ $formMode === 'edit' ? $model->email: '' }}" required>
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('password') ? 'has-error' : ''}}">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="password"
           name="password" {{ $formMode === 'create' ?? 'required' }}>
    {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('role') ? 'has-error' : ''}}">
    <label for="role">สิทธิใช้งาน</label>
    <select id="role" name="role" required>
        @if ($formMode === 'edit')
            <option value="admin"  {{ $model->role === 'admin'  ? 'selected':'' }}>แอดมิน</option>
            <option value="member" {{ $model->role === 'member' ? 'selected':'' }}>สมาชิก</option>
        @else
            <option value="admin">แอดมิน</option>
            <option value="member">สมาชิก</option>
        @endif
    </select>

    {!! $errors->first('role', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group{{ $errors->has('profile_photo_path') ? 'has-error' : ''}}">
    <label for="profile_photo_path">Photo</label>
    <input type="file" id="profile_photo_path" name="profile_photo_path">
    {!! $errors->first('profile_photo_path', '<p class="help-block">:message</p>') !!}
</div>

<div class="mb-5">
    @if($formMode === 'edit')
        <img src="{{ $model->profile_photo_url }}" alt="{{ $model->name }}" class="rounded-full h-20 w-20 object-cover"
             height="16px">
    @endif
</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $formMode === 'edit' ? 'Update' : 'Create' }}</button>
</div>
