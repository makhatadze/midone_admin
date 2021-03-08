@extends('backend/layout/'.$layout)

@section('subhead')
<title>LLC - My Tickets</title>
<style>
    .pagination {
        display: inline-block;
        margin-top: -40px;
    }

    .pagination a {
        color: black;
        float: left;
        padding: 8px 16px;
        text-decoration: none;
    }

    .pagination a.active {
        background-color: #4CAF50;
        color: white;
    }

    .pagination a:hover:not(.active) {background-color: #ddd;}

</style>
@endsection

@section('subcontent')
<div class="row mt-5">
    <div class="col-lg-12">
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="col-span-6 xxl:col-span-3  pb-10 mb-5">
    <div class="w-full sm:w-auto flex  sm:mt-0 mt-5">
        <a href="javascript:;" id="create-ticket"
           class="button text-white bg-theme-1 shadow-md mr-2">Create New Ticket</a>
    </div>

    <div class="w-full sm:w-auto flex  sm:mt-0 mt-5">
        <a href="{{ route('exportAll') }}" class="button text-white bg-theme-1 shadow-md mr-2" style="background-color: green; margin-top: 10px;">Export My Tickets</a>
    </div>
    
    
    <div id="add"></div>

    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">Id</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">title</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">department</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">deadline</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">created at</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">closed at</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">tools</th>

                    <th class="border-b-2 text-center whitespace-no-wrap">
                        <button class="button text-white bg-theme-1 shadow-md mr-2" onclick="exportTicket()" style="background-color: green">Export to Excel</button>
                    </th>
                </tr>
            </thead>
            <tbody class="user-body">
                @foreach($tickets as $ticket)
                <tr>

                    <td class="border-b">
                        <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $ticket['id'] }}</div>
                    </td>
                    <td class="border-b">
                        <div class="flex items-center sm:justify-center "> {{$ticket['name']}}</div>
                    </td>
                    <td class="border-b">
                        <div class="flex items-center sm:justify-center "> {{$ticket['department']}}</div>
                    </td>
                    <td class="border-b">
                        @if($ticket['deadline'] != null)
                        <div class="flex items-center  sm:justify-center"> {{$ticket['deadline']}}</div>
                        <div class="flex items-center  sm:justify-center text-gray-600 text-xs">
                            @if($ticket['closed_at'] != null)
                            <?php
                               echo (\Carbon\Carbon::createFromTimestamp($ticket['deadline']) <= \Carbon\Carbon::createFromTimestamp($ticket['closed_at'])) ? '<span class="text-theme-9">Success</span>' : '<span class="text-theme-6">Fail</span>'
                            ?>
                            @endif
                        </div>
                        @else
                        <div class="flex items-center  sm:justify-center">No Deadline</div>
                        @endif
                    </td>
                    <td class="border-b">
                        <div class="flex items-center sm:justify-center "> {{$ticket['created_at']}}</div>
                    </td>
                    <td class="text-center border-b">
                        <div class="flex items-center  sm:justify-center">
                            @if($ticket['confirm'] != '0'&& $ticket['closed_at'])
                            {{$ticket['closed_at']}}
                            @elseif($ticket['confirm'] != '0')
                            Un Confirmed by
                            @endif
                        </div>
                        <div class="flex items-center  sm:justify-center text-blue-100-700 text-xs">
                            @if($ticket['confirm'] != '0')
                            {{$ticket['confirm']}}
                            @endif
                        </div>
                    </td>
                    <td class="text-center border-b">
                        <div class="flex sm:justify-center items-right">
                            <a class="flex items-center mr-3 cursor-pointer"
                               onclick="showMessages({{$ticket['id']}},'{{$ticket['user']}}')"><i
                                    data-feather="eye" class="w-4 h-4 mr-1"></i> Message </a>
                            <a class="flex items-center mr-3 user-view" href="javascript:;" data-toggle="modal"
                               data-target="#ticket_view_modal-{{$ticket['id']}}"><i
                                    data-feather="eye" class="w-4 h-4 mr-1"></i> View </a>
                            <div class="modal" id="ticket_view_modal-{{$ticket['id']}}">
                                <div class="modal__content">
                                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
                                        <h2 class="font-medium text-base mr-auto" id="user-form-title">Ticket
                                            N{{$ticket['id']}} - {{$ticket['name']}}</h2>
                                    </div>
                                    <div class="md:flex bg-white rounded-lg p-6 pt-3">
                                        <div class="text-center md:text-left">
                                            <h3 class="text-lg">Created by: {{$ticket['user']}}</h3>
                                            <hr>
                                            <div class="text-gray-700 mt-1">
                                                Department: {{$ticket['department']}}</div>
                                            <hr>
                                            <div class="text-gray-700 mt-1">
                                                Deadline: {{$ticket['deadline'] ? $ticket['deadline'] : 'No Deadline'}}
                                                @if($ticket['deadline'] != null && $ticket['closed_at'] != null)

                                                <?php
                                                   echo (\Carbon\Carbon::createFromTimestamp($ticket['deadline']) <= \Carbon\Carbon::createFromTimestamp($ticket['closed_at'])) ? '<span class="text-theme-9">Success</span>' : '<span class="text-theme-6">Fail</span>'
                                                ?>

                                                @endif
                                            </div>
                                            <hr>
                                            <div class="text-gray-700 mt-1">Created
                                                At: {{$ticket['created_at']}}</div>
                                            <hr>
                                            <div class="text-gray-700 mt-1">Level: {{$ticket['level']}}</div>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="md:flex bg-white rounded-lg p-6 pt-3">
                                        <div class="text-center md:text-left">
                                            @if($ticket['closed_at'] != null)
                                            <h3 class="text-lg">Confirm By: {{$ticket['confirm']}} - Confirm
                                                At {{$ticket['closed_at']}}</h3>
                                            @else
                                            <h3 class="text-lg">Confirm: Not Yet</h3>
                                            @endif
                                            <hr>
                                            @foreach($ticket['approve_departments'] as $approve)
                                            @if (!$approve['approved'])
                                            <div class="text-gray-700 mt-1">Department
                                                Group: {{$approve['department']}}</div>
                                            <div class="text-gray-700 mt-1">Ticket Status: Pending
                                            </div>
                                            <hr>
                                            @else
                                            <div class="text-gray-700 mt-1">
                                                Status: {{$approve['status'] ? 'Approved' : 'Rejected'}}</div>
                                            <div class="text-gray-700 mt-1">Department
                                                Group: {{$approve['department']}}</div>
                                            <div class="text-gray-700 mt-1">Created
                                                By: {{$approve['user']}}</div>
                                            <div class="text-gray-700 mt-1">Created
                                                At: {{$approve['created_at']}}</div>
                                            <hr>
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="px-5 py-3 text-right border-t border-gray-200">
                                        <button type="button" data-dismiss="modal"
                                                class="button w-20 border text-gray-700 mr-1">Close
                                        </button>
                                    </div>

                                </div>
                            </div>
                            @if(!in_array(false, array_column($ticket['approve_departments'], 'approved')))
                            @if($ticket['confirm'] && $ticket['closed_at'])
                            <a class="flex items-center text-theme-9 cursor-pointer" href="javascript:;"
                               data-toggle="modal"
                               onclick="confirmModal({{$ticket['id']}})"
                               data-target="#confirmModal"> <i data-feather="stop-circle"
                                                            class="w-4 h-4 mr-1"></i>
                                Un Confirm
                            </a>
                            @else
                            <a class="flex items-center text-theme-9 cursor-pointer" href="javascript:;"
                               data-toggle="modal"
                               onclick="confirmModal({{$ticket['id']}})"
                               data-target="#confirmModal"> <i data-feather="stop-circle"
                                                            class="w-4 h-4 mr-1"></i>
                                Confirm
                            </a>
                            @endif
                            @endif
                        </div>
                    </td>
                    <td class="border-b">
                        <div class="flex items-center sm:justify-center">
                            <input type="checkbox" class="dt-checkboxes" value="{{ $ticket['id'] }}">
                        </div>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    <div class="modal" id="messagenger">
        <input type="text" disabled hidden name="ticket_id">
        <div class="modal__content modal__content--xl p-10 text-center">
            <div class="intro-y col-span-12 lg:col-span-8 xxl:col-span-9">
                <div class="chat__box box">
                    <!-- BEGIN: Chat Active -->
                    <div class="h-full flex flex-col" style="">
                        <div class="flex flex-col sm:flex-row border-b border-gray-200 px-5 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 flex-none image-fit relative">
                                    <img alt="Midone Tailwind HTML Admin Template" class="rounded-full"
                                         src="{{ asset('dist/images/' . $fakers[9]['photos'][0]) }}">
                                </div>
                                <div class="font-medium text-base ml-2" id="messenger-user">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-y-scroll px-5 pt-5 flex-1"
                         style="max-height: 400px; display: flex; flex-direction: column-reverse"
                         id="messenger-body">
                    </div>
                    <div class="pt-4 pb-10 sm:py-4 flex items-center border-t border-gray-200">
                        <textarea name="message-text"
                                  class="chat__box__input input w-full h-16 resize-none border-transparent px-5 py-3 focus:shadow-none"
                                  rows="1" placeholder="Type your message..."></textarea>

                        <a onclick="sendMessage()"
                           class="cursor-pointer w-8 h-8 sm:w-10 sm:h-10 block bg-theme-1 text-white rounded-full flex-none flex items-center justify-center mr-5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-send w-4 h-4">
                            <line x1="22" y1="2" x2="11" y2="13"></line>
                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                        </a>
                    </div>
                </div>
                <input id="msgfile" name="msgattachment" type="file" style="position:absolute;left:0px;bottom: -30px" />
                <!-- END: Chat Active -->
                <!-- BEGIN: Chat Default -->
                <div class="h-full flex items-center" style="display: none;">
                    <div class="mx-auto text-center">
                        <div class="w-16 h-16 flex-none image-fit rounded-full overflow-hidden mx-auto">
                            <img alt="Midone Tailwind HTML Admin Template"
                                 src="{{ asset('dist/images/' . $fakers[9]['photos'][0]) }}">
                        </div>
                        <div class="mt-3">
                            <div class="font-medium">Hey, John Travolta!</div>
                            <div class="text-gray-600 mt-1">Please select a chat to start messaging.</div>
                        </div>
                    </div>
                </div>
                <!-- END: Chat Default -->
            </div>
        </div>

    </div>
