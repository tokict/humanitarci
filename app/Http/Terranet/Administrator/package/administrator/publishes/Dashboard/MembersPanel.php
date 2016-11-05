<?php

namespace App\Http\Terranet\Administrator\Dashboard;

use App\User;
use DB;
use Terranet\Administrator\Contracts\Services\Widgetable;
use Terranet\Administrator\Contracts\Sortable;

class MembersPanel implements Widgetable, Sortable
{
    public function render()
    {
        $weekAgo = \Carbon\Carbon::now()->subWeek();
        $monthAgo = \Carbon\Carbon::now()->subMonth();

        $total            = $this->createModel()->count();
        $signedLastWeek   = $this->createModel()
                                 ->where('created_at', '>=', $weekAgo)->count();
        $signedLastMonth  = $this->createModel()
                                 ->where('created_at', '>=', $monthAgo)->count();
        $signedStatistics = $this->createModel()
                                 ->where('created_at', '>=', $monthAgo)
                                 ->select([DB::raw('COUNT(id) AS cnt'), DB::raw('DATE(created_at) as dt')])
                                 ->groupBy('dt')->pluck('cnt', 'dt');

        return view(app('scaffold.template')->dashboard('members'), [
            'total'            => $total,
            'signed'           => [
                'lastWeek'  => $signedLastWeek,
                'lastMonth' => $signedLastMonth,
            ],
            'signedStatistics' => $signedStatistics,
        ]);
    }

    /**
     * @return User
     */
    protected function createModel()
    {
        return (new User);
    }

    /**
     * Get the object order number
     *
     * @return int
     */
    public function order()
    {
        return 2;
    }
}
