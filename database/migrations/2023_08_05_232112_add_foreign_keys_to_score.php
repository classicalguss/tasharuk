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
        Schema::table('survey_scores', function (Blueprint $table) {
			$table->foreignIdFor(School::class);
			$table->foreignIdFor(Stakeholder::class);
            //
        });
		Schema::table('survey_subcapability_scores', function (Blueprint $table) {
			$table->foreignIdFor(School::class);
			$table->foreignIdFor(Stakeholder::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