</div>

<div class="modal" id="ticket_form_modal">
    <div class="modal__content">
        <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
            <h2 class="font-medium text-base mr-auto" id="user-form-title">Ticket Create</h2>
        </div>
        <form class="ticket-form" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
                <div class="col-span-12 sm:col-span-12 error-ticket-department">
                    <label>Department</label>
                    <div class="mt-2 department-container">
                        <select name="ticket_department" id="department-select2"
                                class="select2  w-full">
                            @if($departments)
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                            <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <span class="help-block help-ticket-department mt-1">
                    </span>
                </div>

                <div class="col-span-12 sm:col-span-12 error-ticket-category" id="category_box">
                    <label>Category</label>
                    <div class="mt-2 category-container">
                        <select name="ticket_category" id="category-select2"
                                class="select2  w-full">
                            <option value="">Custom</option>
                        </select>
                    </div>
                </div>

                <!--- ################### ----> 
                <div class="col-span-12 sm:col-span-12 error-ticket-category" id="category_box">
                    <label>Additional Departments</label>
                    <div class="mt-2 category-container">
                        <select name="additional_departments[]" id="additional_departments-select2"
                                class="select2  w-full" multiple>
                            @if($departments)
                            <option value=""></option>
                            @foreach($departments as $department)
                            <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <!--- #################### ----> 
                <div class="col-span-12 sm:col-span-12 error-ticket-name">
                    <label>title</label>
                    <input type="text" name="ticket_name" class="input w-full border mt-2 flex-1"
                           placeholder="Name...">
                    <span class="help-block help-ticket-name mt-1"></span>
                </div>
                <div class="col-span-12 sm:col-span-12 error-ticket-deadline">
                    <label>Deadline</label>
                    <input type="text" name="ticket_deadline" class="datepicker input w-full border mt-2 flex-1"
                           placeholder="deadline">
                    <span class="help-block help-ticket-deadline mt-1">
                    </span>
                    <input type="time" name="ticket_deadline_time" class="input w-full border mt-2 flex-1"
                           placeholder="deadline">
                    <span class="help-block help-ticket-deadline mt-1">
                    </span>
                </div>
                <div class="col-span-12 sm:col-span-12 error-ticket-level">
                    <label>Level</label>
                    <div class="mt-2 category-container">
                        <select name="ticket_level"
                                class="select2  w-full">
                            <option value="">Select level</option>
                            <option value="1">Low</option>
                            <option value="2">Medium</option>
                            <option value="3">Hight</option>
                        </select>
                    </div>
                    <span class="help-block help-ticket-level mt-1">
                    </span>
                </div>
                <div class="col-span-12 sm:col-span-12 error-ticket-message">
                    <label>Message</label>
                    <div class="mt-2 category-container">
                        <textarea name="ticket_message" class="input w-full border mt-2 col-span-2" id=""
                                  cols="30" rows="10"></textarea>
                    </div>
                    <span class="help-block help-ticket-message mt-1">
                    </span>
                </div>
                <div class="col-span-12 sm:col-span-12">
                    <input name="file" type="file"/>

                </div>
            </div>
            <div class="px-5 py-3 text-right border-t border-gray-200">
                <button type="button" id="btn-ticket-close" class="button w-20 border text-gray-700 mr-1">Cancel
                </button>
                <button type="button" id="btn-ticket-create" class="button w-20 bg-theme-1 text-white">Create
                </button>
            </div>
        </form>
    </div>
    <div class="modal" id="confirmModal">

        <div class="modal__content">
            <div class="p-5 text-center">
                <i data-feather="check-circle" class="w-16 h-16 text-theme-9 mx-auto mt-3"></i>
                <div class="text-3xl mt-5">Are you sure?</div>
            </div>
            <form method="POST" action="" class="ticket-confirm-form">

                <div class="px-5 pb-8 text-center">

                    <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">
                        close
                    </button>
                    @method('POST')
                    @csrf()
                    <button type="button" class="button w-24 mr-1 mb-2 bg-theme-9 text-white"
                            onclick="$(this).closest('form').submit();">Confirm
                    </button>
                </div>
            </form>

        </div>

    </div>

