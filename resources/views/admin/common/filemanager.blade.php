@extends('layouts.minimal')
@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="file-manager">
                            <h5>Show:</h5>
                            <a href="#" class="file-control active" onclick="filemanager.filter('all')">All</a>
                            <a href="#" class="file-control" onclick="filemanager.filter('documents')">Documents</a>
                            <a href="#" class="file-control" onclick="filemanager.filter('video')">Video</a>
                            <a href="#" class="file-control" onclick="filemanager.filter('images')">Images</a>
                            <div class="hr-line-dashed"></div>
                            <button class="btn btn-primary btn-block" type="button" onclick="$('#fileUpload').click()">Upload Files</button>

                            <input type="file"  class="hidden" accept="image/jpeg;image/png;application/*" name="files[]" data-url="/admin/file/upload/{{$active}}"
                                   multiple id="fileUpload"/>


                            <div class="progress progress-striped">
                                <div style="width: 0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="0" role="progressbar" class="progress-bar progress-bar-warning">
                                    <span class="sr-only">0% Complete</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <h5>Folders</h5>
                            <ul class="folder-list" style="padding: 0">
                                @foreach($folders as $name =>  $items)
                                    <li onclick="filemanager.openFolder('{{$name}}')"
                                        class="{{$name==$active?'active':''}}">
                                        <a href="#"><i class="fa fa-folder"></i> {{ucfirst($name)}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        @foreach($folders[$active] as $item)
                            <div class="file-box">
                                <div class="file">
                                    <a href="#">
                                        <span class="corner"></span>

                                        <div class="{{$item->type == 'image'?'image':'icon'}}">
                                            @if($item->type == 'image')
                                                <img alt="image" class="img-responsive" src="{{$item->getPath()}}">
                                            @else
                                                <i class="fa fa-file"></i>
                                            @endif

                                        </div>
                                        <div class="file-name">
                                            {{$item->name}}
                                            <br/>
                                            <small>Added: {{$item->created_at}}</small>
                                        </div>
                                    </a>

                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection