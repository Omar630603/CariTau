@extends('layouts.lecturer')
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
                    href="" onclick="$('#imageInput').click(); return false;">Change Picture</a>
                <form method="POST" action="{{route('materialLecturer.restoreImage', $material)}}">
                    @csrf
                    <button type="submit"
                        style="width: 100%; margin-top: 10px; color: white; background-color: rgb(21, 74, 172);"
                        class="btn btn-info">Restore
                        Default</button>
                </form>
                <form method="post" style="display: none; margin-top: 10px"
                    action="{{route('materialLecturer.updateImage', $material)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input id="imageInput" style="border: none" onchange="document.getElementById('upload').click();" type="file"
                        name="image">
                    <input type="submit" style="display: none;" name="upload" id="upload">
                </form>
            </div>
            <form method="post" action="{{route('materialLecturer.update',$material)}}" enctype="multipart/form-data"
                class="card-body" style="padding: 0;">
                @csrf
                <div class="form-group row">
                    <label style="margin-bottom: 0" for="material_name">Material Name:</label>
                    <input class="form-control" name="material_name" type="text"
                        placeholder="{{$material->material_name}}" value="{{$material->material_name}}">
                </div>
                <div class="form-group row">
                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                        <label style="margin-bottom: 0" for="description">Material Description:</label>
                        <div id="copy-icon-material{{$material->ID_material}}" data-toggle="tooltip" title="Copy">
                            <i style="cursor: pointer;"
                                onclick="copyToClipboard('description-copy-material{{$material->ID_material}}')"
                                class="fa fa-copy"></i>
                        </div>
                    </div>
                    <textarea id="description-copy-material{{$material->ID_material}}" rows="5" class="form-control"
                        name="description" type="text" placeholder="{{$material->description}}"
                        value="{{$material->description}}">{{$material->description}}</textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Done</button>
                </div>
            </form>
            @foreach ($courses as $course)
            @if ($course->ID_course == $material->ID_course)
            <form style="display: none" id="deletematerial"
                action="{{route('materialLecturer.delete', $material)}}" method="POST">
                @csrf
                @method('DELETE')
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
        <a data-toggle="modal" data-target="#deleteMaterialModal" class="btn btn-danger">Delete {{$material->material_name}}</a>
            <div class="modal fade" id="deleteMaterialModal" tabindex="-1" role="dialog" aria-labelledby="deleteMaterialModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Delete Material: {{$material->material_name}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading">By Deleteing This Material!</h4>
                                All of The Material Records will be deleted Permanently!<br>
                                Are you sure?
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No, I'm not so sure</button>
                            <button onclick="document.getElementById('deletematerial').submit();" type="button" class="btn btn-danger">Yes,
                                Sure. Delete Material</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div style="display: flex; justify-content: flex-end">
        <h5>This Material has <a
                href="{{ route('lecturer.profile') }}">{{$lecturer->name}}</a>
            as a Lecturer</h5>
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
                                <a href="{{route('lecturer.showFile', $file)}}" target="_blank"
                                    rel="noopener noreferrer">{{$file->file_title}}</a>
                                @else
                                <a href="{{route('lecturer.downloadFiles', $file)}}">{{$file->file_title}}</a>
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
                                        <a class="dropdown-item" href="{{route('lecturer.downloadFiles', $file)}}"><i
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
                                                action="{{route('lecturer.editFiles', ['file'=>$file,'material'=>$material])}}"
                                                class="card-body" style="padding: 0;">
                                                @csrf
                                                <div class="form-group row">
                                                    <label style="margin-bottom: 0" for="file_title">File
                                                        Name:</label>
                                                    <input class="form-control" name="file_title" type="text"
                                                        placeholder="{{$file->file_title}}"
                                                        value="{{$file->file_title}}">
                                                </div>
                                                <div class="form-group row">
                                                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                                        <label style="margin-bottom: 0" for="description">File
                                                            Description:</label>
                                                        <div id="copy-icon-file{{$file->ID_file}}" data-toggle="tooltip"
                                                            title="Copy">
                                                            <i style="cursor: pointer;"
                                                                onclick="copyToClipboard('description-copy-file{{$file->ID_file}}')"
                                                                class="fa fa-copy"></i>
                                                        </div>
                                                    </div>
                                                    <textarea id="description-copy-file{{$file->ID_file}}" rows="3"
                                                        class="form-control" name="description" type="text"
                                                        placeholder="{{$file->description}}"
                                                        value="{{$file->description}}">{{$file->description}}</textarea>
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
                            <form action="{{route('lecturer.deleteFiles', $file)}}"
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
                            @if(count($videos)<1) <a class="btn btn-dark" style="float: right" data-toggle="modal"
                                data-target="#videosModal"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($videos)>0)
                        @foreach ($videos as $video)
                        <div style="display: flex; gap: 5px;">
                            <div style="display: flex; gap: 5px; flex: 1">
                                <img width="20px" height="20px" src="{{ asset('storage/images/video.png') }}" alt="">
                                <a href="{{$video->video_url}}" target="_blank"
                                    rel="noopener noreferrer">{{$video->video_name}}</a>
                            </div>
                            <div style="flex: 0">
                                <i class="fa fa-ellipsis-h" style="color: #808080; cursor: pointer;" aria-hidden="true"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"></i>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <div style="cursor: pointer">
                                        <a class="dropdown-item" data-toggle="modal"
                                            data-target="#filesVideoModal{{$video->ID_video}}"><i
                                                class="fa fa-edit"></i>
                                            Edit</a>
                                    </div>
                                    <div style="cursor: pointer">
                                        <a class="dropdown-item"
                                            onclick="document.getElementById('deleteVideo{{$video->ID_video}}').click();"><i
                                                class="fa fa-trash-o"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="animation: drop 0.5s" class="modal" id="filesVideoModal{{$video->ID_video}}"
                            tabindex="-1" role="dialog" aria-labelledby="filesVideoModal{{$video->ID_video}}"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Edit {{$video->video_name}}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div style="margin: 0 20px">
                                            <form method="post"
                                                action="{{route('lecturer.editVideos', $video)}}"
                                                class="card-body" style="padding: 0;">
                                                @csrf
                                                <div class="form-group row">
                                                    <label style="margin-bottom: 0" for="video_name">Video
                                                        Name:</label>
                                                    <input class="form-control" name="video_name" type="text"
                                                        placeholder="{{$video->video_name}}"
                                                        value="{{$video->video_name}}">
                                                </div>
                                                <div class="form-group row">
                                                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                                        <label style="margin-bottom: 0" for="description">Video
                                                            Description:</label>
                                                        <div id="copy-icon-video{{$video->ID_video}}"
                                                            data-toggle="tooltip" title="Copy">
                                                            <i style="cursor: pointer;"
                                                                onclick="copyToClipboard('description-copy-video{{$video->ID_video}}')"
                                                                class="fa fa-copy"></i>
                                                        </div>
                                                    </div>
                                                    <textarea id="description-copy-video{{$video->ID_video}}" rows="3"
                                                        class="form-control" name="description" type="text"
                                                        placeholder="{{$video->description}}"
                                                        value="{{$video->description}}">{{$video->description}}</textarea>
                                                </div>
                                                <div class="form-group row">
                                                    <label style="margin-bottom: 0" for="video_url">Video
                                                        URL:</label>
                                                    <input class="form-control" name="video_url" type="text"
                                                        placeholder="{{$video->video_url}}"
                                                        value="{{$video->video_url}}">
                                                </div>
                                                <div class="form-group row">
                                                    <button type="submit" id="js-videoEdit-submit"
                                                        class="btn btn-primary">Done</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"">Close</button>
                                                        <button type=" button" class="btn btn-sm btn-primary"
                                            onclick="document.getElementById('js-videoEdit-submit').click();">Save
                                            changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display: none">
                            <form action="{{route('lecturer.deleteVideos', $video)}}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button id="deleteVideo{{$video->ID_video}}" type="submit"></button>
                            </form>
                        </div>
                        @endforeach
                        @else
                        {{ __('Video') }}
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
                            {{ __('Quiz') }}
                            @if(count($quizzes)<1) <a class="btn btn-dark" style="float: right" data-toggle="modal"
                                data-target="#QuizModal"><i class="fa fa-plus" aria-hidden="true" disabled></i></a>
                                @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($quizzes)>0)
                        @foreach ($quizzes as $quiz)
                        <div style="display: flex; gap: 5px;">
                            <div style="display: flex; gap: 5px; flex: 1">
                                <img width="20px" height="20px" src="{{ asset('storage/images/quiz.png') }}" alt="">
                                <a href="{{route('lecturer.addQuestion', ['quiz'=>$quiz,'material'=>$material])}}"
                                    target="_blank" rel="noopener noreferrer">{{$quiz->quiz_name}}
                                    ({{count($questions)}}/5 Questions)</a>
                            </div>
                            <div style="flex: 0">
                                <i class="fa fa-ellipsis-h" style="color: #808080; cursor: pointer;" aria-hidden="true"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"></i>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <div style="cursor: pointer">
                                        <a class="dropdown-item" data-toggle="modal"
                                            data-target="#filesQuizModal{{$quiz->ID_quiz}}"><i class="fa fa-edit"></i>
                                            Edit</a>
                                    </div>
                                    <div style="cursor: pointer">
                                        <a class="dropdown-item"
                                            onclick="document.getElementById('deleteQuiz{{$quiz->ID_quiz}}').click();"><i
                                                class="fa fa-trash-o"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="animation: drop 0.5s" class="modal" id="filesQuizModal{{$quiz->ID_quiz}}"
                            tabindex="-1" role="dialog" aria-labelledby="filesQuizModal{{$quiz->ID_quiz}}"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Edit {{$quiz->quiz_name}}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div style="margin: 0 20px">
                                            <form method="post"
                                                action="{{route('lecturer.editQuiz', $quiz)}}"
                                                class="card-body" style="padding: 0;">
                                                @csrf
                                                <div class="form-group row">
                                                    <label style="margin-bottom: 0" for="quiz_name">Quiz
                                                        Name:</label>
                                                    <input class="form-control" name="quiz_name" type="text"
                                                        placeholder="{{$quiz->quiz_name}}" value="{{$quiz->quiz_name}}">
                                                </div>
                                                <div class="form-group row">
                                                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                                        <label style="margin-bottom: 0" for="description">Quiz
                                                            Description:</label>
                                                        <div id="copy-icon-quiz{{$quiz->ID_quiz}}" data-toggle="tooltip"
                                                            title="Copy">
                                                            <i style="cursor: pointer;"
                                                                onclick="copyToClipboard('description-copy-quiz{{$quiz->ID_quiz}}')"
                                                                class="fa fa-copy"></i>
                                                        </div>
                                                    </div>
                                                    <textarea id="description-copy-quiz{{$quiz->ID_quiz}}" rows="3"
                                                        class="form-control" name="description" type="text"
                                                        placeholder="{{$quiz->description}}"
                                                        value="{{$quiz->description}}">{{$quiz->description}}</textarea>
                                                </div>
                                                <div class="form-group row">
                                                    <button type="submit" id="js-quizEdit-submit"
                                                        class="btn btn-primary">Done</button>
                                                </div>
                                            </form>
                                            @if (count($questions)>=5)
                                            <div class="form-group row" style="float: right; margin-top: -20px">
                                                <a href="{{route('lecturer.addQuestion', ['quiz'=>$quiz,'material'=>$material])}}"
                                                    class="btn btn-sm btn-dark">Edit
                                                    Questions</a>
                                            </div>
                                            <div style="margin-top: 50px">
                                                @foreach ($questions as $question)
                                                <div
                                                    style="border: 1px solid #cccc; padding: 10px; border-radius: 1%; margin-bottom: 10px">
                                                    <a
                                                        href="{{route('lecturer.addQuestion', ['quiz'=>$quiz,'material'=>$material])}}">{{$question->question}}</a>
                                                    <ul class="list-group list-group-flush">
                                                        @if ($question->correctAnswer == $question->option_one)
                                                        <li class="list-group-item">{{$question->option_one}} <i
                                                                class="fa fa-check" style="color:green"></i>
                                                        </li>
                                                        @else
                                                        <li class="list-group-item">{{$question->option_one}}</li>
                                                        @endif
                                                        @if ($question->correctAnswer == $question->option_two)
                                                        <li class="list-group-item">{{$question->option_two}} <i
                                                                class="fa fa-check" style="color:green"></i>
                                                        </li>
                                                        @else
                                                        <li class="list-group-item">{{$question->option_two}}</li>
                                                        @endif
                                                        @if ($question->correctAnswer == $question->option_three)
                                                        <li class="list-group-item">{{$question->option_three}} <i
                                                                class="fa fa-check" style="color:green"></i></li>
                                                        @else
                                                        <li class="list-group-item">{{$question->option_three}}</li>
                                                        @endif
                                                        @if ($question->correctAnswer == $question->option_four)
                                                        <li class="list-group-item">{{$question->option_four}} <i
                                                                class="fa fa-check" style="color:green"></i></li>
                                                        @else
                                                        <li class="list-group-item">{{$question->option_four}}</li>
                                                        @endif
                                                    </ul>
                                                </div>
                                                @endforeach
                                            </div>
                                            @else
                                            <div class="form-group row" style="float: right; margin-top: -20px">
                                                <a href="{{route('lecturer.addQuestion', ['quiz'=>$quiz,'material'=>$material])}}"
                                                    class="btn btn-sm btn-dark" target="_blank"
                                                    rel="noopener noreferrer">Add
                                                    Questions</a>
                                            </div>
                                            <div style="margin-top: 50px">
                                                @foreach ($questions as $question)
                                                <div
                                                    style="border: 1px solid #cccc; padding: 10px; border-radius: 1%; margin-bottom: 10px">
                                                    <a
                                                        href="{{route('lecturer.addQuestion', ['quiz'=>$quiz,'material'=>$material])}}">{{$question->question}}</a>
                                                    <ul class="list-group list-group-flush">
                                                        @if ($question->correctAnswer == $question->option_one)
                                                        <li class="list-group-item">{{$question->option_one}} <i
                                                                class="fa fa-check" style="color:green"></i>
                                                        </li>
                                                        @else
                                                        <li class="list-group-item">{{$question->option_one}}</li>
                                                        @endif
                                                        @if ($question->correctAnswer == $question->option_two)
                                                        <li class="list-group-item">{{$question->option_two}} <i
                                                                class="fa fa-check" style="color:green"></i>
                                                        </li>
                                                        @else
                                                        <li class="list-group-item">{{$question->option_two}}</li>
                                                        @endif
                                                        @if ($question->correctAnswer == $question->option_three)
                                                        <li class="list-group-item">{{$question->option_three}} <i
                                                                class="fa fa-check" style="color:green"></i></li>
                                                        @else
                                                        <li class="list-group-item">{{$question->option_three}}</li>
                                                        @endif
                                                        @if ($question->correctAnswer == $question->option_four)
                                                        <li class="list-group-item">{{$question->option_four}} <i
                                                                class="fa fa-check" style="color:green"></i></li>
                                                        @else
                                                        <li class="list-group-item">{{$question->option_four}}</li>
                                                        @endif
                                                    </ul>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"">Close</button>
                                                        <button type=" button" class="btn btn-sm btn-primary"
                                            onclick="document.getElementById('js-quizEdit-submit').click();">Save
                                            changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display: none">
                            <form action="{{route('lecturer.deleteQuiz', $quiz)}}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button id="deleteQuiz{{$quiz->ID_quiz}}" type="submit"></button>
                            </form>
                        </div>
                        @endforeach
                        @else
                        {{ __('Quiz') }}
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
                            {{ __('Forum') }}
                            <a class="btn btn-dark" style="float: right" data-toggle="modal"
                                data-target="#ForumModal"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(count($forums)>0)
                        @foreach ($forums as $forum)
                        <div style="display: flex; gap: 5px;">
                            <div style="display: flex; gap: 5px; flex: 1">
                                <img width="20px" height="20px" src="{{ asset('storage/images/forum.png') }}" alt="">
                                <a href="{{route('lecturer.showForum', $forum)}}" target="_blank"
                                    rel="noopener noreferrer">{{$forum->title}}</a>
                            </div>
                            <div style="flex: 0">
                                <i class="fa fa-ellipsis-h" style="color: #808080; cursor: pointer;" aria-hidden="true"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false"></i>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <div style="cursor: pointer">
                                        <a class="dropdown-item" data-toggle="modal"
                                            data-target="#filesForumModal{{$forum->ID_forum}}"><i
                                                class="fa fa-edit"></i>
                                            Edit</a>
                                    </div>
                                    <div style="cursor: pointer">
                                        <a class="dropdown-item"
                                            onclick="document.getElementById('deleteForum{{$forum->ID_forum}}').click();"><i
                                                class="fa fa-trash-o"></i> Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="animation: drop 0.5s" class="modal" id="filesForumModal{{$forum->ID_forum}}"
                            tabindex="-1" role="dialog" aria-labelledby="filesForumModal{{$forum->ID_forum}}"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Edit {{$forum->title}}
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div style="margin: 0 20px">
                                            <form method="post"
                                                action="{{route('lecturer.editForum', $forum)}}"
                                                class="card-body" style="padding: 0;">
                                                @csrf
                                                <div class="form-group row">
                                                    <label style="margin-bottom: 0" for="title">Forum
                                                        Title:</label>
                                                    <input class="form-control" name="title" type="text"
                                                        placeholder="{{$forum->title}}" value="{{$forum->title}}">
                                                </div>
                                                <div class="form-group row">
                                                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                                        <label style="margin-bottom: 0" for="description">Quiz
                                                            Description:</label>
                                                        <div id="copy-icon-forum{{$forum->ID_forum}}"
                                                            data-toggle="tooltip" title="Copy">
                                                            <i style="cursor: pointer;"
                                                                onclick="copyToClipboard('description-copy-forum{{$forum->ID_forum}}')"
                                                                class="fa fa-copy"></i>
                                                        </div>
                                                    </div>
                                                    <textarea id="description-copy-forum{{$forum->ID_forum}}" rows="3"
                                                        class="form-control" name="body" type="text"
                                                        placeholder="{{$forum->body}}"
                                                        value="{{$forum->body}}">{{$forum->body}}</textarea>
                                                </div>
                                                <div class="form-group row">
                                                    <button type="submit" id="js-forumEdit-submit"
                                                        class="btn btn-primary">Done</button>
                                                </div>
                                                <div class="form-group row" style="float: right; margin-top: -20px">
                                                    <a href="{{route('lecturer.showForum', $forum)}}"
                                                        class="btn btn-sm btn-dark" target="_blank"
                                                        rel="noopener noreferrer">View Forum</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"">Close</button>
                                                        <button type=" button" class="btn btn-sm btn-primary"
                                            onclick="document.getElementById('js-forumEdit-submit').click();">Save
                                            changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display: none">
                            <form action="{{route('lecturer.deleteForum', $forum)}}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button id="deleteForum{{$forum->ID_forum}}" type="submit"></button>
                            </form>
                        </div>
                        @endforeach
                        @else
                        {{ __('Forum') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="animation: drop 0.5s" class="modal" id="filesModal" tabindex="-1" role="dialog" aria-labelledby="filesModal"
    aria-hidden="true">
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
                            <form action="{{route('lecturer.uploadFiles', $material)}}" method="post"
                                enctype="multipart/form-data" id="js-upload-form">
                                @csrf
                                <div class="form-inline" style="justify-content: space-between; margin: 20px 0">
                                    <div class="form-group">
                                        <input type="file" name="files[]" id="js-upload-files" multiple>
                                    </div>
                                    <button onclick="document.getElementById('js-upload-form').submit();" type="submit"
                                        class="btn btn-sm btn-dark" id="js-upload-submit">Upload
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
                    onclick="document.getElementById('js-upload-form').submit();">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div style="animation: drop 0.5s" class="modal" id="videosModal" tabindex="-1" role="dialog"
    aria-labelledby="videosModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Video</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="{{route('lecturer.addVideos', $material)}}" method="POST" id="addVideosForm">
                        @csrf
                        <div class="form-group">
                            <div class="form-group row">
                                <label style="margin-bottom: 0" for="video_name">Video Name:</label>
                                <input class="form-control" name="video_name" type="text">
                            </div>
                            <div class="form-group row">
                                <label style="margin-bottom: 0" for="description">Description:</label>
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                            <div class="form-group row">
                                <label style="margin-bottom: 0" for="video_url">Video URL:</label>
                                <input class="form-control" name="video_url" type="url">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"">Close</button>
                <button type=" button" class="btn btn-sm btn-primary"
                    onclick="document.getElementById('addVideosForm').submit();">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div style="animation: drop 0.5s" class="modal" id="QuizModal" tabindex="-1" role="dialog" aria-labelledby="QuizModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Quiz</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="{{route('lecturer.addQuiz', $material)}}" method="POST" id="addQuizForm">
                        @csrf
                        <div class="form-group">
                            <div class="form-group row">
                                <label style="margin-bottom: 0" for="quiz_name">Quiz Name:</label>
                                <input class="form-control" name="quiz_name" type="text">
                            </div>
                            <div class="form-group row">
                                <label style="margin-bottom: 0" for="description">Description:</label>
                                <textarea class="form-control" name="description" id="description"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"">Close</button>
                <button type=" button" class="btn btn-sm btn-primary"
                    onclick="document.getElementById('addQuizForm').submit();">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div style="animation: drop 0.5s" class="modal" id="ForumModal" tabindex="-1" role="dialog" aria-labelledby="ForumModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Forum</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form action="{{route('lecturer.addForum', $material)}}" method="POST" id="addForumForm">
                        @csrf
                        <div class="form-group">
                            <div class="form-group row">
                                <label style="margin-bottom: 0" for="title">Forum Title:</label>
                                <input class="form-control" name="title" type="text">
                            </div>
                            <div class="form-group row">
                                <label style="margin-bottom: 0" for="body">Forum Body:</label>
                                <textarea class="form-control" name="body" id="body"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class=" modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"">Close</button>
                <button type=" button" class="btn btn-sm btn-primary"
                    onclick="document.getElementById('addForumForm').submit();">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script>
    function copyToClipboard(id) {
    const str = document.getElementById(id) ;
    var el = document.createElement('textarea');
    el.value = str.placeholder;
    el.setAttribute('readonly', '');
    el.style.display = 'absolute';
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
        uploadInput.files = files
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