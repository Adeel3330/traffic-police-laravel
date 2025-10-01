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
        Schema::create('dlms_license_status', function (Blueprint $table) {
            $table->id(); // id (auto increment, primary key)

            $table->string('ApplicantName')->nullable();
            $table->string('LicenseCategory')->nullable();
            $table->string('LicenseType')->nullable();
            $table->string('CNIC')->nullable();
            $table->string('RequestNumber')->nullable();
            $table->string('LearnerNumber')->nullable();
            $table->string('LicenseNumber')->nullable();
            $table->string('Status')->nullable();
            $table->string('issue_date')->nullable();
            $table->string('expire_date')->nullable();
            $table->text('address')->nullable();
            $table->dateTime('added_on')->useCurrent();
            $table->string('district_name')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->integer('is_updated')->default(0);
            $table->integer('is_added')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dlms_license_status');
    }
};
