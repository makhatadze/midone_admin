@extends('backend/layout/'.$layout)

@section('subhead')
<title>LLC - My Tickets</title>
@endsection

@section('subcontent')
<div class="row mt-5">
    <div class="col-lg-12">
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="col-span-6 xxl:col-span-3  pb-10 mb-5">
    <div class="w-full sm:w-auto flex  sm:mt-0 mt-5">
        Export Logs
    </div>
    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">Id</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">User</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Exported Ticket Ids</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Created At</th>


                </tr>
            </thead>
            <tbody class="user-body">
                @foreach($exportLogs as $export)
                <tr>

                    <td class="border-b">
                        <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $export['id'] }}</div>
                    </td>
                    <td class="border-b">
                        <div class="flex items-center sm:justify-center "> {{$export->user->username  }}</div>
                    </td>
                    <td class="border-b">
                        <div class="flex items-center sm:justify-center "> 
                            <?php
                            $ticketIdsSerialized = @unserialize($export['ticket_ids']);
                            $ticketIdsStr = (is_array($ticketIdsSerialized)) ? implode(', ', $ticketIdsSerialized) : $export['ticket_ids'];
                            ?>
                            {{ $ticketIdsStr }}
                        </div>
                    </td>
                    <td class="border-b">
                        <div class="flex items-center sm:justify-center "> {{$export['created_at']}}</div>
                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>


<script>

</script>
@endsection