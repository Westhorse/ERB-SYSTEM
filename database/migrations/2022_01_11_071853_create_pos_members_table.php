<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_members', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->json('name')->nullable();
            $table->json('work_field')->nullable();
            $table->string('telephone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->unique()->nullable();
            $table->json('address')->nullable();
            $table->boolean('is_active')->default(1);
            $table->foreignId('nationality_id')->nullable()->constrained('c_nationalities');
            $table->softDeletes();
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
        Schema::dropIfExists('pos_members');
    }
}
