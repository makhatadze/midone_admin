@extends('backend/layout/'.$layout)

@section('subhead')
    <title>Dashboard - Midone - Laravel Admin Dashboard Starter Kit</title>
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
        <div class="intro-y datatable-wrapper box p-5 mt-5">
            <table class="table table-report table-report--bordered display datatable w-full">
                <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">Id</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">title</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">department</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">status</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">deadline</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">created at</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">closed at</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">tools</th>
                </tr>
                </thead>
                <tbody class="user-body">
                @foreach($tickets as $ticket)
                    <tr>
                        <td class="border-b">
                            <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $ticket->id }}</div>
                        </td>
                        <td class="border-b">
                            <div class="flex items-center sm:justify-center "> {{$ticket->name}}</div>
                        </td>
                        <td class="border-b">
                            <div class="flex items-center sm:justify-center "> {{$ticket->department->name}}</div>
                        </td>
                        <td class="border-b">
                            <div class="flex items-center sm:justify-center "> {{$ticket->process}}</div>
                        </td>
                        <td class="border-b">
                            @if($ticket['deadline'] != null)
                                <div class="flex items-center  sm:justify-center"> {{$ticket['deadline']}}</div>
                                <div class="flex items-center  sm:justify-center text-gray-600 text-xs">
                                    @if($ticket['closed_at'] != null)
                                        <?php echo (\Carbon\Carbon::createFromTimestamp($ticket['deadline']) <= \Carbon\Carbon::createFromTimestamp($ticket['closed_at']))
                                            ? '<span class="text-theme-9">Success</span>' : '<span class="text-theme-6">Fail</span>'
                                        ?>
                                    @endif
                                </div>
                            @else
                                <div class="flex items-center  sm:justify-center">No Deadline</div>

                            @endif
                        </td>
                        <td class="border-b">
                            <div class="flex items-center sm:justify-center "> {{$ticket->created_at}}</div>
                        </td>
                        <td class="text-center border-b">
                            <div class="flex items-center  sm:justify-center"> {{$ticket['closed_at']}}</div>
                            <div class="flex items-center  sm:justify-center text-blue-100-700 text-xs">
                                @if($ticket['closed_at'] != null)
                                    {{$ticket['confirm']}}
                                @endif
                            </div>
                        </td>
                        <td class="text-center border-b">
                            <div class="flex sm:justify-center items-center">
                                <a class="flex items-center mr-3"
                                   onclick="showMessages({{$ticket['id']}},{{$ticket->user[0]}})"><i
                                            data-feather="eye" class="w-4 h-4 mr-1"></i> Message </a>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <div class="modal" id="messagenger">
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
                                    <div class="font-medium text-base ml-2" id="messenger-user"></div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-y-scroll px-5 pt-5 flex-1" id="messenger-body">
                        </div>
                        <div class="pt-4 pb-10 sm:py-4 flex items-center border-t border-gray-200">
                            <textarea name="message-text"
                                      class="chat__box__input input w-full h-16 resize-none border-transparent px-5 py-3 focus:shadow-none"
                                      rows="1" placeholder="Type your message..."></textarea>

                            <a onclick="sendMessage({{$ticket->id}})"
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
                    data.forEach(el => {
                        if (el.answer == 0) {
                            if (el.file.length > 0) {
                                content = `${content}<div class="chat__box__text-box flex items-end float-left mb-4">
                                    <div class="w-10 h-10 hidden sm:block flex-none image-fit relative mr-5">
                                        <p>${el.user[0].name}</p>
                                    </div>
                                    <a href="/storage/tickets/${el.file[0].id}/${el.file[0].name}" target=_blank class="bg-gray-200 px-4 py-3 text-gray-700 rounded-r-md rounded-t-md">
                                       File
                                    </a>
                                </div>
                                <div class="clear-both"></div>`
                            }
                            content = `${content}<div class="chat__box__text-box flex items-end float-left mb-4">
                                    <div class="w-10 h-10 hidden sm:block flex-none image-fit relative mr-5">
                                        <p>${el.user[0].name}</p>
                                    </div>
                                    <div class="bg-gray-200 px-4 py-3 text-gray-700 rounded-r-md rounded-t-md">
                                       ${el.body}
                                    </div>
                                </div>
                                <div class="clear-both"></div>`
                        } else {
                            if (el.file.length > 0) {
                                content = `${content}<div class="chat__box__text-box flex items-end float-right mb-4">

                                    <a href="/storage/tickets/${el.file[0].id}/${el.file[0].name}" target="_blank" class="bg-theme-1 px-4 py-3 text-white rounded-l-md rounded-t-md">
                                        File
                                    </a>
                                    <div class="w-20 h-10 hidden sm:block flex-none image-fit relative ml-5">
                                        <p>${el.user.name}</p>
                                    </div>
                                </div><div class="clear-both"></div>`
                            }
                            content = `${content}<div class="chat__box__text-box flex items-end float-right mb-4">

                                    <div class="bg-theme-1 px-4 py-3 text-white rounded-l-md rounded-t-md">
                                        ${el.body}
                                    </div>
                                    <div class="w-20 h-10 hidden sm:block flex-none image-fit relative ml-5">
                                        <p>${el.user.name}</p>
                                    </div>
                                </div><div class="clear-both"></div>`
                        }
                    })
                    $('#messenger-body').html(content);
                    $('#messenger-user').text(user.name)
                    $('#messagenger').modal('show');

                }
            });
        }

        function sendMessage(id) {
            let message = $('textarea[name="message-text"]').val();
            if (message.trim().length > 0) {
                axios.post(`tickets/send-message/${id}`, {
                    message: message,
                }).then(res => {
                    $('#messenger-body').append(`<div class="chat__box__text-box flex items-end float-left mb-4">
                            <div class="w-10 h-10 hidden sm:block flex-none image-fit relative mr-5">
                            <p>${res.data.user}</p>
                            </div>
                            <div class="bg-gray-200 px-4 py-3 text-gray-700 rounded-r-md rounded-t-md">
                            ${res.data.body}
                            </div>
                            </div>
                            <div class="clear-both"></div>`)
                    $('textarea[name="message-text"]').val('')
                }).catch(err => {
                    alert('something wrong')
                })
            }

        }
    </script>
@endsection