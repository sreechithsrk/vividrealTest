<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-success bg-success']) }}>
    {{ $slot }}
</button>
