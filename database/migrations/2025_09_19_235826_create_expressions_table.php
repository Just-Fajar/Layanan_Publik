<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('expressions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitor_id')->nullable()->constrained('visitors')->onDelete('cascade');
            $table->string('expression');
            $table->float('confidence')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('expressions');
    }
};
