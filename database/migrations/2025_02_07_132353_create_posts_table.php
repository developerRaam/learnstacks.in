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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('short_description');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->string('featured_image')->nullable();
            $table->bigInteger('user_id');
            $table->bigInteger('category_id');
            $table->bigInteger('sub_category_id')->nullable();
            $table->enum('status', ['Draft', 'Published', 'Archived'])->default('Draft');
            $table->timestamp('published_at')->nullable();
            
            $table->text('keywords')->nullable();
            $table->string('robots')->nullable();
            $table->string('googlebot')->nullable();
            $table->text('tags')->nullable();
            $table->string('canonical')->nullable();
            $table->integer('sort_by')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
