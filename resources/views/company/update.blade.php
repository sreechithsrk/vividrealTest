<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Update Company') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @include('company.form', ['model' => $model])
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(function () {

            });
        </script>
    @endpush
</x-app-layout>
