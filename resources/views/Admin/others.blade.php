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
</div>
<div class="" style="display: flex;flex-wrap:wrap; justify-content: space-evenly; flex-direction: row-reverse">
    <div class="col-md-9 mt-4">
        <div class="card" style="border-radius:20px;">
            <div class="card-body" style="border-radius:20px;">
                {{-- Transactions --}}
                <div class="table-responsive custom-table-responsive">
                    <div class="container float-right m-2">
                        <h4>List of Transactions</h4>
                    </div>
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Student</th>
                                <th scope="col">Course</th>
                                <th scope="col">Bank</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Proof</th>
                                <th scope="col">Approval</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 0 ;
                            @endphp
                            @if (count($transactions)>0)
                            @foreach ($transactions as $transaction)
                            <tr scope="row">
                                <th scope="row">
                                    @php
                                    $no++
                                    @endphp
                                    {{$no}}
                                </th>
                                <td><a data-toggle="tooltip" title="Student, click to view" href="{{ route('admin.userDetails', ['user'=>$transaction->ID_user]) }}">{{$transaction->ID_user}}</a></td>
                                <td><a data-toggle="tooltip" title="Course, click to view" href="{{ route('admin.courseDetails', ['course'=>$transaction->ID_course]) }}">{{$transaction->ID_course}}</a></td>
                                <td>
                                    @foreach ($banks as $bank)
                                    @if ($bank->ID_bank==$transaction->ID_bank)
                                        {{$bank->bank_name}} - {{$bank->no_account}}
                                    @endif
                                    @endforeach
                                </td>
                                <td>Rp.{{$transaction->transaction}}</td>
                                <td><a data-toggle="tooltip" title="Proof, click to view" target="_blank" rel="noopener noreferrer" href="{{ asset('storage/'.$transaction->proof) }}">IMG#{{$no}}</a></td>
                                <td style="text-align: center;">
                                    @if ($transaction->approve == 0)
                                    <p style="margin-top: 2px" class="btn-sm btn-secondary">Pending</p>
                                    @elseif($transaction->approve == 1)
                                    <p style="margin-top: 2px" class="btn-sm btn-success">Approved</p>
                                    @elseif($transaction->approve == 2)
                                    <p style="margin-top: 2px" class="btn-sm btn-danger">Disapproved</p>
                                    @endif
                                </td>
                                <td style="display: flex; gap: 5px; justify-content: space-between">
                                    @if ($transaction->approve == 0)
                                    <a data-toggle="modal" data-target="#ApproveTransaction{{$transaction->ID_transaction}}"
                                        class="btn btn-sm btn-outline-success" style="width: 100%">Approve</a>
                                    <a data-toggle="modal" data-target="#DisapproveTransaction{{$transaction->ID_transaction}}"
                                        class="btn btn-sm btn-warning" style="width: 100%">Disapprove</a>
                                    @elseif($transaction->approve == 1)
                                    <a data-toggle="modal" data-target="#PendingTransaction{{$transaction->ID_transaction}}"
                                        class="btn btn-sm btn-outline-dark" style="width: 100%">Pend</a>
                                    <a data-toggle="modal" data-target="#DisapproveTransaction{{$transaction->ID_transaction}}"
                                        class="btn btn-sm btn-warning" style="width: 100%">Disapprove</a>
                                    @elseif($transaction->approve == 2)
                                    <a data-toggle="modal" data-target="#PendingTransaction{{$transaction->ID_transaction}}" 
                                        class="btn btn-sm btn-outline-dark" style="width: 100%">Pend</a>
                                    <a data-toggle="modal" data-target="#ApproveTransaction{{$transaction->ID_transaction}}"
                                        class="btn btn-sm btn-outline-success" style="width: 100%">Approve</a>
                                    @endif
                                    <a onclick="document.getElementById('deleteTransaction{{$transaction->ID_transaction}}').submit();" 
                                        class="btn btn-sm btn-outline-danger" style="width: 100%">Delete</a>
                                </td>
                                <div class="modal fade" id="ApproveTransaction{{$transaction->ID_transaction}}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="ApproveTransaction{{$transaction->ID_transaction}}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Approve Transaction #{{$no}} - transaction
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div style="margin: 0 20px">
                                                    <form method="post" action="{{ route('admin.approve')}}"
                                                        class="card-body" style="padding: 0;">
                                                        @csrf
                                                        <div class="row">
                                                            <div style="width: 100%" class="alert-info p-2 mb-2" for="emailing">
                                                                <input type="checkbox" name="emailing" onchange="$('#emailTextApp{{$transaction->ID_transaction}}').toggle('fast');$('#statusApp{{$transaction->ID_transaction}}').prop('checked', true);">
                                                                Notify Student to Their Email About The Approval<br>
                                                                <small>Student Won't be Notified, If You Don't Check the Box</small>
                                                            </div>
                                                            <textarea class="form-control mb-2" name="emailText" id="emailTextApp{{$transaction->ID_transaction}}" 
                                                            style="display: none" name="emailText" cols="30" rows="5"
                                                            placeholder="Write a message to student *Optional"></textarea>
                                                        </div>
                                                        <div class="row">
                                                            <div style="width: 100%" class="alert-info p-2 mb-2" for="statusApp{{$transaction->ID_transaction}}">
                                                                <input checked type="checkbox" name="status" id="statusApp{{$transaction->ID_transaction}}">
                                                                Change Course to Full Access for the Student<br>
                                                                <small>Student Won't Get Full Access, If You Don't Check the Box</small>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div style="width: 100%" class="alert-info p-2 mb-2" for="balance">
                                                                <input type="checkbox" name="balance">
                                                                Add The Transaction to The Bank Balance<br>
                                                                <small>Transaction Won't be Added to The Bank Balance, If You Don't Check the Box</small>
                                                            </div>
                                                        </div>
                                                        <input hidden type="text" name="ID_bank" value="{{$transaction->ID_bank}}">
                                                        <input hidden type="text" name="ID_user" value="{{$transaction->ID_user}}">
                                                        <input hidden type="text" name="ID_course" value="{{$transaction->ID_course}}">
                                                        <input hidden type="text" name="ID_transaction" value="{{$transaction->ID_transaction}}">
                                                        <button style="display: none" type="submit" id="js-transactionApprove-submit{{$transaction->ID_transaction}}">Done</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"">Close</button>
                                                                                        <button type=" button" class="btn btn-sm btn-success"
                                                    onclick="document.getElementById('js-transactionApprove-submit{{$transaction->ID_transaction}}').click();">Approve
                                                    This Transaction</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="DisapproveTransaction{{$transaction->ID_transaction}}" data-backdrop="static"
                                    data-keyboard="false" tabindex="-1" role="dialog"
                                    aria-labelledby="DisapproveTransaction{{$transaction->ID_transaction}}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Disapprove Transaction #{{$no}} - transaction
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div style="margin: 0 20px">
                                                    <form method="post" action="{{ route('admin.disapprove') }}" class="card-body" style="padding: 0;">
                                                        @csrf
                                                        <div class="row">
                                                            <div style="width: 100%" class="alert-warning p-2 mb-2" for="emailing">
                                                                <input type="checkbox" name="emailing"
                                                                    onchange="$('#emailTextDis{{$transaction->ID_transaction}}').toggle('fast');$('#statusDis{{$transaction->ID_transaction}}').prop('checked', true);">
                                                                Notify Student to Their Email About The Disapproval<br>
                                                                <small>Student Won't be Notified, If You Don't Check the Box</small>
                                                            </div>
                                                            <textarea class="form-control mb-2" name="emailText" id="emailTextDis{{$transaction->ID_transaction}}" style="display: none" name="emailText" 
                                                                cols="30" rows="5" placeholder="Write a message to student *Optional"></textarea>
                                                        </div>
                                                        <div class="row">
                                                            <div style="width: 100%" class="alert-warning p-2 mb-2" for="statusDis{{$transaction->ID_transaction}}">
                                                                <input checked type="checkbox" name="status" id="statusDis{{$transaction->ID_transaction}}">
                                                                Change Course to Preview Access for the Student<br>
                                                                <small>Student Won't Get Preview Access, If You Don't Check the Box</small>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div style="width: 100%" class="alert-warning p-2 mb-2" for="balance">
                                                                <input type="checkbox" name="balance">
                                                                Decrease The Transaction from The Bank Balance<br>
                                                                <small>Transaction Won't be Decreased from The Bank Balance, If You Don't Check the Box</small>
                                                            </div>
                                                        </div>
                                                        <input hidden type="text" name="ID_bank" value="{{$transaction->ID_bank}}">
                                                        <input hidden type="text" name="ID_user" value="{{$transaction->ID_user}}">
                                                        <input hidden type="text" name="ID_course" value="{{$transaction->ID_course}}">
                                                        <input hidden type="text" name="ID_transaction" value="{{$transaction->ID_transaction}}">
                                                        <button style="display: none" type="submit"
                                                            id="js-transactionDisapprove-submit{{$transaction->ID_transaction}}">Done</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"">Close</button>
                                                                                                                <button type=" button"
                                                    class="btn btn-sm btn-warning"
                                                    onclick="document.getElementById('js-transactionDisapprove-submit{{$transaction->ID_transaction}}').click();">Disapprove
                                                    This Transaction</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="PendingTransaction{{$transaction->ID_transaction}}" data-backdrop="static"
                                    data-keyboard="false" tabindex="-1" role="dialog"
                                    aria-labelledby="PendingTransaction{{$transaction->ID_transaction}}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Pending Transaction #{{$no}} - transaction
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div style="margin: 0 20px">
                                                    <form method="post" action="{{ route('admin.pending') }}" class="card-body" style="padding: 0;">
                                                        @csrf
                                                        <div class="row">
                                                            <div style="width: 100%" class="alert-dark p-2 mb-2" for="emailing">
                                                                <input type="checkbox" name="emailing"
                                                                    onchange="$('#emailTextPen{{$transaction->ID_transaction}}').toggle('fast');$('#statusPen{{$transaction->ID_transaction}}').prop('checked', true);">
                                                                Notify Student to Their Email About the Pending<br>
                                                                <small>Student Won't be Notified, If You Don't Check the Box</small>
                                                            </div>
                                                            <textarea class="form-control mb-2" name="emailText" id="emailTextPen{{$transaction->ID_transaction}}"
                                                                style="display: none" name="emailText" cols="30" rows="5"
                                                                placeholder="Write a message to student *Optional"></textarea>
                                                        </div>
                                                        <div class="row">
                                                            <div style="width: 100%" class="alert-dark p-2 mb-2" for="statusPen{{$transaction->ID_transaction}}">
                                                                <input checked type="checkbox" name="status" id="statusPen{{$transaction->ID_transaction}}">
                                                                Change Course to Preview Access for the Student<br>
                                                                <small>Student Won't Get Preview Access, If You Don't Check the Box</small>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div style="width: 100%" class="alert-dark p-2 mb-2" for="balance">
                                                                <input type="checkbox" name="balanceDecrease">
                                                                Decrease The Transaction from The Bank Balance<br>
                                                                <small>Transaction Won't be Decreased from The Bank Balance, If You Don't Check the Box</small>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div style="width: 100%" class="alert-dark p-2 mb-2" for="balance">
                                                                <input type="checkbox" name="balanceAdd">
                                                                Add The Transaction to The Bank Balance<br>
                                                                <small>Transaction Won't be Added to The Bank Balance, If You Don't Check the Box</small>
                                                            </div>
                                                        </div>
                                                        <input hidden type="text" name="ID_bank" value="{{$transaction->ID_bank}}">
                                                        <input hidden type="text" name="ID_user" value="{{$transaction->ID_user}}">
                                                        <input hidden type="text" name="ID_course" value="{{$transaction->ID_course}}">
                                                        <input hidden type="text" name="ID_transaction" value="{{$transaction->ID_transaction}}">
                                                        <button style="display: none" type="submit"
                                                            id="js-transactionPending-submit{{$transaction->ID_transaction}}">Done</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary"
                                                    data-dismiss="modal"">Close</button>
                                                    <button type=" button" class="btn btn-sm btn-dark"
                                                    onclick="document.getElementById('js-transactionPending-submit{{$transaction->ID_transaction}}').click();">Pende This Transaction
                                                    changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form id="deleteTransaction{{$transaction->ID_transaction}}" style="display: none" action="{{route('admin.deleteTransaction')}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input hidden type="text" name="ID_user" value="{{$transaction->ID_user}}">
                                    <input hidden type="text" name="ID_course" value="{{$transaction->ID_course}}">
                                    <input hidden type="text" name="ID_transaction" value="{{$transaction->ID_transaction}}">
                                </form>
                            </tr>
                            @endforeach
                            @else
                                <div style="text-align: center" class="container float-right m-2">
                                    <h4>There are no Transactions yet :(</h4>
                                </div>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mt-4">
        <div class="card" style="border-radius:20px;">
            <div class="card-body" style="border-radius:20px;">
                {{-- Banks --}}
                <div class="table-responsive custom-table-responsive">
                    <div class="container m-2">
                        <h4>List of Official CariTau Bank Accounts</h4>
                        <a onclick="$('#AddBank').toggle('slow');" style="width: 100%" class="btn btn-sm btn-outline-success ">Add</a>
                    </div>
                    <div>
                        <div id="AddBank" style="display: none;" class="container float-right mb-3">
                            <form style="padding: 20px; border-bottom: 2px solid #ccc" action="{{route('admin.addBank')}}"
                                method="POST">
                                @csrf
                                <label for="bank_name">Bank Name</label>
                                <input style="width: 100%" class="form-control" name="bank_name" type="text">
                                <label for="no_account">Account NO.</label>
                                <input style="width: 100%" class="form-control" name="no_account" type="text">
                                <label for="balance">Balance</label>
                                <input class="form-control" name="balance" type="number" min="0" placeholder="0" value="0">
                                <button type="submit" style="width: 100%"
                                    class="btn btn-sm btn-outline-dark mt-5 float-right">Submit</button>
                            </form>
                        </div>
                    </div>
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Bank</th>
                                <th scope="col">Account NO.</th>
                                <th scope="col">Balance</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no =0 ;
                            @endphp
                            @if (count($banks)>0)
                            @foreach ($banks as $bank)
                            <tr scope="row">
                                <th scope="row">
                                    @php
                                    $no++
                                    @endphp
                                    {{$no}}
                                </th>
                                <td><a href="">{{$bank->bank_name}}</a></td>
                                <td>
                                    {{$bank->no_account}}
                                </td>
                                <td>Rp.{{$bank->balance}}</td>
                                <td style="display: flex; gap: 5px; justify-content: space-between">
                                    <a data-toggle="modal" data-target="#editBank{{$bank->ID_bank}}"
                                        class="btn btn-sm btn-outline-primary">Edit</a>
                                    <a onclick="document.getElementById('deleteBank{{$bank->ID_bank}}').submit();"
                                        class="btn btn-sm btn-outline-danger">Delete</a>
                                </td>
                                <div class="modal fade" id="editBank{{$bank->ID_bank}}" data-backdrop="static" data-keyboard="false"
                                    tabindex="-1" role="dialog" aria-labelledby="filesVideoModal{{$bank->ID_bank}}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Edit {{$bank->bank_name}}
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div style="margin: 0 20px">
                                                    <form method="post" action="{{ route('admin.editBank', $bank) }}" class="card-body"
                                                        style="padding: 0;">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <label style="margin-bottom: 0" for="video_name">Bank
                                                                Name:</label>
                                                            <input class="form-control" name="bank_name" type="text"
                                                                placeholder="{{$bank->bank_name}}" value="{{$bank->bank_name}}">
                                                        </div>
                                                        <div class="form-group row">
                                                            <label style="margin-bottom: 0" for="video_name">Bank
                                                                Account NO.:</label>
                                                            <input class="form-control" name="no_account" type="text"
                                                                placeholder="{{$bank->no_account}}" value="{{$bank->no_account}}">
                                                        </div>
                                                        <div class="form-group row">
                                                            <label style="margin-bottom: 0" for="video_url">Bank
                                                                Balance:</label>
                                                            <input class="form-control" name="balance" type="number" min="0"
                                                                placeholder="{{$bank->balance}}" value="{{$bank->balance}}">
                                                        </div>
                                                        <button style="display: none" type="submit"
                                                            id="js-bankEdit-submit{{$bank->ID_bank}}">Done</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"">Close</button>
                                                                                                <button type=" button"
                                                    class="btn btn-sm btn-primary"
                                                    onclick="document.getElementById('js-bankEdit-submit{{$bank->ID_bank}}').click();">Save
                                                    changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form id="deleteBank{{$bank->ID_bank}}" style="display: none"
                                    action="{{ route('admin.deleteBank', $bank) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </tr>
                            @endforeach
                            @else
                            <div style="text-align: center" class="container float-right m-2">
                                <h4>There are no banks yet :(</h4>
                            </div>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