</div>
   <div class="pagination">
      <a href="?page=<?php $currentPage - 1; ?>">&laquo;</a>
            <?php
               $withLastSearch = false;
               $withRaquo = false;
               
               $pagesLeft = 0;
               $i = $currentPage - 6;
               
               if ($currentPage <= 6) {
                   $i = 1;
               }  
               if ($i  >= 2) {
                   ?>
              <a  href="?page=1">1</a>
              
                   <span>...</span>
            <?php
               }
               $iteration = 0;
               
               for ($i; $i <= $numOfPages; $i++) {
                   $iteration++;
               
                   if ($i == $currentPage) {
                       ?>
                       <a class="active" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                       <?php
                       continue;
                   }
                   ?>


                   <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>


                   <?php
                   if (($currentPage + 1) <= $numOfPages) {
                       $withRaquo = true;
                   }
                   
                   if ($iteration > 6) {
                       $pagesLeft = $numOfPages - $currentPage;
                       $withLastSearch = ($pagesLeft == 1)? false : true;
                       break;
                   }
               }
            ?>

            <?php
               if ($withLastSearch) {
                   ?>
                   <span>...</span>

                   <a href="?page=<?php echo $numOfPages; ?>"><?php echo $numOfPages; ?></a>
               <?php }
            ?>  

            <?php if ($withRaquo): ?>
                   <a href="?page=<?php $currentPage + 1; ?>">&raquo;</a>
               <?php endif; ?>


        </div>
