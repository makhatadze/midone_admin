@extends('backend/layout/'.$layout)

@section('subhead')
    <title>LLC - Edit roles</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto font-helvetica">
            User Edit </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="intro-y box p-5">
                {!! Form::open(['route' => ['usersUpdate',$user->id],'method' =>'put']) !!}
                <div class="sm:grid grid-cols-2 gap-1 mb-4">
                    <div class="relative mt-4 {{ $errors->has('first_name') ? ' has-error' : '' }}">
                        {{ Form::label('first_name', 'First Name', ['class' => 'font-helvetica']) }}
                        {{ Form::text('first_name', $user->profile->first_name, ['class' => 'input w-full border mt-2 col-span-2', 'no','placeholder'=>'First Name...']) }}
                        @if ($errors->has('first_name'))
                            <span class="help-block">
                                            {{ $errors->first('first_name') }}
                                        </span>
                        @endif
                    </div>
                    <div class="relative mt-4 {{ $errors->has('last_name') ? ' has-error' : '' }}">
                        {{ Form::label('last_name', 'Last Name', ['class' => 'font-helvetica']) }}
                        {{ Form::text('last_name', $user->profile->last_name, ['class' => 'input w-full border mt-2 col-span-2', 'no', 'placeholder'=>'Last Name...']) }}
                        @if ($errors->has('last_name'))
                            <span class="help-block">
                                            {{ $errors->first('last_name') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="sm:grid grid-cols-2 gap-1 mb-4">
                    <div class="relative mt-4 {{ $errors->has('phone') ? ' has-error' : '' }}">
                        {{ Form::label('phone', 'Mobile Phone', ['class' => 'font-helvetica']) }}
                        {{ Form::text('phone', $user->profile->phone, ['class' => 'input w-full border mt-2 col-span-2', 'no','placeholder' =>'Mobile Phone...']) }}
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                            {{ $errors->first('phone') }}
                                        </span>
                        @endif
                    </div>
                    <div class="relative mt-4 {{ $errors->has('country') ? ' has-error' : '' }}">
                        <label>Country</label>
                        <div class="mt-2"><select name="country" class="select2 country-select2 w-full">
                                <option value="">Select Country</option>


                            @foreach($countries as $country)

                                    <option {{($country->code == $user->profile->country) ? 'selected' : ''}} value="{{$country->code}}">{{$country->name}}</option>
                                @endforeach
                            </select></div>
                        @if ($errors->has('country'))
                            <span class="help-block">
                                            {{ $errors->first('country') }}
                                        </span>
                        @endif
                    </div>
                </div>

                <div class="sm:grid grid-cols-2 gap-1 mb-4">
                    <div class="relative mt-4 {{ $errors->has('birthday') ? ' has-error' : '' }}">
                        <label>Birthday</label>

                        <input name="birthday" type="date"
                               value="{{Carbon\Carbon::parse($user->profile->birthday)->isoFormat('Y-MM-DD')}}"
                               class="input w-full border mt-2 flex-1">

                        @if ($errors->has('birthday'))
                            <span class="help-block">
                                            {{ $errors->first('birthday') }}
                            </span>
                        @endif
                    </div>
                    <div class="relative mt-4 {{ $errors->has('email') ? ' has-error' : '' }}">
                        {{ Form::label('email', 'Email', ['class' => 'font-helvetica']) }}
                        {{ Form::text('email', $user->email, ['class' => 'input w-full border mt-2 col-span-2', 'no', 'placeholder'=>'Email...']) }}
                        @if ($errors->has('email'))
                            <span class="help-block">
                                            {{ $errors->first('email') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="sm:grid grid-cols-2 gap-1 mb-4">
                    <div class="relative mt-4 {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label>Password</label>
                        <input type="password" name="password" autocomplete="off"
                               class="input w-full border mt-2 flex-1" placeholder="">
                        @if ($errors->has('first_name'))
                            <span class="help-block">
                                            {{ $errors->first('first_name') }}
                                        </span>
                        @endif
                    </div>
                    <div class="relative mt-4 {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label>Password Confirmation</label>
                        <input type="password" name="password_confirmation" autocomplete="off"
                               class="input w-full border mt-2 flex-1" placeholder="">
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                            {{ $errors->first('password_confirmation') }}
                                        </span>
                        @endif
                    </div>
                </div>

                <div class="relative mt-4 {{ $errors->has('roles') ? ' has-error' : '' }}">
                    <label>Role</label>
                    <div class="mt-2 roles-container">
                        <select name="user_role" id="roles-select2" onchange="roleChange(event)"
                                class="select2  w-full">
                            <option value="0">Select Role...</option>
                            @if($allRoles)
                                @foreach($allRoles as $role)
                                    <option {{(count($roles) > 0 && $roles[0]->id == $role->id) ? 'selected' : ''}} value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="relative mt-4 {{ $errors->has('roles') ? ' has-error' : '' }}" id="permissions_box">
                    <label>Permissions</label>
                    <div class="mt-2 permissions-list-container">
                        <select name="permissions[]" data-placeholder="Select permissions" id="permissions-select2"
                                class="select2 w-full"
                                multiple>
                            @if(count($rolePermissions) > 0)
                                @foreach($rolePermissions as $permission)
                                    <option {{in_array($permission->id,array_column($permissions,'id')) ? 'selected' : ''}}  value="{{$permission->id}}">{{$permission->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="relative mt-5">
                    <button type="submit" name="user_add_submit"
                            class="button w-25 bg-theme-1 text-white font-helvetica">Update
                    </button>
                </div>
                {!! Form::close() !!}

            </div>
        </div>

    </div>
    <script>
        function roleChange(e) {
            if (e.target.value !== '0') {
                $(document).ready(function () {
                    $.ajax({
                        url: `/admin/roles/permissions/${e.target.value}`,
                        method: 'get',
                        dataType: 'json',
                    }).done(function (data) {

                        if(data) {

                            console.log(data)
                            let content = '';
                            data.forEach(el => {
                                content = `${content}<option  value="${el.id}">${el.name}</option>`
                            })
                            content = `<select name="permissions[]" data-placeholder="Select permissions" id="permissions-select2" class="select2 w-full"
                                    multiple> ${content}</select>`;

                            if($('#permissions_box').hasClass('none')) {

                                $('#permissions_box').removeClass('none')
                            }
                            $('.permissions-list-container').html(content)
                            $('#permissions-select2').select2()
                        } else {
                            let content = `<select name="permissions[]" data-placeholder="Select permissions" id="permissions-select2" class="select2 w-full"
                                    multiple></select>`
                            $('.permissions-list-container').html(content)
                            $('#permissions-select2').select2()
                        }
                    });
                });

            } else {
                let content = `<select name="permissions[]" data-placeholder="Select permissions" id="permissions-select2" class="select2 w-full"
                                    multiple></select>`
                $('.permissions-list-container').html(content)
                $('#permissions-select2').select2()
            }
        }
    </script>
@endsection