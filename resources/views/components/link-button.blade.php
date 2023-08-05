<?php
    $currentClass = 'btn-primary';
	if (isset($btnClass) && in_array($btnClass, ['success']))
		$currentClass = 'btn-success';
?>
<a {{ $attributes->merge(['class' => 'btn '.$currentClass.' text-uppercase']) }}>
  {{ $slot }}
</a>
