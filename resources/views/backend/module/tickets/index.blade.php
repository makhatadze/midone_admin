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
            <a href="javascript:;" data-toggle="modal" data-target="#user_form_modal" id="create-user"
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
        <script>

        </script>
@endsection