@extends('backend/layout/'.$layout)

@section('subhead')
    <title>Dashboard - Midone - Laravel Admin Dashboard Starter Kit</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto font-helvetica">
            წვის ტიპის შექმნა </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="intro-y box p-5">
                {!! Form::open(['route' => ['rolesUpdate',$role->id],'method' =>'put']) !!}
                <div class="sm:grid grid-cols-1 gap-1 mb-4">
                    <div class="relative mt-4 {{ $errors->has('role_name') ? ' has-error' : '' }}">
                        {{ Form::label('role_name', 'Role Name', ['class' => 'font-helvetica']) }}
                        {{ Form::text('role_name', $role->name, ['class' => 'input w-full border mt-2 col-span-2', 'no','placeholder'=>'Role Name...','id' => 'role_name']) }}
                        @if ($errors->has('title_ge'))
                            <span class="help-block">
                                            {{ $errors->first('title_ge') }}
                                        </span>
                        @endif
                    </div>
                </div>
                <div class="sm:grid grid-cols-1 gap-1 mb-4">
                    <div class="relative mt-4 {{ $errors->has('role_slug') ? ' has-error' : '' }}">
                        {{ Form::label('role_slug', 'Role Slug', ['class' => 'font-helvetica']) }}
                        {{ Form::text('role_slug', $role->slug, ['class' => 'input w-full border mt-2 col-span-2', 'no', 'placeholder'=>'Role Slug...', 'id' => 'role_slug']) }}
                        @if ($errors->has('role_slug'))
                            <span class="help-block">
                                            {{ $errors->first('role_slug') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="sm:grid grid-cols-1 gap-1 mb-4">
                    <div class="relative mt-4 {{ $errors->has('roles_permissions') ? ' has-error' : '' }}">
                        {{ Form::label('roles_permissions', 'Roles Permissions', ['class' => 'font-helvetica']) }}
                        <select name="roles_permissions[]" data-placeholder="Select permissions" class="select2 w-full"
                                multiple>
                            @if($permissions)
                                @foreach($permissions as $per)
                                    <option value="{{$per->id}}" {{in_array($per->slug,array_column($rolePermissions,'slug')) ? 'selected' : ''}}>{{$per->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="relative mt-5">
                    <button type="submit" name="user_add_submit"
                            class="button w-25 bg-theme-1 text-white font-helvetica">დამატება
                    </button>
                </div>
                {!! Form::close() !!}

            </div>
        </div>

    </div>
@endsection