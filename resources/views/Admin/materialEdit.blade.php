@extends('layouts.adminApp')
@section('content')
<div class="container">
    <div>
        @if ($message = Session::get('fail'))
        <div class="alert alert-warning">
            <p>{{ $message }}</p>
        </div>
        @elseif ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
    </div>
    <div>
        <div id="material_data_edit" style="animation: slideL2R 0.5s;">
            <div style="margin-left: 40px; display: flex; flex-direction: column" class="float-right my-2">
                <div style="margin-top: 14px; text-align: center">
                    <img width="220px" height="220px" style="border-radius: 10%;"
                        src="{{asset('storage/'.$material->image)}}">
                </div>
                <a style="margin-top: 10px; color: white; background-color: rgb(21, 74, 172);" class="btn btn-info"
                    href="" onclick="$('#imageInput').show(); return false;">Change Picture</a>
                <form method="POST" action="{{route('materialAdmin.restoreImage', $material)}}">
                    @csrf
                    <button type="submit"
                        style="width: 100%; margin-top: 10px; color: white; background-color: rgb(21, 74, 172);"
                        class="btn btn-info">Restore
                        Default</button>
                </form>
                <form method="post" style="display: none; margin-top: 10px" id="imageInput"
                    action="{{route('materialAdmin.updateImage', $material)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input style="border: none" onchange="document.getElementById('upload').click();" type="file"
                        name="image">
                    <input type="submit" style="display: none;" name="upload" id="upload">
                    <i class="fa fa-close" style="margin-right: 15px; font-size:24px; cursor: pointer;"
                        onclick="$('#imageInput').hide();return false;">
                    </i>
                </form>
            </div>
            <form method="post" action="{{route('materialAdmin.update',$material)}}" enctype="multipart/form-data"
                class="card-body" style="padding: 0;">
                @csrf
                <div class="form-group">
                    <label style="margin-bottom: 0" for="course">Change Material Course:</label>
                    <div class="checkbox" data-toggle="tooltip"
                        title="Check the box to change the course and click on the name to view the course!">
                        @foreach ($courses as $course)
                        @if ($course->ID_course == $material->ID_course)
                        <div>
                            <input type="checkbox" id="course{{$course->ID_course}}" name="course"
                                value="{{$course->ID_course}}" onclick="onlyOne(this)" checked>
                            <label style="margin-bottom: 0" for="course{{$course->ID_course}}"><a
                                    href="{{route('admin.courseDetails', $course)}}">{{$course->course_name}}</a></label>
                        </div>
                        @else
                        <div>
                            <input type="checkbox" id="course{{$course->ID_course}}" name="course"
                                value="{{$course->ID_course}}" onclick="onlyOne(this)">
                            <label style="margin-bottom: 0" for="course{{$course->ID_course}}"><a
                                    href="{{route('admin.courseDetails', $course)}}">{{$course->course_name}}</a></label>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="form-group row">
                    <label style="margin-bottom: 0" for="material_name">Material Name:</label>
                    <input class="form-control" name="material_name" type="text"
                        placeholder="{{$material->material_name}}" value="{{$material->material_name}}">
                </div>
                <div class="form-group row">
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        <label style="margin-bottom: 0" for="description">Material Description:</label>
                        <div id="copy-icon" data-toggle="tooltip" title="Copy">
                            <i style="cursor: pointer;" onclick="copyToClipboard()" class="fa fa-copy"></i>
                        </div>
                    </div>
                    <textarea id="description-copy" rows="3" class="form-control" name="description" type="text"
                        placeholder="{{$material->description}}" value="{{$material->description}}"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Done</button>
                </div>
            </form>
            @foreach ($courses as $course)
            @if ($course->ID_course == $material->ID_course)
            <form style="display: none"
                action="{{route('materialAdmin.delete', ['material'=>$material,'course'=>$course])}}" method="POST">
                @csrf
                @method('DELETE')
                <button id="delete" type="submit"></button>
            </form>
            @endif
            @endforeach
        </div>
    </div>
    <div class="form-group">
        <a id="close" style="color: white; background-color: rgb(21, 74, 172);" class="btn btn-info"
            onclick="$('#open').show('slow'); $('#material_data_edit').slideUp('slow'); $('#close').hide(); return false;">Close</a>
        <a id="open" style="display: none; color: white; background-color: rgb(21, 74, 172);" class="btn btn-info"
            onclick="$('#open').hide(); $('#material_data_edit').slideDown('slow'); $('#close').show('slow'); return false;">
            Edit Material Data</a>
        <a class="btn btn-danger" onclick="document.getElementById('delete').click();">Delete
            {{$material->material_name}}</a>
    </div>
    <div style="display: flex; justify-content: flex-end">
        @if (is_object($lecturer))
        <h5>This Material has <a
                href="{{ route('admin.userDetails', $lecturer[0]->ID_user) }}">{{$lecturer[0]->name}}</a>
            as a Lecturer</h5>
        @else
        <h5 data-toggle="tooltip" title="Click to add a Lecturer for this course">This Material has <a
                href="{{ route('admin.lecturers') }}">{{$lecturer}}</a>
            as a Lecturer</h5>
        @endif
    </div>
