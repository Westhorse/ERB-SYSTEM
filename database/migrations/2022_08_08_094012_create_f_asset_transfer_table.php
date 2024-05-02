<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFAssetTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('f_asset_transfer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('w_products');
            $table->string('order_number')->nullable();
            $table->date('order_date')->nullable();
            $table->json('remarks')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('temp_users');
            $table->foreignId('old_status_id')->nullable()->constrained('f_asset_status');
            $table->foreignId('old_cost_center_id')->nullable()->constrained('temp_cost_centers');
            $table->foreignId('old_deprecation_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('current_status_id')->nullable()->constrained('f_asset_status');
            $table->foreignId('current_cost_center_id')->nullable()->constrained('temp_cost_centers');
            $table->foreignId('current_deprecation_account_id')->nullable()->constrained('temp_accounts');
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
        Schema::dropIfExists('f_asset_transfer');
    }
}
