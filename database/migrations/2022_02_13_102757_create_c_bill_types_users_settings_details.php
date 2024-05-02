<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCBillTypesUsersSettingsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_bill_types_users_settings_details', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('bill_type_user_setting_id', 'bill_type_user_setting')->nullable()->constrained('c_bill_types_users_settings');
            $table->bigInteger('bill_type_user_setting_id')->unsigned();
            $table->foreign('bill_type_user_setting_id', 'bill_types_foreign')->references('id')->on('c_bill_types_users_settings');
            $table->foreignId('account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('opposite_account_id')->nullable()->constrained('temp_accounts');
            $table->json('label')->nullable();
            $table->tinyInteger('payment_type')->nullable();
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
        Schema::dropIfExists('c_bill_types_users_settings_details');
    }
}