<script>
    function showMessages(id, user) {
    $('#messenger-body').html('');
    $.ajax({
    url: `/admin/tickets/messages/${id}`,
            method: 'get',
            dataType: 'json',
    }).done(function (data) {
    let content = '';
    if (data) {
    data = data.reverse();
    data.forEach((el, id) => {
    if (el.answer == 1) {
    if (el.file.length > 0) {
    content = `${content}<div class="chat__box__text-box flex items-end float-left mb-4">
                                <div class="w-auto h-10 hidden sm:block flex-none image-fit relative mr-5">
                                    <p>${el.user[0].name}</p>
                                </div>
                                <a href="/storage/tickets/${el.file[0].id}/${el.file[0].name}" target=_blank class="bg-gray-200 px-4 py-3 text-gray-700 rounded-r-md rounded-t-md">
                                   File
                                <div class="mt-1 text-xs text-gray-600">${getTime(el.created_at)}</div>

                                </a>
                            </div>
                            <div class="clear-both"></div>`
    }
    content = `${content}<div class="chat__box__text-box flex items-end float-left mb-4">
                                <div class="w-auto h-10 hidden sm:block flex-none image-fit relative mr-5">
                                    <p>${el.user[0].name}</p>
                                </div>
                                <div class="bg-gray-200 px-4 py-3 text-gray-700 rounded-r-md rounded-t-md">
                                   ${el.body}
                                <div class="mt-1 text-xs text-gray-600">${getTime(el.created_at)}</div>

                                </div>
                            </div>
                            <div class="clear-both"></div>`
    } else {
    if (el.file.length > 0) {
    content = `${content}<div class="clear-both"></div><div style="align-self: flex-end" class="chat__box__text-box flex items-end float-right mb-4">
                            <div class="bg-theme-1 px-4 py-3 text-white rounded-l-md rounded-t-md">
                                   ${el.body}
                                <div class="mt-1 text-xs text-theme-25">${getTime(el.created_at)}</div>
                            </div>
                            <div class="w-auto h-10 hidden sm:block flex-none image-fit relative ml-5">
                                    <p>${el.user[0].name}</p>
                            </div>
                        </div>`
    }
    content = `${content}<div class="clear-both"></div><div style="align-self: flex-end" class="chat__box__text-box flex items-end float-right mb-4">
                            <div class="bg-theme-1 px-4 py-3 text-white rounded-l-md rounded-t-md">
                                   ${el.body}
                                <div class="mt-1 text-xs text-theme-25">${getTime(el.created_at)}</div>

                            </div>
                            <div class="w-auto h-10 hidden sm:block flex-none image-fit relative ml-5">
                                    <p>${el.user[0].name}</p>
                            </div>
                        </div>`
    }
    })
            $('#messenger-body').html(content);
    $('#messenger-user').text(user.name)
            $('input[name="ticket_id"]').val(id);
    $('#messagenger').modal('show');
    }
    });
    }

    function getTime(time) {
    let sec = (Math.floor(Date.now() / 1000) - (Math.floor(new Date(time) / 1000)))

            if (parseInt(sec / 60) === 0) {
    return `${sec} sec ago`
    }

    let min = parseInt(sec / (60));
    if (min < 60) {
    return `${min} min ago`
    }

    let hour = parseInt(sec / (60 * 60));
    if (hour < 24) {
    return `${hour} hour ago`
    }

    let day = parseInt(sec / (60 * 60 * 24))
            if (day < 30) {
    return `${day} day ago`
    }

    let month = parseInt(sec / (60 * 60 * 24 * 30))
            if (day > 0) {
    return `${day} month ago`
    }
    }


    function sendMessage() {
    let message = $('textarea[name="message-text"]').val();
    let id = $('input[name="ticket_id"]').val()
            var formData = new FormData();
    formData.append('message', message);
    formData.append('attachment', false);
    // add file 
    let attachment = document.getElementById('msgfile')
            if (attachment.files.length > 0) {
    formData.set('attachment', attachment.files[0]);
    }

    if (message.trim().length > 0) {
    axios.post(`tickets/send-message/${id}`, formData).then(res => {
    $('#messenger-body').prepend(`<div class="clear-both"></div><div style="align-self: flex-end" class="chat__box__text-box flex items-end float-right mb-4">
                            <div class="bg-theme-1 px-4 py-3 text-white rounded-l-md rounded-t-md">
                                   ${res.data.body}
                                <div class="mt-1 text-xs text-theme-25">${getTime(res.data.created_at)}</div>

                            </div>
                            <div class="w-10 h-10 hidden sm:block flex-none image-fit relative ml-5">
                                    <p>${res.data.user}</p>
                            </div>
                        </div>`)
            if (attachment.files.length > 0) {
    $('#messenger-body').prepend(`<div class="clear-both"></div><div style="align-self: flex-end" class="chat__box__text-box flex items-end float-right mb-4">
                            <div class="bg-theme-1 px-4 py-3 text-white rounded-l-md rounded-t-md">
                                 <a href="/storage/tickets/${res.data.message_id}/${res.data.filename}" target=_blank class="bg-gray-200 px-4 py-3 text-gray-700 rounded-r-md rounded-t-md" style="background-color: #1C3FAA;color: white;">
                                   File - ${res.data.filename}
                                </a>
                                <div class="mt-1 text-xs text-theme-25">${getTime(res.data.created_at)}</div>

                            </div>
                            <div class="w-auto h-10 hidden sm:block flex-none image-fit relative ml-5">
                                    <p>${res.data.user}</p>
                            </div>
                        </div>`);
    attachment.value = '';
    }
    $('textarea[name="message-text"]').val('')
    }).catch(err => {
    alert('something wrong')
    })
    }

    }

    function confirmModal(e) {
    $(document).ready(function () {
    $('.ticket-confirm-form').attr('action', `tickets/confirm/${e}`)
    })
    }


    function exportTicket () {
    $checkBoxes = $(".table input:checkbox:checked");
    if ($checkBoxes.length === 0) {
    alert('You have to check tickets for export.');
    return;
    }

    $ticketIds = $checkBoxes.map(function () {
    return $(this).attr('value')
    }).get();
    let cookieKey = 'ticket-export-ids';
    document.cookie = cookieKey + '=' + encodeURIComponent(JSON.stringify($ticketIds));
    window.location.href = '{{ route("exportToExcel") }}';
    }

</script>
@endsection
