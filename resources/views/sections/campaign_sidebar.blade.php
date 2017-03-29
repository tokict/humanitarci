<!-- Sidebar -->
<div class="col-sm-4 col-md-3 sidebar pull-right">

    <!-- Widget -->
    <div class="widget">

        <div class="donation-progress-alt font-alt-cased">
            @if(isset($campaign->target_amount))
                <div class="item">{{$campaign->target_amount / 100}} {{env('CURRENCY')}} <p>potrebno</p></div>
            @endif
            <div class="item">{{$campaign->current_funds / 100}} {{env('CURRENCY')}} <p>prikupljeno od
                    <span>{{date("d.m.Y", strtotime($campaign->created_at))}}</span></p>
            </div>

            @if(isset($campaign->target_amount))
                <div class="progress tpl-progress">
                    <div class="progress-bar orange" role="progressbar" aria-valuenow="{{$campaign->percent_done}}"
                         aria-valuemin="0" aria-valuemax="100" style="width: {{$campaign->percent_done}}%;">
                        <span>{{$campaign->percent_done}}%</span>
                    </div>
                </div>
            @endif

            @if(isset($campaign->target_amount))
                <div class="item accent mb-30">{{($campaign->target_amount - $campaign->current_funds)/100}} {{env('CURRENCY')}}
                    <p>još nedostaje</p></div>
            @endif
        </div>


        <div class="row hidden">
            <div class="col-lg-7 col-lg-offset-1">
                <br/>
                <label>Jednokratno</label> <input type="radio" name="donation_type" class="pull-right" value="single"
                                                  checked>
                <br/>
                {{--<label>Mjesečno</label> <input type="radio" name="donation_type" class="pull-right" value="monthly">--}}
            </div>
        </div>
        <span data-url="/{{trans('routes.front.donations')}}/{{trans('routes.actions.create')}}"
              class="btn btn-mod btn-medium btn-circle mb-10 fixedDonation" data-amount="50"
              data-campaign="{{$campaign->id}}">Doniraj 50 kn</span>
        <span data-url="/{{trans('routes.front.donations')}}/{{trans('routes.actions.create')}}"
              class="btn btn-mod btn-medium btn-circle mb-10 fixedDonation" data-amount="100"
              data-campaign="{{$campaign->id}}">Doniraj 100 kn</span>
        <span data-url="/{{trans('routes.front.donations')}}/{{trans('routes.actions.create')}}"
              class="btn btn-mod btn-medium btn-circle mb-10 fixedDonation" data-amount="200"
              data-campaign="{{$campaign->id}}">Doniraj 200 kn</span>
        <span data-url="/{{trans('routes.front.donations')}}/{{trans('routes.actions.create')}}"
              class="btn btn-mod btn-medium btn-circle mb-10 fixedDonation" data-amount="500"
              data-campaign="{{$campaign->id}}">Doniraj 500 kn</span>
        <form>
            <div class="input-group mt-10 mb-10" style="width: 200px">
                <input class="form-control input-circle-left" placeholder="Iznos u kn"
                       aria-describedby="donate-text-btn" id="custom_amount">
                <span class="input-group-addon btn-mod btn-circle-right" id="custom_donation_btn"
                      data-url="/{{trans('routes.front.donations')}}/{{trans('routes.actions.create')}}"
                      data-campaign="{{$campaign->id}}">Doniraj</span>
            </div>
        </form>
        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif
    </div>
    <!-- End Widget -->

    <!-- Widget -->
    <div class="widget mt-50">

        <h5 class="widget-title font-alt">Donirano do sada</h5>

        <div class="widget-body">
            <ul class="clearlist widget-comments">
                @foreach($campaign->donations as $donation)
                    <li>
                        {{$donation->created_at->diffForHumans()}}
                        <br>
                        <span class="iznos-donacije">{{number_format($donation->amount /100, 2)}} {{env('CURRENCY')}}</span>
                        <span class="donator">
                                        @if($donation->donor->user->username)
                                <a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.profile')}}/{{$donation->donor->user->username}}">{{$donation->donor->user->username}}</a>
                            @else
                                Anonimno

                            @endif
                            @if(isset($donation->donor->person->city))
                                ,
                                {{$donation->donor->person->city}}
                            @endif

                        </span>
                    </li>
                @endforeach

            </ul>
        </div>

    </div>
    <!-- End Widget -->

</div>
<!-- End Sidebar -->
