@extends('backend/layout/'.$layout)

@section('subhead')
    <title>LLC - Roles</title>
@endsection

@section('subcontent')
    <div class="row mt-5">
        <div class="col-lg-12">
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="col-span-6 xxl:col-span-3 -mb-10 pb-10 mb-5">
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0 mt-5">
            <a href="{{route('rolesCreate')}}" class="button text-white bg-theme-1 shadow-md mr-2">Create New Role</a>
        </div>
        <div class="intro-y datatable-wrapper box p-5 mt-5">
            <table class="table table-report table-report--bordered display datatable w-full">
                <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">#</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Role</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Slug</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Permissions</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Tools</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td class="border-b">
                            <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $role->id }}</div>
                        </td>
                        <td class="border-b">
                            <div class="flex items-center sm:justify-center "> {{ $role->name }}</div>
                        </td>
                        <td class="border-b">
                            <div class="flex items-center sm:justify-center "> {{ $role->slug }}</div>
                        </td>
                        <td class="text-center border-b">
                            @if($role->permissions() != null)
                                @foreach($role->permissions as $permission)
                                    <span>
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                            @endif
                        </td>
                        <td class="text-center border-b">
                            <div class="flex sm:justify-center items-center">
                                <a class="flex items-center mr-3" href="{{route('rolesEdit',$role->id)}}"> <i
                                            data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
@endsection