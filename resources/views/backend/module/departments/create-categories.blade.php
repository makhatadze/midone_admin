@extends('backend/layout/'.$layout)

@section('subhead')
    <title>LLC - Create Categories</title>
@endsection

@section('subcontent')
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto font-helvetica">
            Create Categories </h2>
    </div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-8">
            <div class="intro-y box p-5">
                {!! Form::open(['route' => 'createCategories','method' =>'post',]) !!}
                <div class="sm:grid grid-cols-1 gap-1 mb-4">
                    <div class="relative mt-4 {{ $errors->has('category_name') ? ' has-error' : '' }}">
                        {{ Form::label('category_name', 'Category Name', ['class' => 'font-helvetica']) }}
                        {{ Form::text('category_name', '', ['class' => 'input w-full border mt-2 col-span-2', 'no','placeholder'=>'Category Name...','id' => 'department_name']) }}
                        @if ($errors->has('category_name'))
                            <span class="help-block">
                                            {{ $errors->first('category_name') }}
                                        </span>
                        @endif
                    </div>
                </div>
                <div class="sm:grid grid-cols-1 gap-1 mb-4">
                    <div class="relative mt-4 {{ $errors->has('department') ? ' has-error' : '' }}">
                        {{ Form::label('department', 'Department (Main)', ['class' => 'font-helvetica']) }}
                        <select name="department" data-placeholder="Select Department" class="select2 w-full">
                            @if($departments)
                                @foreach($departments as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('department'))
                            <span class="help-block">
                                            {{ $errors->first('department') }}
                                        </span>
                        @endif
                    </div>
                </div>
                <div class="sm:grid grid-cols-1 gap-1 mb-4">
                    <div class="relative mt-4 {{ $errors->has('department_group') ? ' has-error' : '' }}">
                        {{ Form::label('department_group', 'Department Group', ['class' => 'font-helvetica']) }}
                        <select name="department_group[]" data-placeholder="Select Department Group"
                                class="select2 w-full"
                                multiple>
                            @if($departments)
                                @foreach($departments as $department)
                                    <option value="{{$department->id}}">{{$department->name}}</option>
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