<?php

use App\Models\Loan;
use App\Models\User;
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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->decimal('amount');
            $table->integer('term');
            $table->string('status')->default(Loan::APPROVAL_PENDING);
            $table->string('notes')->nullable()->comment('if loan was approved/rejected, the reason can captured here');
            $table->foreignIdFor(User::class, 'handled_by_id')->nullable()->comment('the id of admin, who handled the loan request case');
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['handled_by_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
};
