<!-- Sidebar -->
<div class="col-sm-4 col-md-3 col-md-offset-1 sidebar pull-right">

    <!-- Widget -->
    <div class="widget">

        <div class="donation-progress-alt font-alt-cased">
            <div class="item">{{$campaign->target_amount}} {{env('CURRENCY')}} <p>potrebno</p></div>
            <div class="item">{{$campaign->current_funds}} {{env('CURRENCY')}} <p>prikupljeno od
                    <span>{{date("d.m.Y", strtotime($campaign->created_at))}}</span></p>
            </div>

            <div class="progress tpl-progress">
                <div class="progress-bar orange" role="progressbar" aria-valuenow="{{$campaign->percent_done}}"
                     aria-valuemin="0" aria-valuemax="100" style="width: {{$campaign->percent_done}}%;">
                    <span>{{$campaign->percent_done}}%</span>
                </div>
            </div>

            <div class="item accent mb-30">{{$campaign->target_amount - $campaign->current_funds}} {{env('CURRENCY')}}
                <p>još nedostaje</p></div>
        </div>


        <div class="row">
            <div class="col-lg-7 col-lg-offset-1">
                <br/>
                <label>Jednokratno</label> <input type="radio" name="donation_type" class="pull-right" value="single" checked>
                <br/>
                <label>Mjesečno</label> <input type="radio" name="donation_type" class="pull-right" value="monthly">
            </div>
        </div>
        <span data-url="/{{trans('routes.front.donations')}}/{{trans('routes.actions.create')}}"
           class="btn btn-mod btn-medium btn-circle mb-10 fixedDonation" data-amount="50" data-campaign="{{$campaign->id}}">Doniraj 50 kn</span>
        <span data-url="/{{trans('routes.front.donations')}}/{{trans('routes.actions.create')}}"
           class="btn btn-mod btn-medium btn-circle mb-10 fixedDonation" data-amount="100" data-campaign="{{$campaign->id}}">Doniraj 100 kn</span>
        <span data-url="/{{trans('routes.front.donations')}}/{{trans('routes.actions.create')}}"
           class="btn btn-mod btn-medium btn-circle mb-10 fixedDonation" data-amount="200" data-campaign="{{$campaign->id}}">Doniraj 200 kn</span>
        <span data-url="/{{trans('routes.front.donations')}}/{{trans('routes.actions.create')}}"
           class="btn btn-mod btn-medium btn-circle mb-10 fixedDonation" data-amount="500" data-campaign="{{$campaign->id}}">Doniraj 500 kn</span>
        <form>
            <div class="input-group mt-10 mb-10" style="width: 200px">
                <input class="form-control input-circle-left" placeholder="Iznos u kn"
                       aria-describedby="donate-text-btn" id="custom_amount">
                <span class="input-group-addon btn-mod btn-circle-right" id="custom_donation_btn" data-url="/{{trans('routes.front.donations')}}/{{trans('routes.actions.create')}}"
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
                <li>
                    prije 15 minuta
                    <br>
                    <span class="iznos-donacije">50 kn</span>
                    <span class="donator">Ankica Tuđman, Zaba</span>
                </li>
                <li>
                    prije 25 minuta
                    <br>
                    <span class="iznos-donacije">100 kn</span>
                    <span class="donator">Gojko Šušak, Mostar</span>
                </li>
                <li>
                    prije sat vremena
                    <br>
                    <span class="iznos-donacije">50 kn</span>
                    <span class="donator">Slavko Linić, Rijeka</span>
                </li>
                <li>
                    prije sat i po
                    <br>
                    <span class="iznos-donacije">500 kn</span>
                    <span class="donator">Miroslav Kutle, Kamensko</span>
                </li>
            </ul>
        </div>

    </div>
    <!-- End Widget -->

</div>
<!-- End Sidebar -->
