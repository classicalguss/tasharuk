<?php
$currentClass = 'btn-primary';
if (isset($btnClass) && in_array($btnClass, ['success', 'info', 'warning']))
	$currentClass = 'btn-'.$btnClass;
?>
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn '.$currentClass.' text-uppercase']) }}>
  {{ $slot }}
</button>
