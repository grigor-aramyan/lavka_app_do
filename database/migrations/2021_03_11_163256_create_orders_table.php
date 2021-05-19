<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->text('comment')->nullable()->default(null);
            $table->enum('status', ['pending', 'in_warehouse', 'on_the_way', 'delivered', 'completed', 'canceled'])->default('pending');
            $table->string('delivery_address')->nullable()->default(null);
            $table->string('delivery_phone')->nullable()->default(null);
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
