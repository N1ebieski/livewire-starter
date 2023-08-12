<?php

use App\Models\User\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $user = new User();

        Schema::create($user->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `{$user->getTable()}` ADD FULLTEXT `fulltext_index` (`name`, `email`)");
        DB::statement("ALTER TABLE `{$user->getTable()}` ADD FULLTEXT `fulltext_name` (`name`)");
        DB::statement("ALTER TABLE `{$user->getTable()}` ADD FULLTEXT `fulltext_email` (`email`)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $user = new User();

        Schema::dropIfExists($user->getTable());
    }
};
