<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-danger text-uppercase']) }}>
  {{ $slot }}
</button>
