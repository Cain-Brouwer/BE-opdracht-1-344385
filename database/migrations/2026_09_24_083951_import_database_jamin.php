<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The Jamin script (create_script_jamin.sql) is written for MySQL/MariaDB and
     * is executed as-is, so the tables always match the delivered create script.
     */
    private const CREATE_SCRIPT = 'create_script_jamin.sql';

    /**
     * Tables created by the Jamin script, in dependency order.
     *
     * @var list<string>
     */
    private const TABLES = [
        'ProductPerAllergeen',
        'ProductPerLeverancier',
        'Magazijn',
        'Leverancier',
        'Product',
        'Allergeen',
    ];

    public function up(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::unprepared((string) file_get_contents(base_path(self::CREATE_SCRIPT)));
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach (self::TABLES as $table) {
            Schema::dropIfExists($table);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
