<?php

use App\Models\Loan;
use App\Models\Repayment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repayments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Loan::class);
            $table->decimal('amount');
            $table->decimal('amount_paid')->nullable();
            $table->date('due_on');
            $table->date('paid_on')->nullable();
            $table->string('status')->default(Repayment::REPAYMENT_PENDING);
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
        Schema::dropIfExists('repayments');
    }
};
