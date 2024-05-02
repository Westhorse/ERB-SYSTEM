<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCBranchesBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_branches_business', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('c_branches');
            $table->foreignId('business_id')->nullable()->constrained('c_business');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_branches_business');
    }
}
