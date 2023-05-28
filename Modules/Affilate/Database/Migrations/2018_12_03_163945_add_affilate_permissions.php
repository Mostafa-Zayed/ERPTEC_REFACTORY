<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

class AddAffilatePermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Permission::create(['name' => 'affilate.show_affilate']);
        Permission::create(['name' => 'affilate.affilate_log']);
        
        Permission::create(['name' => 'affilate.affilate_paids_show']);
        Permission::create(['name' => 'affilate.affilate_paids_create']);
        Permission::create(['name' => 'affilate.affilate_paids_delete']);
        
        Permission::create(['name' => 'affilate.access_affilate_balance']);
        Permission::create(['name' => 'affilate.show_notification']);
        Permission::create(['name' => 'affilate.affilate_report_show']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
