<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        
        Schema::dropIfExists('paymentss');
        

        Schema::create('paymentss', function (Blueprint $table) {
            $table->id();
            $table->string('payment_type');
            $table->unsignedBigInteger('receipt_number')->unique();
            $table->date('payment_date');
            $table->string('student_id');
            $table->decimal('amount', 10, 2);
            $table->decimal('balance', 10, 2);
            $table->string('payment_method');
            $table->text('discription');
            $table->unsignedInteger('recorded_by');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paymentss');
    }
};

