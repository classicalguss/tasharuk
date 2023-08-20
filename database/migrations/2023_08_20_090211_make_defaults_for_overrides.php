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
        //
		Schema::table('override_capabilities', function (Blueprint $table) {
			$table->foreignIdFor(Stakeholder::class)->default(0)->nullable(false)->change();
			$table->foreignIdFor(School::class)->default(0)->nullable(false)->change();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
