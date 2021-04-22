@extends('backend/layout/'.$layout)

@section('subhead')
    <title>Insite - Departments Categories</title>
@endsection

@section('subcontent')
    <div class="row mt-5">
        <div class="col-lg-12">
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="flex">
        <div class="w-1/2 xxl:col-span-3 -mb-10 pb-10 mb-5 mr-5">
            @if($loggedin_user->hasPermission('create_department'))
                <div class="w-full sm:w-auto flex mt-4 sm:mt-0 mt-5">
                    <a href="{{route('departmentsCreate')}}" class="button text-white bg-theme-1 shadow-md mr-2">Create
                        New Department</a>
                </div>
            @endif
            <div class="intro-y datatable-wrapper box p-5 mt-5">
                <table class="table table-report table-report--bordered display datatable w-full">
                    <thead>
                    <tr>
                        <th class="border-b-2 whitespace-no-wrap">#</th>
                        <th class="border-b-2 text-center whitespace-no-wrap">Name</th>
                        <th class="border-b-2 text-center whitespace-no-wrap">Tools</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($departments as $department)
                        <tr>
                            <td class="border-b">
                                <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $department->id }}</div>
                            </td>
                            <td class="border-b">
                                <div class="flex items-center sm:justify-center "> {{ $department->name }}</div>
                            </td>
                            <td class="text-center border-b">
                                <div class="flex sm:justify-center items-center">
                                    @if($loggedin_user->hasPermission('update_department'))
                                        <a class="flex items-center mr-3"
                                           href="{{route('departmentsUpdate',$department->id)}}"> <i
                                                    data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                    @endif
                                    @if($loggedin_user->hasPermission('delete_department'))
                                        <a class="flex items-center text-theme-6" href="javascript:;"
                                           data-toggle="modal" data-userid="{{$department['id']}}"
                                           onclick="deleteDepartmentModal({{$department['id']}})"
                                           data-target="#deleteDepartmentModal"> <i data-feather="trash-2"
                                                                                    class="w-4 h-4 mr-1"></i> Delete
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>


        <div class="modal" id="deleteDepartmentModal">
            <div class="modal__content">
                <div class="p-5 text-center">
                    <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-gray-600 mt-2">You want to delete this item?</div>
                </div>
                <form method="POST" action="" class="department-delete-form">

                    <div class="px-5 pb-8 text-center">

                        <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">close
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


        <div class="w-1/2 xxl:col-span-3 -mb-10 pb-10 mb-5">
            <div class="w-full sm:w-auto flex mt-4 sm:mt-0 mt-5">
                @if($loggedin_user->hasPermission('create_department'))
                <a href="{{route('createCategories')}}" class="button text-white bg-theme-1 shadow-md mr-2">Create New
                    Category</a>
                @endif
            </div>
            <div class="intro-y datatable-wrapper box p-5 mt-5">
                <table class="table table-report table-report--bordered display datatable w-full">
                    <thead>
                    <tr>
                        <th class="border-b-2 whitespace-no-wrap">#</th>
                        <th class="border-b-2 text-center whitespace-no-wrap">Name</th>
                        <th class="border-b-2 text-center whitespace-no-wrap">Tools</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td class="border-b">
                                <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $category->id }}</div>
                            </td>
                            <td class="border-b">
                                <div class="flex items-center sm:justify-center "> {{ $category->name }}</div>
                            </td>
                            <td class="text-center border-b">
                                <div class="flex sm:justify-center items-center">
                                    @if($loggedin_user->hasPermission('update_department'))
                                        <a class="flex items-center mr-3"
                                           href="{{route('categoriesUpdate',$category->id)}}"> <i
                                                    data-feather="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                    @endif
                                    @if($loggedin_user->hasPermission('delete_department'))
                                        <a class="flex items-center text-theme-6" href="javascript:;"
                                           data-toggle="modal" data-userid="{{$category['id']}}"
                                           onclick="deleteCategoryModal({{$category['id']}})"
                                           data-target="#deleteCategoryModal"> <i data-feather="trash-2"
                                                                                  class="w-4 h-4 mr-1"></i> Delete </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal" id="deleteCategoryModal">
        <div class="modal__content">
            <div class="p-5 text-center">
                <i data-feather="x-circle" class="w-16 h-16 text-theme-6 mx-auto mt-3"></i>
                <div class="text-3xl mt-5">Are you sure?</div>
                <div class="text-gray-600 mt-2">You want to delete this item?</div>
            </div>
            <form method="POST" action="" class="category-delete-form">

                <div class="px-5 pb-8 text-center">

                    <button type="button" data-dismiss="modal" class="button w-24 border text-gray-700 mr-1">close
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
    <script>
        function deleteDepartmentModal(e) {
            $(document).ready(function () {
                $('.department-delete-form').attr('action', `departments/delete-departments/${e}`)
            })
        }

        function deleteCategoryModal(e) {
            $(document).ready(function () {
                $('.category-delete-form').attr('action', `departments/delete-categories/${e}`)
            })
        }
    </script>
@endsection