<?php

namespace App\Http\Terranet\Administrator\Dashboard;

use Terranet\Administrator\Contracts\Services\Widgetable;
use Terranet\Administrator\Contracts\Sortable;

class DatabasePanel implements Widgetable, Sortable
{
    public function render()
    {
        $dbStats = $this->getDatabaseStats();

        return view(app('scaffold.template')->dashboard('database'), [
            'dbStats' => $dbStats,
        ]);
    }

    /**
     * @return mixed
     */
    protected function getDatabaseStats()
    {
        if (db_connection('mysql'))
            return $this->connection()->select($this->connection()->raw("SHOW TABLE STATUS"));
        return collect([]);
    }

    protected function connection()
    {
        return app('db');
    }

    public function order()
    {
        return 3;
    }
}
