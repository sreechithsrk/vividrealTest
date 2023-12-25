<form method="post" action="{{ $model ? route( "employee.update", [$model->id]) : route('employee.store') }}"
      class="mt-6 space-y-6"
      enctype="multipart/form-data">
    @csrf
    @if ($model)
        @method('PUT')
    @endif
    <div>
        <x-input-label for="first_name" :value="__('First Name')"/>
        <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full"
                      :value="old('first_name', $model->first_name ?? '')"
                      required autofocus autocomplete="first_name"/>
        <x-input-error class="mt-2" :messages="$errors->get('first_name')"/>
    </div>

    <div>
        <x-input-label for="last_name" :value="__('First Name')"/>
        <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                      :value="old('last_name', $model->last_name ?? '')"
                      required autofocus autocomplete="last_name"/>
        <x-input-error class="mt-2" :messages="$errors->get('last_name')"/>
    </div>

    <div>
        <x-input-label for="company_id" :value="__('Company')"/>
        <x-select-input id="company_id" name="company_id" class="mt-1 block w-full" required>
            <option value="">Select Company</option>
            @foreach($companies as $company)
                <option value="{{ $company->id }}" {{ old('company_id', $model->company_id ?? '') ? 'selected' : '' }}>{{ $company->name }}</option>
            @endforeach
        </x-select-input>
        <x-input-error class="mt-2" :messages="$errors->get('company_id')"/>
    </div>

    <div>
        <x-input-label for="email" :value="__('Email')"/>
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                      :value="old('email', $model->email ?? '')" required autocomplete="username"/>
        <x-input-error class="mt-2" :messages="$errors->get('email')"/>
    </div>

    <div>
        <x-input-label for="phone" :value="__('Phone')"/>
        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                      :value="old('phone', $model->phone ?? '')" required autocomplete="phone"/>
        <x-input-error class="mt-2" :messages="$errors->get('phone')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Save') }}</x-primary-button>
    </div>
</form>
