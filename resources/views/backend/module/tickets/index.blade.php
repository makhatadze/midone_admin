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
                            <div class="flex items-center sm:justify-center "> {{$ticket->deadline}}</div>
                        </td>
                        <td class="border-b">
                            <div class="flex items-center sm:justify-center "> {{$ticket->created_at}}</div>
                        </td>
                        <td class="text-center border-b">
                            <div class="flex sm:justify-center items-center">

                            </div>

                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
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

        </script>
@endsection