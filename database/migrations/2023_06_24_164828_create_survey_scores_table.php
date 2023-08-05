<?php

use App\Models\Capability;
use App\Models\School;
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
        Schema::create('survey_scores', function (Blueprint $table) {
            $table->id();
			$table->foreignIdFor(Survey::class);
			$table->foreignIdFor(Capability::class);
			$table->float('score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_scores');
    }
};
