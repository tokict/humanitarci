<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\Campaign;
use App\Models\Donor;
use App\Models\LegalEntity;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function index()
    {

        $campaigns = Campaign::count('created_at', '>=', Carbon::now()->startOfWeek());
        $persons = Person::count('created_at', '>=', Carbon::now()->startOfWeek());
        $donors = Donor::count('created_at', '>=', Carbon::now()->startOfWeek());
        $beneficiaries = Beneficiary::count('created_at', '>=', Carbon::now()->startOfWeek());
        $legal_entities = LegalEntity::count('created_at', '>=', Carbon::now()->startOfWeek());

        return view('admin.index', [
            'campaigns' => $campaigns,
            'persons' => $persons,
            'donors' => $donors,
            'beneficiaries' => $beneficiaries,
            'legal_entities' => $legal_entities,

        ]);
    }
}
