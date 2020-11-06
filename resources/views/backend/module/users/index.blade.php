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
            @if($loggedin_user->hasPermission('create_user'))
                <a href="javascript:;" data-toggle="modal" data-target="#user_form_modal" id="create-user"
                   class="button text-white bg-theme-1 shadow-md mr-2">Create New User</a>
            @endif
        </div>
        <div class="intro-y datatable-wrapper box p-5 mt-5">
            <table class="table table-report table-report--bordered display datatable w-full">
                <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">Id</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">First Name</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Last Name</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Email</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Role</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Permissions</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">Tools</th>
                </tr>
                </thead>
                <tbody class="user-body">
                @foreach($users as $user)
                    <tr>
                        <td class="border-b">
                            <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $user->id }}</div>
                        </td>
                        <td class="border-b">
                            <div class="flex items-center sm:justify-center "> {{ (!empty($user->profile)) ? $user->profile->first_name : $user->name }}</div>
                        </td>
                        <td class="border-b">
                            <div class="flex items-center sm:justify-center "> {{ (!empty($user->profile)) ? $user->profile->last_name : '' }}</div>
                        </td>
                        <td class="border-b">
                            <div class="flex items-center sm:justify-center "> {{ $user->email }}</div>
                        </td>
                        <td class="text-center border-b">
                            @if($user->roles->isNotEmpty())
                                @foreach($user->roles as $role)
                                    <span>
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            @endif
                        </td>
                        <td class="text-center border-b">
                            @if($user->permissions->isNotEmpty())
                                @foreach($user->permissions as $key => $permission)
                                    @if($key < 3)
                                        <span>{{ $permission->name }}</span>
                                    @elseif($key == 3)
                                        <span> ...</span>
                                    @endif

                                @endforeach
                            @endif
                        </td>
                        <td class="text-center border-b">
                            <div class="flex sm:justify-center items-center">
                                <a class="flex items-center mr-3 user-view" href="javascript:;" id="{{$user->id}}"> <i
                                            data-feather="eye" class="w-4 h-4 mr-1" id="{{$user->id}}"></i> View </a>
                                @if($loggedin_user->hasPermission('update_user'))
                                    <a class="flex items-center mr-3 user-edit" href="javascript:;" id="{{$user->id}}">
                                        <i
                                                data-feather="check-square" class="w-4 h-4 mr-1" id="{{$user->id}}"></i>
                                        Edit </a>
                                @endif
                                @if($loggedin_user->hasPermission('delete_user'))

                                    <a class="flex items-center text-theme-6" href="javascript:;" data-toggle="modal"
                                       data-userid="{{$user['id']}}" onclick="deleteModal({{$user['id']}})"
                                       data-target="#deleteModal"> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i>
                                        Delete </a>
                                @endif
                            </div>

                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <div class="modal" id="user_form_modal">
                <div class="modal__content">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
                        <h2 class="font-medium text-base mr-auto" id="user-form-title">User Create</h2>
                    </div>
                    <form class="user-form">
                        @csrf
                        <div class="p-5 grid grid-cols-12 gap-4 row-gap-3">
                            <input type="text" name="user_id" disabled hidden>
                            <div class="col-span-12 sm:col-span-6 error-user-first_name">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="input w-full border mt-2 flex-1"
                                       placeholder="First Name...">
                                <span class="help-block help-user-first_name"></span>
                            </div>
                            <div class="col-span-12 sm:col-span-6 error-user-last_name">
                                <label>Last Name</label>
                                <input type="text" class="input w-full border mt-2 flex-1" name="last_name"
                                       placeholder="Last Name...">
                                <span class="help-block help-user-last_name">
                            </span>
                            </div>
                            <div class="col-span-12 sm:col-span-6 error-user-phone">
                                <label>Phone</label>
                                <input type="text" class="input w-full border mt-2 flex-1" name="phone"
                                       placeholder="Phone ...">
                                <span class="help-block help-user-phone">
                            </span>
                            </div>
                            <div class="col-span-12 sm:col-span-6 error-user-country">
                                <label>Country</label>
                                <div class="mt-2"><select name="country" class="select2 country-select2 w-full">
                                        @foreach($countries as $country)
                                            <option value="{{$country->code}}">{{$country->name}}</option>
                                        @endforeach
                                    </select></div>
                                <span class="help-block help-user-country">
                            </span>
                            </div>
                            <div class="col-span-12 sm:col-span-6 error-user-birthday">
                                <label>Birthday</label>
                                <input type="text" class="datepicker input w-full border mt-2 flex-1"
                                       placeholder="birthday">
                                <span class="help-block help-user-birthday">
                            </span>
                            </div>
                            <div class="col-span-12 sm:col-span-6 error-user-email">
                                <label>Email</label>
                                <input type="text" name="email" class="input w-full border mt-2 flex-1"
                                       placeholder="email ...">
                                <span class="help-block help-user-email">
                            </span>
                            </div>
                            <div class="col-span-12 sm:col-span-6 error-user-password">
                                <label>Password</label>
                                <input type="password" name="password" autocomplete="off"
                                       class="input w-full border mt-2 flex-1" placeholder="">
                                <span class="help-block help-user-password">
                            </span>
                            </div>
                            <div class="col-span-12 sm:col-span-6 error-user-password_confirmation">
                                <label>Password Confirm</label>
                                <input type="password" name="password_confirmation" autocomplete="off"
                                       class="input w-full border mt-2 flex-1" placeholder="">
                                <span class="help-block help-user-password_confirmation">
                            </span>
                            </div>
                            <div class="col-span-12 sm:col-span-12 error-user-role">
                                <label>Role</label>
                                <div class="mt-2 roles-container">
                                    <select name="user_role" id="roles-select2" onchange="roleChange(event)"
                                            class="select2  w-full">
                                        <option value="0">Select Role...</option>
                                        @if($roles)
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <span class="help-block help-user-role">
                            </span>
                            </div>
                            <div class="col-span-12 sm:col-span-12 error-user-role" id="permissions_box">
                                <label>Permissions</label>
                                <div class="permissions_checkbox_list">
                                </div>
                            </div>
                        </div>
                        <div class="px-5 py-3 text-right border-t border-gray-200">
                            <button type="button" id="btn-close" class="button w-20 border text-gray-700 mr-1">Cancel
                            </button>
                            <button type="button" id="btn-user-create" class="button w-20 bg-theme-1 text-white">Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal" id="user_view_modal">
                <div class="modal__content">
                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200">
                        <h2 class="font-medium text-base mr-auto" id="user-form-title">User View</h2>
                    </div>
                    <div class="md:flex bg-white rounded-lg p-6">
                        <div class="text-center md:text-left">
                            <h2 class="text-lg view-fullName"></h2>
                            <div class="text-gray-600 view-email mt-3"></div>
                            <div class="text-gray-600 view-country mt-1"></div>
                            <div class="text-gray-600 view-birthday mt-1"></div>
                            <div class="text-gray-600 view-phone mt-1"></div>
                            <div class="text-gray-600 view-role mt-1"></div>
                            <div class="text-gray-600 view-permissions mt-1"></div>
                        </div>
                    </div>
                    <div class="px-5 py-3 text-right border-t border-gray-200">
                        <button type="button" id="btn-view-close" class="button w-20 border text-gray-700 mr-1">Close
                        </button>
                    </div>

                </div>
            </div>
            <!-- Add and Edit customer modal -->
            <div class="modal" id="deleteModal">

                <div class="modal__content">
                    <div class="p-5 text-center">
                        <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                        <div class="text-3xl mt-5">Are you sure?</div>
                        <div class="text-gray-600 mt-2">You want to delete this item?</div>
                    </div>
                    <form method="POST" action="" class="user-delete-form">

                        <div class="px-5 pb-8 text-center">

                            <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">
                                close
                            </button>
                            @method('DELETE')
                            @csrf()
                            <button type="button" class="button w-24 bg-theme-6 text-white"
                                    onclick="$(this).closest('form').submit();">Delete
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <script>
            function deleteModal(e) {
                $(document).ready(function () {
                    $('.user-delete-form').attr('action', `users/delete/${e}`)
                })
            }

            function roleChange(e) {
                let list = $('.permissions_checkbox_list');
                let permissions_box = $('#permissions_box');

                list.empty();
                if (e.target.value != '0') {

                    $(document).ready(function () {
                        $.ajax({
                            url: "/admin/users/create",
                            method: 'get',
                            dataType: 'json',
                            data: {
                                role: e.target.value,
                            }
                        }).done(function (data) {
                            permissions_box.show();
                            list.empty();
                            let content = '';
                            data.forEach(function (el) {
                                content = `${content} <div class="flex items-center text-gray-700 mt-2">
                      <input type="checkbox" name="permissions[]" value="${el.id}" id="checkbox-${el.id}" class="input border mr-2" >
                      <label class="cursor-pointer select-none" for="vertical-checkbox-chris-evans">${el.name}</label>
                    </div>`

                            })
                            $('.permissions_checkbox_list').html(content)
                        });
                    });

                    function setCheckbox(role) {
                        let list = $('.permissions_checkbox_list');
                        let permissions_box = $('#permissions_box');

                        $.ajax({
                            url: "/admin/users/create",
                            method: 'get',
                            dataType: 'json',
                            data: {
                                role: role,
                            }
                        }).done(function (data) {
                            permissions_box.show();
                            list.empty();
                            let content = '';
                            data.forEach(function (el) {
                                content = `${content} <div class="flex items-center text-gray-700 mt-2">
                      <input type="checkbox" name="permissions[]" value="${el.id}" id="checkbox-${el.id}" class="input border mr-2" >
                      <label class="cursor-pointer select-none" for="vertical-checkbox-chris-evans">${el.name}</label>
                    </div>`

                            })
                            $('.permissions_checkbox_list').html(content)
                        });


                    }


                }
            }
        </script>
@endsection