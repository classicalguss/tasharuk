<?php

use App\Models\Capability;
use App\Models\Stakeholder;
use App\Models\Survey;
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
            //
			$table->rename('survey_capability_scores');
        });
		Schema::create('survey_scores', function(Blueprint $table) {
			$table->id();
			$table->foreignIdFor(Survey::class);
			$table->foreignIdFor(Stakeholder::class);
			$table->float('score');
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('survey_scores', function (Blueprint $table) {
            //
        });
    }
};
