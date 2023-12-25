<form method="post" action="{{ $model ? route( "company.update", [$model->id]) : route('company.store') }}"
      class="mt-6 space-y-6"
      enctype="multipart/form-data">
    @csrf
    @if ($model)
        @method('PUT')
    @endif
    <div>
        <x-input-label for="name" :value="__('Name')"/>
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                      :value="old('name', $model->name ?? '')"
                      required autofocus autocomplete="name"/>
        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
    </div>

    <div>
        <x-input-label for="email" :value="__('Email')"/>
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                      :value="old('email', $model->email ?? '')" required autocomplete="username"/>
        <x-input-error class="mt-2" :messages="$errors->get('email')"/>
    </div>

    <div>
        <x-input-label for="website" :value="__('Website')"/>
        <x-text-input id="website" name="website" type="text" class="mt-1 block w-full"
                      :value="old('website', $model->website ?? '')" required autocomplete="website"/>
        <x-input-error class="mt-2" :messages="$errors->get('website')"/>
    </div>

    <div>
        @if($model)
            <img src="{{ $model->logoUrl }}">
        @endif
        <x-input-label for="website" :value="__('Website')"/>
        <x-file-input id="logo" name="logo" type="text" class="mt-1 block w-full"
                      :value="old('logo', $model->logo ?? '')" autocomplete="website"/>
        <x-input-error class="mt-2" :messages="$errors->get('logo')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>

        @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm"
            >{{ __('Saved.') }}</p>
        @endif
    </div>
</form>
