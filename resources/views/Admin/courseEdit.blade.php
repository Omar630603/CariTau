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
        <div id="course_data_edit" style="animation: slideL2R 0.5s;">
            <div style="margin-left: 40px; display: flex; flex-direction: column" class="float-right my-2">
                <div style="margin-top: 14px; text-align: center">
                    <img width="220px" height="220px" style="border-radius: 10%;"
                        src="{{asset('storage/'.$course->image)}}">
                </div>
                <a style="margin-top: 10px; color: white; background-color: rgb(21, 74, 172);" class="btn btn-info"
                    href="" onclick="$('#imageInput').show(); return false;">Change Picture</a>
                <form method="POST" action="{{route('courseAdmin.restoreImage', $course)}}">
                    @csrf
                    <button type="submit"
                        style="width: 100%; margin-top: 10px; color: white; background-color: rgb(21, 74, 172);"
                        class="btn btn-info">Restore
                        Default</button>
                </form>
                <form method="post" style="display: none; margin-top: 10px" id="imageInput"
                    action="{{route('courseAdmin.updateImage', $course)}}" enctype="multipart/form-data">
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
            <form method="post" action="{{route('courseAdmin.update',$course)}}" enctype="multipart/form-data"
                class="card-body" style="padding: 0;">
                @csrf
                <div class="form-group">
                    <label style="margin-bottom: 0" for="major">Change Course Major:</label>
                    <div class="checkbox" data-toggle="tooltip"
                        title="Check the box to change the major and click on the name to view the major!">
                        @foreach ($majors as $major)
                        @if ($major->ID_major == $course->ID_major)
                        <div>
                            <input type="checkbox" id="major{{$major->ID_major}}" name="major"
                                value="{{$major->ID_major}}" onclick="onlyOne(this)" checked>
                            <label style="margin-bottom: 0" for="major{{$major->ID_major}}"><a
                                    href="{{route('admin.major', $major)}}">{{$major->major_name}}</a></label>
                        </div>
                        @else
                        <div>
                            <input type="checkbox" id="major{{$major->ID_major}}" name="major"
                                value="{{$major->ID_major}}" onclick="onlyOne(this)">
                            <label style="margin-bottom: 0" for="major{{$major->ID_major}}"><a
                                    href="{{route('admin.major', $major)}}">{{$major->major_name}}</a></label>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="form-group row">
                    <label style="margin-bottom: 0" for="course_name">Course Name:</label>
                    <input class="form-control" name="course_name" type="text" placeholder="{{$course->course_name}}"
                        value="{{$course->course_name}}">
                </div>
                <div class="form-group row">
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        <label style="margin-bottom: 0" for="description">Course Description:</label>
                        <div id="copy-icon" data-toggle="tooltip" title="Copy">
                            <i style="cursor: pointer;" onclick="copyToClipboard()" class="fa fa-copy"></i>
                        </div>
                    </div>
                    <textarea id="description-copy" rows="3" class="form-control" name="description" type="text"
                        placeholder="{{$course->description}}" value="{{$course->description}}"></textarea>
                </div>
                <div class="form-group row">
                    <label style="margin-bottom: 0" for="price">Course price:</label>
                    <input class="form-control" name="price" type="text" placeholder="{{$course->price}}"
                        value="{{$course->price}}">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Done</button>
                </div>
            </form>
            @foreach ($majors as $major)
            @if ($major->ID_major == $course->ID_major)
            <form style="display: none" action="{{route('courseAdmin.delete', ['course'=>$course,'major'=>$major])}}"
                method="POST">
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
            onclick="$('#open').show('slow'); $('#course_data_edit').slideUp('slow'); $('#close').hide(); return false;">Close</a>
        <a id="open" style="display: none; color: white; background-color: rgb(21, 74, 172);" class="btn btn-info"
            onclick="$('#open').hide(); $('#course_data_edit').slideDown('slow'); $('#close').show('slow'); return false;">
            Edit Course Data</a>
        <a class="btn btn-success" onclick="addUser()">Add New Material</a>
        <a class="btn btn-danger" onclick="document.getElementById('delete').click();">Delete
            {{$course->course_name}}</a>
    </div>
    <div style="display: flex; justify-content: flex-end">
        @if (is_object($lecturer))
        <h5>This Course has <a href="{{ route('admin.userDetails', $lecturer[0]->ID_user) }}">{{$lecturer[0]->name}}</a>
            as a Lecturer</h5>
        @else
        <h5 data-toggle="tooltip" title="Click to add a Lecturer for this course">This Course has <a
                href="{{ route('admin.lecturers') }}">{{$lecturer}}</a>
            as a Lecturer</h5>
        @endif

    </div>
    <div class="AddUserTable" style="display: none; width: 100%" id="addForm">
        <form method="POST" action="{{route('admin.courseAddMaterial', $course)}}">
            @csrf
            <table style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col">Material Name</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Material Name">
                            <input id="course_name" type="text" class="form-control" name="material_name">
                        </td>
                        <td data-label="Description">
                            <textarea rows="5" id="description" class="form-control" name="description"></textarea>
                        </td>
                    </tr>
                    <tr style="align-content: center">
                        <td>
                            <button id="courseLecturerBtn"
                                style="width: 100%; background-color: rgb(21, 74, 172); font-weight: 800; color: white; border:0"
                                type="submit" class="btn btn-primary">Add
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <div style="margin-top: 10px" class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        @foreach ($materials as $material)
        @if ($material->ID_course == $course->ID_course)
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                        href="#collapse{{$material->ID_material}}" aria-expanded="false"
                        aria-controls="collapse{{$material->ID_material}}">
                        {{$material->material_name}}
                    </a>
                </h4>
            </div>
            <div id="collapse{{$material->ID_material}}" class="panel-collapse collapse" role="tabpanel"
                aria-labelledby="heading{{$material->ID_material}}">
                <div class="panel-body">
                    <div class="control-major action-major">
                        <a style="color: white; background-color: rgb(21, 74, 172);" class="btn btn-info"
                            href="{{route('admin.materialDetails', $material)}}">Edit
                            Material Data</a>
                    </div>
                    <div class="control-major">
                        <b>Description</b> : {{$material->description}}<br>
                    </div>
                    <div class="control-major">
                        <b>Files</b> :
                    </div>
                    <div class="control-major">
                        <b>Video</b> :
                    </div>
                    <div class="control-major">
                        <b>Quiz</b> :
                    </div>
                    <div class="control-major">
                        <b>Form</b> :
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
<script>
    function addUser() {
    var x = document.getElementById("addForm");
        if (x.style.display === "none") {
            x.style.display = "";
            x.style="animation: drop 0.5s ease;";
        } else {
            $('#addForm').slideUp();
        }
    }
    function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('major')
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
@endsection