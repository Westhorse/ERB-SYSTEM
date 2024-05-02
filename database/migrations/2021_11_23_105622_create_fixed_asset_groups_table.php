<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedAssetGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_asset_groups', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->json('name');
            $table->tinyInteger('relate_with')->default(0);

            // Groups Should Be Get From Another Module
            $table->foreignId('group_id')->constrained('w_product_categories');
            
            // Accounts Should Be Get From Another Module
            $table->foreignId('account_id')->nullable()->constrained('temp_accounts');

            $table->foreignId('branch_id')->nullable()->constrained('c_branches');
            $table->json('notes')->nullable();
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
        Schema::dropIfExists('f_asset_groups');
    }
}
