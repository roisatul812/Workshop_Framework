<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGoogleAndOtpToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'google_id')) {
                $table->string('google_id')->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'otp')) {
                $table->string('otp', 6)->nullable()->after('google_id');
            }

        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('google_id');
            $table->dropColumn('otp');

        });
    }
}