<?php

use App\Models\Capability;
use App\Models\Indicator;
use App\Models\Stakeholder;
use App\Models\Subcapability;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
		Schema::create('override_capabilities', function (Blueprint $table) {
			$table->id();
			$table->string('updated_model');
			$table->string("updated_column");
			$table->integer('foreign_id');
			$table->string('new_value');
			$table->foreignIdFor(Stakeholder::class);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('override_capabilities');
    }
};
