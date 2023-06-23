<?php

use App\Models\Capability;
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
        Schema::create('capabilities', function (Blueprint $table) {
            $table->id();
			$table->string("name");
			$table->float('weight');
			$table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
		Schema::create('subcapabilities', function (Blueprint $table) {
			$table->id();
			$table->string("name");
			$table->foreignIdFor(Capability::class);
			$table->float('weight');
			$table->boolean('is_visible')->default(true);
			$table->timestamps();
		});
		Schema::create('indicators', function (Blueprint $table) {
			$table->id();
			$table->text("text");
			$table->foreignIdFor(Subcapability::class);
			$table->text('highly_effective')->nullable();
			$table->text('effective')->nullable();
			$table->text('satisfactory')->nullable();
			$table->text('needs_improvement')->nullable();
			$table->text('does_not_meet_standard')->nullable();
			$table->boolean('is_visible')->default(true);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capabilities');
		Schema::dropIfExists('subcapabilities');
		Schema::dropIfExists('indicators');
	}
};
