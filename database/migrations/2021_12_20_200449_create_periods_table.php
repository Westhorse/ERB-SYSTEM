<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_periods', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->json('name');
            $table->time('from_time');
            $table->time('to_time');
            $table->foreignId('branch_id')->nullable()->constrained('c_branches')->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->constrained('temp_accounts')->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('pos_periods');
    }
}
