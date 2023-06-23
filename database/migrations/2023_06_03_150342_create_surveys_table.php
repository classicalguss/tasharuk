<?php

use App\Models\Capability;
use App\Models\Indicator;
use App\Models\School;
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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
			$table->foreignIdFor(Stakeholder::class);
			$table->foreignIdFor(School::class);
			$table->string('receiver_email');
			$table->foreignIdFor(Indicator::class);
			$table->foreignIdFor(Capability::class);
			$table->foreignIdFor(Subcapability::class);
			$table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
