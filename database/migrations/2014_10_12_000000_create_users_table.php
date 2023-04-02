<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\GenderEnum;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            //auth credential
            $table->string('id_number')->unique();
            $table->string('password');

            //Specific column dataType
            $table->humanName();

            $table->dateTime('birth_date');
            $table->unsignedTinyInteger('marital_status');
            $table->unsignedTinyInteger('gender')->default(GenderEnum::UNKNOWN);
            $table->string('photo');

            //deceased
            $table->boolean('deceased')->default(false);
            $table->dateTime('deceased_date')->nullable();

            $table->unsignedTinyInteger('type');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
