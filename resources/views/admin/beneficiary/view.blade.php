@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">


        <div class="row m-b-lg m-t-lg">
            <div class="col-md-6">

                <div class="profile-image">
                    <img src="{{$beneficiary->profile_image->getPath("thumb")}}" class="img-circle circle-border m-b-md"
                         alt="profile">
                </div>
                <div class="profile-info">
                    <div class="">
                        <div>
                            <h2 class="no-margins">
                                {{$beneficiary->name}}
                            </h2>
                            <h4>{{isset($beneficiary->person)?"Person":''}}</h4>
                            <h4>{{isset($beneficiary->group)?"Group":''}}</h4>
                            <h4>{{isset($beneficiary->legalEntity)?"Legal entity":''}}</h4>
                            <small>
                                @if(isset($beneficiary->person))
                                    {{$beneficiary->person->city->name}}, {{$beneficiary->person->city->region->name}}
                                @elseif(isset($beneficiary->legalEntity))
                                    {{$beneficiary->legalEntity->city->name}}
                                    , {{$beneficiary->legalEntity->city->region->name}}
                                @else
                                    @if(isset($beneficiary->person))
                                        {{$beneficiary->group->person->city->name}}
                                        , {{$beneficiary->group->person->city->region->name}}
                                    @else
                                        {{$beneficiary->group->legalEntity->city->name}}
                                        , {{$beneficiary->group->legalEntity->city->region->name}}
                                    @endif
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <table class="table small m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>{{count($beneficiary->getSuccessfulCampaigns())}}</strong> Successful campaigns
                        </td>
                        <td>
                            <strong>{{$beneficiary->donor_number}}</strong> Donors
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <strong>{{count($beneficiary->donations)}}</strong> Donations
                        </td>
                        <td>
                            <strong>{{$beneficiary->getAverageDonation()}} {{env('CURRENCY')}}</strong> Donation average
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>154</strong> Shares
                        </td>
                        <td>
                            <strong>32</strong> Page views
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-3">
                <small>Donations received so far</small>
                <h2 class="no-margins">{{$beneficiary->funds_used}}</h2>
                @if($beneficiary->hasActiveCampaign())
                    <span><i class="fa fa-circle text-navy"></i> Has active campaign</span>
                @else
                    <span><i class="fa fa-circle text-warning"></i> No active campaign</span>
                @endif
                <div id="sparkline1"></div>
            </div>


        </div>
        <div class="row">

            <div class="col-lg-3">

                <div class="ibox">
                    <div class="ibox-content">
                        <h3>About {{$beneficiary->name}}</h3>
                        {{$beneficiary->description}}


                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-content">
                        <h3>Top donors</h3>
                        <p class="small">
                            These are the donors that donated the biggest amounts overall
                        </p>
                        <div class="user-friends">
                            @foreach($beneficiary->getDonors() as $donor)
                                <a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.view')}}/{{$donor->id}}">{{$donor->person->first_name}} {{$donor->person->last_name}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-content">
                        <h3>Personal friends</h3>
                        <ul class="list-unstyled file-list">
                            <li><a href=""><i class="fa fa-file"></i> Project_document.docx</a></li>
                            <li><a href=""><i class="fa fa-file-picture-o"></i> Logo_zender_company.jpg</a></li>
                            <li><a href=""><i class="fa fa-stack-exchange"></i> Email_from_Alex.mln</a></li>
                            <li><a href=""><i class="fa fa-file"></i> Contract_20_11_2014.docx</a></li>
                            <li><a href=""><i class="fa fa-file-powerpoint-o"></i> Presentation.pptx</a></li>
                            <li><a href=""><i class="fa fa-file"></i> 10_08_2015.docx</a></li>
                        </ul>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-content">
                        <h3>Private message</h3>

                        <p class="small">
                            Send private message to Alex Smith
                        </p>

                        <div class="form-group">
                            <label>Subject</label>
                            <input type="email" class="form-control" placeholder="Message subject">
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control" placeholder="Your message" rows="3"></textarea>
                        </div>
                        <button class="btn btn-primary btn-block">Send</button>

                    </div>
                </div>

            </div>

            <div class="col-lg-4 m-b-lg">
                <div id="vertical-timeline" class="vertical-container light-timeline no-margins">
                    <div class="vertical-timeline-block">
                        <div class="vertical-timeline-icon navy-bg">
                            <i class="fa fa-briefcase"></i>
                        </div>

                        <div class="vertical-timeline-content">
                            <h2>Meeting</h2>
                            <p>Conference on the sales results for the previous year. Monica please examine sales trends
                                in marketing and products. Below please find the current status of the sale.
                            </p>
                            <a href="#" class="btn btn-sm btn-primary"> More info</a>
                                    <span class="vertical-date">
                                        Today <br>
                                        <small>Dec 24</small>
                                    </span>
                        </div>
                    </div>

                    <div class="vertical-timeline-block">
                        <div class="vertical-timeline-icon blue-bg">
                            <i class="fa fa-file-text"></i>
                        </div>

                        <div class="vertical-timeline-content">
                            <h2>Send documents to Mike</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since.</p>
                            <a href="#" class="btn btn-sm btn-success"> Download document </a>
                                    <span class="vertical-date">
                                        Today <br>
                                        <small>Dec 24</small>
                                    </span>
                        </div>
                    </div>

                    <div class="vertical-timeline-block">
                        <div class="vertical-timeline-icon lazur-bg">
                            <i class="fa fa-coffee"></i>
                        </div>

                        <div class="vertical-timeline-content">
                            <h2>Coffee Break</h2>
                            <p>Go to shop and find some products. Lorem Ipsum is simply dummy text of the printing and
                                typesetting industry. Lorem Ipsum has been the industry's. </p>
                            <a href="#" class="btn btn-sm btn-info">Read more</a>
                            <span class="vertical-date"> Yesterday <br><small>Dec 23</small></span>
                        </div>
                    </div>

                    <div class="vertical-timeline-block">
                        <div class="vertical-timeline-icon yellow-bg">
                            <i class="fa fa-phone"></i>
                        </div>

                        <div class="vertical-timeline-content">
                            <h2>Phone with Jeronimo</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident
                                rerum aut hic quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste
                                voluptatibus minus veritatis qui ut.</p>
                            <span class="vertical-date">Yesterday <br><small>Dec 23</small></span>
                        </div>
                    </div>

                    <div class="vertical-timeline-block">
                        <div class="vertical-timeline-icon navy-bg">
                            <i class="fa fa-comments"></i>
                        </div>

                        <div class="vertical-timeline-content">
                            <h2>Chat with Monica and Sandra</h2>
                            <p>Web sites still in their infancy. Various versions have evolved over the years, sometimes
                                by accident, sometimes on purpose (injected humour and the like). </p>
                            <span class="vertical-date">Yesterday <br><small>Dec 23</small></span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
