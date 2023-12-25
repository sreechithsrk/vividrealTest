<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-danger bg-danger']) }}>
    {{ $slot }}
</button>
