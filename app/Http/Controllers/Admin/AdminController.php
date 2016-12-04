<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\LegalEntity;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    use \App\Traits\ControllerIndexTrait;
    public function index()
    {

        $campaigns = Campaign::count('created_at', '>=', Carbon::now()->startOfWeek());
        $persons = Person::count('created_at', '>=', Carbon::now()->startOfWeek());
        $donors = Donor::count('created_at', '>=', Carbon::now()->startOfWeek());
        $donations = Donation::count('created_at', '>=', Carbon::now()->startOfWeek());
        $funds = Donation::where('created_at', '>=', Carbon::now()->startOfWeek())->sum('amount');
        $beneficiaries = Beneficiary::count('created_at', '>=', Carbon::now()->startOfWeek());
        $legal_entities = LegalEntity::count('created_at', '>=', Carbon::now()->startOfWeek());

        return view('admin.index', [
            'campaigns' => $campaigns,
            'persons' => $persons,
            'donors' => $donors,
            'funds' => $funds,
            'donations' => $donations,
            'beneficiaries' => $beneficiaries,
            'legal_entities' => $legal_entities,

        ]);
    }
}
