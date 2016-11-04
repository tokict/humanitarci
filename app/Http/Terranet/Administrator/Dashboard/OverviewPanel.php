<?php

namespace App\Http\Terranet\Administrator\Dashboard;

use App\Models\Beneficiary;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\LegalEntity;
use App\Models\Person;
use Illuminate\View\View;
use Terranet\Administrator\Traits\Stringify;
use Terranet\Administrator\Contracts\Services\Widgetable;

class OverviewPanel implements Widgetable
{
    use Stringify;

    /**
     * Widget contents
     *
     * @return mixed string|View
     */
    public function render()
    {
        return view('admin.dashboard.overview', [
            'title'   => 'Stats &raquo; Overview',
            'persons'   => $total = Person::count(),
            'legal_entities' => $legal = LegalEntity::count(),
            'campaigns'  => $campaign = Campaign::count(),
            'donors'  => $donor = Donor::count(),
            'beneficiaries'  => $beneficiaries = Beneficiary::count(),
            'donations' => $donations = Donation::count()
           /* 'created'  => [
                'lastWeek'  => User::signedWeeksAgo(1)->count(),
                'lastMonth' => User::signedMonthsAgo(1)->count()
            ],
            'ratio' => [
                'writers' => ($total ? round(($writers / $total) * 100) : 0),
                'active'  => ($total ? round(($active / $total) * 100) : 0),
            ]*/
        ]);
    }
}