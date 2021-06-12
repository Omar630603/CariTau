@extends('layouts.lecturer')
@section('content')
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
<div class="container">
    <div class="form group">
        <h3 style="text-transform: capitalize;">This page is to add / edit questions for : {{$quiz->quiz_name}} in
            <a href="{{ route('lecturer.materialDetails', $material) }}">{{$material->material_name}}</a> material</h3>

    </div>
    <div style="display: flex">
        <dir class="form group" style="flex: 2; margin-left:-40px;">
            @if (count($questions)>0)
            @foreach ($questions as $question)
            <div
                style="border: 1px solid #cccc; padding: 10px; border-radius: 1%; margin-right: 50px; margin-bottom: 10px">
                <div style="float: right;">
                    <i class="fa fa-ellipsis-h" style="color: #808080; cursor: pointer;" aria-hidden="true"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <div style="cursor: pointer">
                            <a class="dropdown-item" data-toggle="modal"
                                data-target="#filesQuestionModal{{$question->ID_question}}"><i class="fa fa-edit"></i>
                                Edit</a>
                        </div>
                        <div style="cursor: pointer">
                            <a class="dropdown-item"
                                onclick="document.getElementById('deleteQuestion{{$question->ID_question}}').click();"><i
                                    class="fa fa-trash-o"></i> Delete</a>
                        </div>
                    </div>
                </div>
                <a
                    href="{{route('lecturer.addQuestion', ['quiz'=>$quiz,'material'=>$material])}}">{{$question->question}}</a>
                <ul class="list-group list-group-flush">
                    @if ($question->correctAnswer == $question->option_one)
                    <li class="list-group-item">{{$question->option_one}} <i class="fa fa-check"
                            style="color:green"></i>
                    </li>
                    @else
                    <li class="list-group-item">{{$question->option_one}}</li>
                    @endif
                    @if ($question->correctAnswer == $question->option_two)
                    <li class="list-group-item">{{$question->option_two}} <i class="fa fa-check"
                            style="color:green"></i>
                    </li>
                    @else
                    <li class="list-group-item">{{$question->option_two}}</li>
                    @endif
                    @if ($question->correctAnswer == $question->option_three)
                    <li class="list-group-item">{{$question->option_three}} <i class="fa fa-check"
                            style="color:green"></i></li>
                    @else
                    <li class="list-group-item">{{$question->option_three}}</li>
                    @endif
                    @if ($question->correctAnswer == $question->option_four)
                    <li class="list-group-item">{{$question->option_four}} <i class="fa fa-check"
                            style="color:green"></i></li>
                    @else
                    <li class="list-group-item">{{$question->option_four}}</li>
                    @endif
                </ul>
            </div>
            <div style="animation: drop 0.5s" class="modal" id="filesQuestionModal{{$question->ID_question}}"
                tabindex="-1" role="dialog" aria-labelledby="filesQuestionModal{{$question->ID_question}}"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Edit {{$question->question}}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="card">
                                <form action="{{route('lecturer.editQuestion' , $question)}}" method="POST">
                                    @csrf
                                    <div class="card-header">
                                        <div class="form-group">
                                            <label for="question">Question</label>
                                            <input value="{{$question->question}}" class="form-control" type="text"
                                                name="question{{$question->ID_question}}">
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="option_one">First Option</label>
                                            <input value="{{$question->option_one}}" class="form-control" type="text"
                                                name="option_one{{$question->ID_question}}"
                                                id="option_one{{$question->ID_question}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="option_two">Second Option</label>
                                            <input value="{{$question->option_two}}" class="form-control" type="text"
                                                name="option_two{{$question->ID_question}}"
                                                id="option_two{{$question->ID_question}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="option_three">Third Option</label>
                                            <input value="{{$question->option_three}}" class="form-control" type="text"
                                                name="option_three{{$question->ID_question}}"
                                                id="option_three{{$question->ID_question}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="option_four">Forth Option</label>
                                            <input value="{{$question->option_four}}" class="form-control" type="text"
                                                name="option_four{{$question->ID_question}}"
                                                id="option_four{{$question->ID_question}}">
                                        </div>
                                    </div>
                                    <div class="card-header">
                                        <label for="correctAnswer">Correct Answer : click the refresh icon to change the
                                            values of the correct options</label>
                                        <a style="cursor: pointer; float: right"
                                            onclick="questionmodel({{$question->ID_question}})"
                                            id="refresh{{$question->ID_question}}">
                                            <i class="fa fa-refresh" style="color:green"></i>
                                        </a>
                                        <select id="correctAnswer" class="form-control" type="text"
                                            name="correctAnswer{{$question->ID_question}}"
                                            value="{{$question->correctAnswer}}">
                                            <option id="nothing" value="{{$question->correctAnswer}}" selected disabled
                                                hidden>Change the options to
                                                change
                                                the
                                                correct answer : {{$question->correctAnswer}}
                                            </option>
                                            <option id="correctAnswer_option_one{{$question->ID_question}}">
                                                {{$question->option_one}}</option>
                                            <option id="correctAnswer_option_two{{$question->ID_question}}">
                                                {{$question->option_two}}</option>
                                            <option id="correctAnswer_option_three{{$question->ID_question}}">
                                                {{$question->option_three}}</option>
                                            <option id="correctAnswer_option_four{{$question->ID_question}}">
                                                {{$question->option_four}}</option>
                                        </select>
                                    </div>
                                    <center>
                                        <div class="card-header">
                                            <button class="btn btn-dark"
                                                id="js-questionEdit-submit{{$question->ID_question}}">Change</button>
                                        </div>
                                    </center>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"">Close</button>
                                            <button type=" button" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('js-questionEdit-submit{{$question->ID_question}}').click();">Save
                                changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display: none">
                <form action="{{route('lecturer.deleteQuestion', $question)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button id="deleteQuestion{{$question->ID_question}}" type="submit"></button>
                </form>
            </div>
            @endforeach
            @else
            <h3 style="text-transform: capitalize;">This material: {{$material->material_name}} has no questions</h3>
            @endif
        </dir>

        @if (count($questions)<5) <div class="container" style="flex: 1; margin-top: 15px;">
            <div class="row">
                <div class="col-md-12" style="padding-left: 0; padding-right: 0">
                    <div class="card">
                        <form action="{{route('lecturer.postQuestion' , $quiz)}}" method="POST">
                            @csrf
                            <div class="card-header">
                                <div class="form-group">
                                    <label for="question">Question ({{count($questions)}}/5)</label>
                                    <input class="form-control" type="text" name="question">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="option_one">First Option</label>
                                    <input class="form-control" type="text" name="option_one" id="option_one">
                                </div>
                                <div class="form-group">
                                    <label for="option_two">Second Option</label>
                                    <input class="form-control" type="text" name="option_two" id="option_two">
                                </div>
                                <div class="form-group">
                                    <label for="option_three">Third Option</label>
                                    <input class="form-control" type="text" name="option_three" id="option_three">
                                </div>
                                <div class="form-group">
                                    <label for="option_four">Forth Option</label>
                                    <input class="form-control" type="text" name="option_four" id="option_four">
                                </div>
                            </div>
                            <div class="card-header">
                                <label for="correctAnswer">Correct Answer</label>
                                <select id="correctAnswer" class="form-control" type="text" name="correctAnswer">
                                    <option id="nothing" value="" selected disabled hidden>Fill the options to choose
                                        the
                                        correct answer here
                                    </option>
                                    <option id="correctAnswer_option_one"></option>
                                    <option id="correctAnswer_option_two"></option>
                                    <option id="correctAnswer_option_three"></option>
                                    <option id="correctAnswer_option_four"></option>
                                </select>
                            </div>
                            <center>
                                <div class="card-header">
                                    <button class="btn btn-dark">Submit</button>
                                </div>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    @else
    <h3 style="text-transform: capitalize;">You can't add more questions</h3>
    @endif