</div>

<div class="container centerMaterial" style="display: flex; gap: 10px; margin-top: 10px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="padding-left: 0; padding-right: 0">
                <div class="card">
                    <div class="card-header">
                        <div style="font-weight: 1000; vertical-align: text-bottom; line-height: 200%;">
                            {{ __('Files') }}
                            <button class="btn btn-dark" style="float: right" data-toggle="modal"
                                data-target="#filesModal"><i class="fa fa-plus" aria-hidden="true"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($files)>0)
                        @foreach ($files as $file)
                        <div style="display: flex; gap: 5px;">
                            <div style="display: flex; gap: 5px; flex: 1">
                                <img width="20px" height="20px" src="{{ asset('storage/'.$file->icon) }}" alt="">
                                @if ($file->file_extension === 'pdf' || $file->file_extension === 'jpeg'||
                                $file->file_extension === 'png'|| $file->file_extension === 'jpg')
                                <a href="{{route('admin.showFile', $file)}}" target="_blank"
                                    rel="noopener noreferrer">{{$file->file_title}}</a>
                                @else
                                <a href="{{route('admin.downloadFiles', $file)}}">{{$file->file_title}}</a>
                                @endif
                            </div>
                            <div style="flex: 0">
                                <i class="fa fa-ellipsis-h" style="color: #808080; cursor: pointer;" aria-hidden="true"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"></i>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <div style="cursor: pointer">
                                        <a class="dropdown-item" data-toggle="modal"
                                            data-target="#filesEditModal{{$file->ID_file}}"><i class="fa fa-edit"></i>
                                            Edit</a>
                                    </div>
                                    <div style="cursor: pointer">
                                        <a class="dropdown-item"
                                            onclick="document.getElementById('deleteFiles{{$file->ID_file}}').click();"><i
                                                class="fa fa-trash-o"></i> Delete</a>
                                    </div>
                                    <div style="cursor: pointer">
                                        <a class="dropdown-item" href="{{route('admin.downloadFiles', $file)}}"><i
                                                class="fa fa-download"></i> Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="animation: drop 0.5s" class="modal" id="filesEditModal{{$file->ID_file}}"
                            tabindex="-1" role="dialog" aria-labelledby="filesEditModal{{$file->ID_file}}"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Edit {{$file->file_title}}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div style="margin: 0 20px">
                                            <form method="post"
                                                action="{{route('admin.editFiles', ['file'=>$file,'material'=>$material])}}"
                                                class="card-body" style="padding: 0;">
                                                @csrf
                                                <div class="form-group row">
                                                    <label style="margin-bottom: 0" for="material_name">File
                                                        Name:</label>
                                                    <input class="form-control" name="file_title" type="text"
                                                        placeholder="{{$file->file_title}}"
                                                        value="{{$file->file_title}}">
                                                </div>
                                                <div class="form-group row">
                                                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                                        <label style="margin-bottom: 0" for="description">File
                                                            Description:</label>
                                                        <div id="copy-icon" data-toggle="tooltip" title="Copy">
                                                            <i style="cursor: pointer;" onclick="copyToClipboard()"
                                                                class="fa fa-copy"></i>
                                                        </div>
                                                    </div>
                                                    <textarea id="description-copy" rows="3" class="form-control"
                                                        name="description" type="text"
                                                        placeholder="{{$file->description}}"
                                                        value="{{$file->description}}"></textarea>
                                                </div>
                                                <div class="form-group row">
                                                    <button type="submit" id="js-fileEdit-submit"
                                                        class="btn btn-primary">Done</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"">Close</button>
                                                        <button type=" button" class="btn btn-sm btn-primary"
                                            onclick="document.getElementById('js-fileEdit-submit').click();">Save
                                            changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display: none">
                            <form action="{{route('admin.deleteFiles', ['file'=>$file,'material'=>$material])}}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button id="deleteFiles{{$file->ID_file}}" type="submit"></button>
                            </form>
                        </div>
                        @endforeach
                        @else
                        {{ __('Files') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="padding-left: 0; padding-right: 0">
                <div class="card">
                    <div class="card-header">
                        <div style="font-weight: 1000; vertical-align: text-bottom; line-height: 200%;">
                            {{ __('Video') }}
                            <a class="btn btn-dark" style="float: right"><i class="fa fa-plus"
                                    aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="card-body">

                        {{ __('Video') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="padding-left: 0; padding-right: 0">
                <div class="card">
                    <div class="card-header">
                        <div style="font-weight: 1000; vertical-align: text-bottom; line-height: 200%;">
                            {{ __('Quiz') }}
                            <a class="btn btn-dark" style="float: right"><i class="fa fa-plus"
                                    aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="card-body">

                        {{ __('Quiz') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="padding-left: 0; padding-right: 0">
                <div class="card">
                    <div class="card-header">
                        <div style="font-weight: 1000; vertical-align: text-bottom; line-height: 200%;">
                            {{ __('Form') }}
                            <a class="btn btn-dark" style="float: right"><i class="fa fa-plus"
                                    aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="card-body">

                        {{ __('Form') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="animation: drop 0.5s" class="modal" id="filesModal" tabindex="-1" role="dialog"
    aria-labelledby="filesEditModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Upload Files</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="panel panel-default">
                        <div class="panel-body" style="border: none">
                            <h4>Select files from your computer</h4>
                            <form action="{{route('admin.uploadFiles', $material)}}" method="post"
                                enctype="multipart/form-data" id="js-upload-form">
                                @csrf
                                <div class="form-inline" style="justify-content: space-between; margin: 20px 0">
                                    <div class="form-group">
                                        <input type="file" name="files[]" id="js-upload-files" multiple>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-dark" id="js-upload-submit">Upload
                                        files</button>
                                </div>
                            </form>
                            <h4>Or drag and drop files below</h4>
                            <div class="upload-drop-zone" id="drop-zone">
                                Just drag and drop files here
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"">Close</button>
                <button type=" button" class="btn btn-sm btn-primary"
                    onclick="document.getElementById('js-upload-submit').click();">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script>
    function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('course')
    checkboxes.forEach((item) => {
        if (item !== checkbox) item.checked = false
    })
    }
    function copyToClipboard() {
    const str = document.getElementById('description-copy').placeholder ;
    const el = document.createElement('textarea');
    el.value = str;
    el.setAttribute('readonly', '');
    el.style.position = 'absolute';
    el.style.left = '-9999px';
    document.body.appendChild(el);
    el.select();
    document.execCommand('copy');
    document.body.removeChild(el);
    }
</script>
<script>
    + function($) {
    'use strict';
    var dropZone = document.getElementById('drop-zone');
    var uploadForm = document.getElementById('js-upload-form');
    var uploadInput = document.getElementById('js-upload-files');
    var startUpload = function(files) {
        console.log(files)
        uploadInput.files = files
        console.log(uploadInput.files.length)
        uploadForm.submit()
    }
    uploadForm.addEventListener('submit', function(e) {
        var uploadFiles = document.getElementById('js-upload-files').files;
        e.preventDefault()
        startUpload(uploadFiles)
    })
    dropZone.ondrop = function(e) {
        e.preventDefault();
        this.className = 'upload-drop-zone';
        startUpload(e.dataTransfer.files)
    }
    dropZone.ondragover = function() {
        this.className = 'upload-drop-zone drop';
        return false;
    }
    dropZone.ondragleave = function() {
        this.className = 'upload-drop-zone';
        return false;
    }
    }(jQuery);
</script>
@endsection