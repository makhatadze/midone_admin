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
    <div class="col-span-6 xxl:col-span-3 -mb-10 pb-10 mb-5">
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0 mt-5">
            <h1>Ticket List</h1>
        </div>
        <div class="intro-y datatable-wrapper box p-5 mt-5">
            <table class="table table-report table-report--bordered display datatable w-full">
                <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">Id</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">title</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">department</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">level</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">deadline</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">created at</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">tools</th>
                </tr>
                </thead>
                <tbody class="ticket-body">
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
                            <div class="flex items-center sm:justify-center "> {{$ticket['level']}}</div>
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
                            <div class="flex items-center sm:justify-center "> {{$ticket['created_at']}}</div>
                        </td>
                        <td class="text-center border-b">
                            <div class="flex sm:justify-center items-center">
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

                                                        <?php echo (\Carbon\Carbon::createFromTimestamp($ticket['deadline']) <= \Carbon\Carbon::createFromTimestamp($ticket['closed_at']))
                                                            ? '<span class="text-theme-9">Success</span>' : '<span class="text-theme-6">Fail</span>'
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
                                                        <div class="text-gray-700 mt-1">Approved Status: Not Approved
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
                                @if(count($ticket['can_approve']) > 0)
                                    <div>
                                        <a class="flex items-center mr-3" href="javascript:;" data-toggle="modal"
                                           data-target="#approve-modal-preview-{{$ticket['id']}}">
                                            <i
                                                    data-feather="check-square" class="w-4 h-4 mr-1"></i>
                                            Approve </a>
                                        <div class="modal" id="approve-modal-preview-{{$ticket['id']}}">
                                            <div class="modal__content">
                                                <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
                                                    <h2 class="font-medium text-base mr-auto">New
                                                        Approve</h2>
                                                </div>
                                                <form class="approve-form" method="POST"
                                                      action="tickets/approve/{{$ticket['id']}}">
                                                    @csrf
                                                    <div class="sm:grid grid-cols-2 gap-2 mb-4 pr-5 pl-5">
                                                        <div class="relative mt-4">
                                                            <label>Department</label>
                                                            <div class="mt-2 roles-container">
                                                                <select required data-hide-search="true"
                                                                        name="department" class="select2 w-full">
                                                                    <option value="">Select Department</option>
                                                                    @foreach($ticket['can_approve'] as $approve)
                                                                        <option value="{{$approve['department_id']}}">{{$approve['department_name']}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <div class="flex flex-col sm:flex-row"
                                                                 style="margin-top: 2.75rem; margin-left: 2.25rem;">
                                                                <div class="flex items-center text-gray-700 mr-2"><input
                                                                            type="radio" checked
                                                                            class="input border mr-2"
                                                                            id="horizontal-radio-chris-evans"
                                                                            name="approve" value="1">
                                                                    <label class="cursor-pointer select-none"
                                                                           for="horizontal-radio-chris-evans">Approve</label>
                                                                </div>
                                                                <div class="flex items-center text-gray-700 mr-2 mt-2 sm:mt-0">
                                                                    <input type="radio" class="input border mr-2"
                                                                           id="horizontal-radio-liam-neeson"
                                                                           name="approve" value="">
                                                                    <label class="cursor-pointer select-none"
                                                                           for="horizontal-radio-liam-neeson">Reject</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="px-5 py-3 text-right border-t border-gray-200">
                                                        <button type="button" data-dismiss="modal"
                                                                class="button w-20 border text-gray-700 mr-1">Close
                                                        </button>
                                                        <button type="submit"
                                                                class="button w-20 bg-theme-1 text-white">Approve
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if($ticket['closed_at'] == null && $ticket['can_confirm'] && !in_array(false, array_column($ticket['approve_departments'], 'approved')))
                                    <a class="flex items-center text-theme-9" href="javascript:;" data-toggle="modal"
                                       onclick="confirmModal({{$ticket['id']}})"
                                       data-target="#confirmModal"> <i data-feather="stop-circle"
                                                                       class="w-4 h-4 mr-1"></i>
                                        Confirm </a>
                                @endif
                            </div>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="modal" id="confirmModal">

                <div class="modal__content">
                    <div class="p-5 text-center">
                        <i data-feather="check-circle" class="w-16 h-16 text-theme-9 mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-gray-600 mt-2">You want to Confirm this ticket?</div>
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
        <script>
            function confirmModal(e) {
                $(document).ready(function () {
                    $('.ticket-confirm-form').attr('action', `tickets/confirm/${e}`)
                })
            }

        </script>
@endsection