<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\MonetaryOutput;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use \App\Traits\ControllerIndexTrait;

    /**
     * Show the main page.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $campaigns = Campaign::where('status', 'active')
            ->orderBy('priority', 'desc')
            ->orderBy('percent_done', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $donations  = Donation::take(10)->orderBy('created_at', 'desc')->get();
        $totalDonations = Donation::sum('amount');
        $outputs = MonetaryOutput::take(10)->orderBy('created_at', 'desc')->get();
        $totalOutputs = MonetaryOutput::sum('amount');

        return view('welcome', [
            'campaigns' => $campaigns,
            'outputs' => $outputs,
            'totalOutputs' => $totalOutputs,
            'totalDonations' => $totalDonations,
            'donations' => $donations
        ]);
    }
}
