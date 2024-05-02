remarks <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWTransferItemsVoucherDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_transfer_items_voucher_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_id')->constrained('w_transfer_items_vouchers');
            $table->foreignId('product_id')->constrained('w_products');
            $table->foreignId('unit_id')->constrained('w_units');
            $table->float('product_qty');
            $table->float('converted_product_qty');
            $table->float('cost_price');
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
        Schema::dropIfExists('w_transfer_items_voucher_details');
    }
}
