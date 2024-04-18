<?php

namespace App\Models;

use DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CapabilityImport implements ToCollection
{

	public function collection(Collection $rows)
	{
		// TODO: Implement collection() method.
		$counter = 0;
		$capabilities = [];
		$capability = "";
		$subcapability = "";
		foreach ($rows as $row) {
			$counter++;
			if ($counter < 4)
				continue;
			if (!is_null($row[0])) {
				$capability = $row[0];
			}
			if (!is_null($row[1])) {
				$subcapability = $row[1];
			}
			if (!isset($capabilities[$row[0]]) && !empty($row[0]))
				$capabilities[$capability] = [];
			if (!isset($capabilities[$capability][$subcapability]) && !empty($row[1]))
				$capabilities[$capability][$subcapability] = [];
			if (!is_null($row[2]))
				$capabilities[$capability][$subcapability][] = $row->slice(2)->values();
		}
		$capabilityCounter = 1;
		foreach ($capabilities as $key => $subcapabilities) {
			$weight = (int)(100 / count($capabilities));
			if ($capabilityCounter <= (100 % count($capabilities))) {
				$weight++;
			}
			$capabilityCounter++;
			$capability = Capability::create([
				'name' => $key,
				'weight' => $weight
			]);
			$subcapabilityCounter = 1;
			foreach ($subcapabilities as $key => $indicators) {
				$weight = (int)(100 / count($subcapabilities));
				if ($subcapabilityCounter <= (100 % count($subcapabilities))) {
					$weight++;
				}
				$subcapabilityCounter++;
				$subcapability = Subcapability::create([
					'capability_id' => $capability->id,
					'name' => $key,
					'weight' => $weight
				]);
				foreach ($indicators as $indicator) {
					Indicator::create([
						'text' => $indicator[0],
						'subcapability_id' => $subcapability->id,
						'highly_effective' => $indicator[1] ?? "",
						'effective' => $indicator[2] ?? "",
						'satisfactory' => $indicator[3] ?? "",
						'needs_improvement' => $indicator[4] ?? "",
						'does_not_meet_standard' => $indicator[5] ?? "",
					]);
				}
			}
		}
	}
}