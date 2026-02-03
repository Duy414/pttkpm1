<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CompleteUserColumns extends Migration
{
    public function up()
    {
        // Chỉ thêm các cột nếu chưa tồn tại
        if (!Schema::hasColumn('users', 'address')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('address')->nullable()->after('is_admin');
            });
        }
        
        if (!Schema::hasColumn('users', 'phone')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('phone')->nullable()->after('address');
            });
        }
    }

    public function down()
    {
        // Không cần thực hiện gì trong down()
    }
}
?>