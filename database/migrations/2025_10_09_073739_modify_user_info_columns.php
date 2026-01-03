<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ModifyUserInfoColumns extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE user_info 
            MODIFY COLUMN preferred_time SET('morning','noon','evening','night','late night') NULL
        ");

        DB::statement("
            ALTER TABLE user_info 
            MODIFY COLUMN preferred_mode SET('online','offline','hybrid') NULL
        ");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE user_info MODIFY COLUMN preferred_time VARCHAR(255) NULL");
        DB::statement("ALTER TABLE user_info MODIFY COLUMN preferred_mode VARCHAR(255) NULL");
    }
}


