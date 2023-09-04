<?php

use App\Models\Role\Role;
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
        $role = new Role();

        DB::statement("ALTER TABLE `{$role->getTable()}` ADD FULLTEXT `fulltext_index` (`name`)");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $role = new Role();

        Schema::create($role->getTable(), function (Blueprint $table) {
            $table->dropIndex('fulltext_index');
        });
    }
};
