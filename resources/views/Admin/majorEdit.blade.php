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
        <div id="mjor_data_edit" style="animation: slideL2R 0.5s;">
            <div style="margin-left: 40px; display: flex; flex-direction: column" class="float-right my-2">
                <div style="text-align: center">
                    <img width="220px" height="220px" style="border-radius: 10%;"
                        src="{{asset('storage/'.$major->image)}}">
                </div>
                <a style="margin-top: 10px; color: white; background-color: rgb(21, 74, 172);" class="btn btn-info"
                    href="" onclick="$('#imageInput').click(); return false;">Change Picture</a>
                <form method="POST" action="{{route('majorAdmin.restoreImage', $major)}}">
                    @csrf
                    <button type="submit"
                        style="width: 100%; margin-top: 10px; color: white; background-color: rgb(21, 74, 172);"
                        class="btn btn-info">Restore
                        Default</button>
                </form>
                <form method="post" style="display: none; margin-top: 10px"
                    action="{{route('majorAdmin.updateImage', $major)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input id="imageInput" style="border: none" onchange="document.getElementById('upload').click();" type="file"
                        name="image">
                    <input type="submit" style="display: none;" name="upload" id="upload">
                </form>
            </div>
            <form method="post" action="{{route('majorAdmin.update', $major)}}" enctype="multipart/form-data"
                class="card-body" style="padding: 0;">
                @csrf
                <div class="form-group row">
                    <label style="margin-bottom: 0" for="major_name">Major Name:</label>
                    <input style="margin-bottom: 1rem" class="form-control" name="major_name" type="text"
                        placeholder="{{$major->major_name}}" value="{{$major->major_name}}">
                </div>
                <div class="form-group row">
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        <label style="margin-bottom: 0" for="description">Major Description:</label>
                        <div id="copy-icon" data-toggle="tooltip" title="Copy">
                            <i style="cursor: pointer;" onclick="copyToClipboard()" class="fa fa-copy"></i>
                        </div>
                    </div>
                    <textarea id="description-copy" rows="9" class="form-control" name="description" type="text"
                        placeholder="{{$major->description}}" value="{{$major->description}}">{{$major->description}}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Done</button>
                </div>
            </form>
            <form style="display: none" action="{{ route('majorAdmin.delete', $major) }}" method="POST">
                @csrf
                @method('DELETE')
                <button id="delete" type="submit"></button>
            </form>
        </div>
    </div>
    <div class="form-group">
        <a id="close" style="color: white; background-color: rgb(21, 74, 172);" class="btn btn-info"
            onclick="$('#open').show('slow'); $('#mjor_data_edit').slideUp('slow'); $('#close').hide(); return false;">Close</a>
        <a id="open" style="display: none; color: white; background-color: rgb(21, 74, 172);" class="btn btn-info"
            onclick="$('#open').hide(); $('#mjor_data_edit').slideDown('slow'); $('#close').show('slow'); return false;">
            Edit Major Data</a>
        <a class="btn btn-success" onclick="addUser()">Add New Course</a>
        <a class="btn btn-danger" onclick="document.getElementById('delete').click();">Delete {{$major->major_name}}</a>
    </div>
    <div class="AddUserTable" style="display: none; width: 100%" id="addForm">
        <form method="POST" action="{{ route('admin.majorAddCourse', $major) }}">
            @csrf
            <table style="width: 100%">
                <thead>
                    <tr>
                        <th scope="col">Course Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Course Name">
                            <input id="course_name" type="text" class="form-control" name="course_name">
                        </td>
                        <td data-label="Description">
                            <textarea rows="5" id="description" class="form-control" name="description"></textarea>
                        </td>
                        <td data-label="price">
                            <input id="price" type="text" class="form-control" name="price">
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
    <div style="margin-top: 50px" class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        @foreach ($courses as $course)
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                        href="#collapse{{$course->ID_course}}" aria-expanded="false"
                        aria-controls="collapse{{$course->ID_course}}">
                        {{$course->course_name}}
                    </a>
                </h4>
            </div>
            <div id="collapse{{$course->ID_course}}" class="panel-collapse collapse show" role="tabpanel"
                aria-labelledby="heading{{$course->ID_course}}">
                <div class="panel-body">
                    <div class="control-major action-major">
                        <a class="btn btn-dark" href="{{ route('admin.courseDetails', $course) }}">Edit
                            {{$course->course_name}}: Course Data</a>
                        <a href="{{route('admin.courseDetails', $course)}}"><img width="50px" height="50px"
                                style="margin-top: 10px; border-radius: 10%;"
                                src="{{asset('storage/'.$course->image)}}"></a>
                    </div>
                    <div class="control-major">
                        <b>Lecturer:
                            @foreach ($lecturers as $lecturer)
                            @if ($lecturer->ID_course == $course->ID_course)
                            <a href="{{ route('admin.userDetails', $lecturer->ID_user) }}">
                                {{$lecturer->name}}
                            </a></b>
                        @endif
                        @endforeach
                    </div>
                    <div class="control-major">
                        <b>Description</b>:<br>{{$course->description}}<br>
                    </div>
                    <div class="control-major">
                        @php $no = 1; @endphp
                        @foreach ($materials as $material)
                        @if ($material->ID_course == $course->ID_course)
                        <b>Material - {{$no ++}}: <a
                                href="{{route('admin.materialDetails', $material)}}">{{$material->material_name}}</a></b><br>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
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