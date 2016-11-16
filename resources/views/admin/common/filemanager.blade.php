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
                            <button class="btn btn-primary btn-block" type="button" id="uploadButton">
                                Upload Files
                            </button>

                            <input type="file" class="hidden" accept="image/jpeg;image/png;application/*" name="files[]"
                                   data-url="/admin/file/adminUpload/{{$active}}"
                                   multiple id="fileUpload"/>


                            <div class="progress progress-striped" id="progress">
                                <div style="width: 0%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="0"
                                     role="progressbar" class="progress-bar progress-bar-warning">
                                    <span class="sr-only">0% Complete</span>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <h5>Folders</h5>
                            <ul class="folder-list" style="padding: 0">
                                @foreach($folders as $name =>  $items)
                                    <li onclick="filemanager.openFolder('{{$name}}')"
                                        class="{{$name==$active?'active':''}}">
                                        <a href="#">&nbsp;<i class="fa fa-folder"></i> {{ucfirst($name)}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <br/><br/>
                            <button class="btn btn-primary btn-lg pull-right hidden" id="selectDoneButton">Select files</button>
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
                                <div class="file" id="img_{{$item->id}}">
                                    <a href="#">
                                        <span class="corner"></span>

                                        <div class="{{$item->type == 'image'?'image':'icon'}}">
                                            @if($item->type == 'image')
                                                <img alt="image" class="img-responsive" src="{{$item->getPath('small')}}">
                                            @else
                                                <i class="fa fa-file"></i>
                                            @endif

                                        </div>
                                        <div class="file-name">
                                            <span class="file_title_current" id="title_{{$item->id}}">{{$item->title}}</span>
                                            <input type="text" value="{{$item->title}}"
                                                   class="hidden form-control file_title">
                                            <br/>
                                            <small class="file_description_current">{{$item->description}}</small>
                                            <textarea
                                                    class="form-control hidden file_description">{{$item->description}}</textarea>
                                            <br/>
                                            <small>Added: {{$item->created_at}}</small>
                                            <div class="controls1"><br>
                                                <small><i class="fa fa-edit pointer"
                                                          onclick="filemanager.editImage('{{$item->id}}')"></i> &nbsp;
                                                </small>
                                                <small><a href="{{$item->getPath('original')}}" target="_blank"
                                                          class="fa fa-eye pointer"></a> &nbsp;</small>
                                                @if(count($item->links) == 0)
                                                    <small class="pull-right pointer"
                                                           onclick="filemanager.deleteImage('{{$item->id}}')"><i
                                                                class="fa fa-close"></i> &nbsp;</small>
                                                @else
                                                    <small class="pull-right">In use</small>
                                                @endif
                                            </div>
                                            <div class="hidden controls2">
                                                <button class="btn btn-xs btn-success"
                                                        onclick="filemanager.saveEditImage('{{$item->id}}')">Save
                                                </button>
                                                <button class="btn btn-xs btn-warning"
                                                        onclick="filemanager.cancelEditImage('{{$item->id}}')">Cancel
                                                </button>
                                            </div>
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