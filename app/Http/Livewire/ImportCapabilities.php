<?php

namespace App\Http\Livewire;

use App\Models\CapabilityImport;
use DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportCapabilities extends Component
{
	use WithFileUploads;
	public $excelFile;
	public $status = "idle";

	public function import() {
		logger("import action is on!");
		$this->status = "progress";
		DB::table('capabilities')->truncate();
		DB::table('subcapabilities')->truncate();
		DB::table('indicators')->truncate();

		Excel::import(new CapabilityImport(), $this->excelFile);
		sleep(1);
		return redirect()->to('/capabilities');
	}
}
