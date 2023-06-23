<button {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-secondary text-uppercase']) }}>
  {{ $slot }}
</button>
