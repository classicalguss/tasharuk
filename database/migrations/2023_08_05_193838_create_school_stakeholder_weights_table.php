<?php

use App\Models\School;
use App\Models\Stakeholder;
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
        Schema::create('school_stakeholder_weights', function (Blueprint $table) {
            $table->id();
			$table->foreignIdFor(School::class);
			$table->foreignIdFor(Stakeholder::class);
			$table->float('weight');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_stakeholder_weights');
    }
};