</div>
</div>
<script>
    $(document).ready(function() {
        $("#option_one").on("change", function(){
        var optionVal = $("#option_one").val();
        var selectOption = $("#correctAnswer_option_one");
        selectOption.val(optionVal);
        document.getElementById("correctAnswer_option_one").text = optionVal;
        });
        $("#option_two").on("change", function(){
        var optionVal = $("#option_two").val();
        var selectOption = $("#correctAnswer_option_two");
        selectOption.val(optionVal);
        document.getElementById("correctAnswer_option_two").text = optionVal;
        }); 
        $("#option_three").on("change", function(){
        var optionVal = $("#option_three").val();
        var selectOption = $("#correctAnswer_option_three");
        selectOption.val(optionVal);
        document.getElementById("correctAnswer_option_three").text = optionVal;
        }); 
        $("#option_four").on("change", function(){
        var optionVal = $("#option_four").val();
        var selectOption = $("#correctAnswer_option_four");
        selectOption.val(optionVal);
        document.getElementById("correctAnswer_option_four").text = optionVal;
        });   
    });
</script>
<script>
    function questionmodel(id) {
        $("#refresh"+id).on("click", function(){
            var optionVal = $("#option_one"+id).val();
            var selectOption = $("#correctAnswer_option_one"+id);
            selectOption.val(optionVal);
            document.getElementById("correctAnswer_option_one"+id).text = optionVal;
            optionVal = $("#option_two"+id).val();
            selectOption = $("#correctAnswer_option_two"+id);
            selectOption.val(optionVal);
            document.getElementById("correctAnswer_option_two"+id).text = optionVal;
            optionVal = $("#option_three"+id).val();
            selectOption = $("#correctAnswer_option_three"+id);
            selectOption.val(optionVal);
            document.getElementById("correctAnswer_option_three"+id).text = optionVal;
            optionVal = $("#option_four"+id).val();
            selectOption = $("#correctAnswer_option_four"+id);
            selectOption.val(optionVal);
            document.getElementById("correctAnswer_option_four"+id).text = optionVal;
        });
    }
</script>
@endsection