<?php

namespace App\Http\Terranet\Administrator\Dashboard;

use Terranet\Administrator\Contracts\Services\Widgetable;
use Terranet\Administrator\Contracts\Sortable;

class BlankPanel implements Widgetable, Sortable
{
    /**
     * Widget contents
     *
     * @return mixed
     */
    public function render()
    {
        return
        <<<OUT
            <h3 class="panel-heading">Welcome to Terranet/Administrator.</h3>
            <div class="panel-body">
                <p class="well">
                    This is the default dashboard page.
                    To add dashboard sections, checkout 'administrator::layouts/dashboard.blade.php'.
                </p>
            </div>
OUT;
    }

    /**
     * Get the object order number
     *
     * @return int
     */
    public function order()
    {
        return 1;
    }
}
