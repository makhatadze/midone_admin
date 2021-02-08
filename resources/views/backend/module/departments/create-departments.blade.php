@extends('backend/layout/'.$layout)

@section('subhead')
    <title>LLC - Create Departments</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto font-helvetica">
            Create departments </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="intro-y box p-5">
                {!! Form::open(['route' => 'departmentsCreate','method' =>'post',]) !!}
                <div class="sm:grid grid-cols-1 gap-1 mb-4">
                    <div class="relative mt-4 {{ $errors->has('department_name') ? ' has-error' : '' }}">
                        {{ Form::label('department_name', 'Department Name', ['class' => 'font-helvetica']) }}
                        {{ Form::text('department_name', '', ['class' => 'input w-full border mt-2 col-span-2', 'no','placeholder'=>'Department Name...','id' => 'department_name']) }}
                        @if ($errors->has('department_name'))
                            <span class="help-block">
                                            {{ $errors->first('department_name') }}
                                        </span>
                        @endif
                    </div>
                </div>
                <div class="sm:grid grid-cols-1 gap-1 mb-4">
                    <div class="relative mt-4 {{ $errors->has('department_heads') ? ' has-error' : '' }}">
                        {{ Form::label('department_heads', 'Department Heads', ['class' => 'font-helvetica']) }}
                        <select name="department_heads[]" data-placeholder="Select Department Heads"
                                class="select2 w-full"
                                multiple>
                            @if($users)
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->username}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="sm:grid grid-cols-1 gap-1 mb-4">
                    <div class="relative mt-4 {{ $errors->has('department_staff') ? ' has-error' : '' }}">
                        {{ Form::label('department_staff', 'Department Staff', ['class' => 'font-helvetica']) }}
                        <select name="department_staff[]" data-placeholder="Select Department Staff"
                                class="select2 w-full"
                                multiple>
                            @if($users)
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->username}}</option>
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