<?php

namespace App\Listeners;

use Tenancy\Affects\Routes\Events\ConfigureRoutes;

class TenantRoutes
{
	public function handle(ConfigureRoutes $event)
	{
		if($event->event->tenant) {
			$event
				->flush()
				->fromFile(
					['middleware' => ['web']],
					base_path('/routes/tenant.php')
				);
		}
	}
}