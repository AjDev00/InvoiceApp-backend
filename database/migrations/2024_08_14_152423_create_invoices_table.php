<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string("bill_from_street_address");
            $table->string("bill_from_city");
            $table->string("bill_from_post_code");
            $table->string("bill_from_country");
            $table->string("bill_to_client_name");
            $table->string("bill_to_client_email");
            $table->string("bill_to_street_address");
            $table->string("bill_to_city");
            $table->string("bill_to_post_code");
            $table->string("bill_to_country");
            $table->string("bill_to_invoice_date");
            $table->string("bill_to_payment_terms");
            $table->string("bill_to_project_desc");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
