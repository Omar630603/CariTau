@extends('layouts.lecturer')
@section('content')
</div>
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
                    href="" onclick="$('#imageInput').click(); return false;">Change Picture</a>
                <form method="POST" action="{{route('courseLecturer.restoreImage', $course)}}">
                    @csrf
                    <button type="submit"
                        style="width: 100%; margin-top: 10px; color: white; background-color: rgb(21, 74, 172);"
                        class="btn btn-info">Restore
                        Default</button>
                </form>
                <form method="post" style="display: none; margin-top: 10px"
                    action="{{route('courseLecturer.updateImage', $course)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input id="imageInput" style="border: none" onchange="document.getElementById('upload').click();"
                        type="file" name="image">
                    <input type="submit" style="display: none;" name="upload" id="upload">
                </form>
            </div>
            <form method="post" action="{{route('courseLecturer.update',$course)}}" enctype="multipart/form-data"
                class="card-body" style="padding: 0;">
                @csrf
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
                    <textarea id="description-copy" rows="5" class="form-control" name="description" type="text"
                        placeholder="{{$course->description}}"
                        value="{{$course->description}}">{{$course->description}}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Done</button>
                </div>
            </form>
        </div>
    </div>
    <div class="form-group">
        <a id="close" style="color: white; background-color: rgb(21, 74, 172);" class="btn btn-info"
            onclick="$('#open').show('slow'); $('#course_data_edit').slideUp('slow'); $('#close').hide(); return false;">Close</a>
        <a id="open" style="display: none; color: white; background-color: rgb(21, 74, 172);" class="btn btn-info"
            onclick="$('#open').hide(); $('#course_data_edit').slideDown('slow'); $('#close').show('slow'); return false;">
            Edit Course Data</a>
        <a class="btn btn-success" onclick="addUser()">Add New Material</a>
    </div>
    <div style="display: flex; justify-content: flex-end; margin-top: 30px">
        <h5>This Course has <a href="{{ route('lecturer.profile') }}">{{$lecturer->name}}</a>
            as a Lecturer</h5>
    </div>
    <div class="AddUserTable" style="display: none; width: 100%" id="addForm">
        <form method="POST" action="{{route('lecturer.courseAddMaterial', $course)}}">
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
    @if (count($materials)>0)
    <div style="display: flex; justify-content:space-between ; flex-wrap: wrap; margin-top: 10px" class="panel-group"
        id="accordion" role="tablist" aria-multiselectable="true">
        <div class="materialsListAccordion">
            @foreach ($materials as $material)
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo" style="border-radius:20px;">
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
                                href="{{route('lecturer.materialDetails', $material)}}">Edit
                                Material Data</a>
                            <a href="{{route('lecturer.materialDetails', $material)}}"><img width="50px" height="50px"
                                    style="margin-top: 10px; border-radius: 10%;"
                                    src="{{asset('storage/'.$material->image)}}"></a>
                        </div>
                        <div class="control-major">
                            <b>Description</b> : {{$material->description}}<br>
                        </div>
                        <div class="control-major">
                            <b>Click on <q><i> Edit
                                        Material Data</i></q> to Change {{$material->material_name}} Files, Video, Quiz,
                                and
                                Forum</b>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="materialsList">
            <div class="col-sm-4 mb-3" style="max-width: none">
                <div class="card h-100" style="border-radius:20px;">
                    <div class="card-body">
                        <h6 class="d-flex materialsListHeader">
                            <i class="material-icons text-info mr-2"></i>Materials List: Change the order of
                            {{$course->course_name}} materials
                            <a style="cursor: pointer;" data-toggle="tooltip" title="Click to change the order"
                                onclick="$('#formChangeOrder').submit();">
                                <i class="fa fa-refresh" style="color:green"></i>
                            </a>
                        </h6>
                        <form action="{{route('lecturer.SortMaterials', $materials[0])}}" method="POST"
                            id="formChangeOrder">
                            @csrf
                            @foreach ($materials as $material)
                            <div style="display: flex; justify-content: space-between">
                                <strong style="margin-top: 5px">#{{$material->order}}</strong>
                                <a href="{{route('lecturer.materialDetails', $material)}}"
                                    style="text-decoration: none">
                                    <p class="materialName">
                                        {{ $material->material_name }}
                                    </p>
                                </a>
                                <input hidden name="ID_material{{$material->ID_material}}"
                                    value="{{$material->ID_material}}">
                                <input min="1" class="mt-auto inputOrder" name="order{{$material->ID_material}}"
                                    type="number" value="{{$material->order}}">
                            </div>
                            <br>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="container" style="margin-top: 10px">
        <div class="justify-content-center">
            <center>
                <h5 class="card-title">There are no materials yet!</h5>
            </center>
        </div>
    </div>
    @endif
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