<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\MonetaryOutput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


        $requestRoute = Route::current();
        $routeArray = $requestRoute->getAction();
        $this->action = !empty(Route::current()->parameters()['action']) ? Route::current()->parameters()['action'] : null;
        $controllerAction = class_basename($routeArray['controller']);
        $this->controller = explode('@', $controllerAction)[0];

        $this->page = new \stdClass();
        $this->page->description = env('PROJECT_DESCRIPTION');
        $this->page->title = env('PROJECT_TITLE');
        $this->page->url = env('APP_URL');
        $this->page->image = env('PROJECT_LOGO');


        return view('welcome', [
            'campaigns' => $campaigns,
            'outputs' => $outputs,
            'totalOutputs' => $totalOutputs,
            'totalDonations' => $totalDonations,
            'donations' => $donations,
            'controller' => $this->controller,
            'action' => $this->action,
        ]);
    }
}
