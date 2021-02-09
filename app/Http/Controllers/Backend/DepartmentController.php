<?php
/**
 *  app/Http/Controllers/Backend/DepartmentController.php
 *
 * User:
 * Date-Time: 04.11.20
 * Time: 15:03
 * @author Vito Makhatadze <vitomaxatadze@gmail.com>
 */

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use App\Models\Department;
use App\Models\User;
use Exception;
use Illuminate\Console\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class DepartmentController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();
        $categories = Category::all();

        $users = User::all();

        // Get Countries

        return view('backend.module.departments.index', [
            'departments' => $departments,
            'categories' => $categories,
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function createDepartments(Request $request)
    {
        if ($request->post()) {
            $request->validate([
                'department_name' => 'required|max:255',
            ]);

            $department = new Department();
            $department->name = $request->department_name;
            $department->save();

            if ($request->department_heads != null) {
                foreach ($request->department_heads as $head) {
                    $department->head()->attach($head);
                    $department->save();
                }
            }

            if ($request->department_staff != null) {
                foreach ($request->department_staff as $staff) {
                    if ($request->department_heads != null) {
                        if (!in_array($staff, $request->department_heads)) {
                            $department->users()->attach($staff);
                            $department->save();
                        }
                    } else {
                        $department->users()->attach($staff);
                        $department->save();
                    }
                }
            }

            return redirect('admin/departments')->with('success', 'Department create successfully');

        }

        $users = User::where('username', '!=', 'investgroup')->get();

        return view('backend.module.departments.create-departments')->with('users', $users);

    }

    /**
     * Update department item.
     *
     * @param Request $request
     *
     * @param Department $department
     *
     * @return Application|\Illuminate\Contracts\Foundation\Application|Factory|View|RedirectResponse|Response|Redirector
     */
    public function updateDepartments(Request $request, Department $department)
    {
        if ($request->post()) {
            $request->validate([
                'department_name' => 'required|max:255',
            ]);

            $department->name = $request->department_name;
            $department->save();

            $department->users()->detach();
            $department->head()->detach();


            if ($request->department_heads != null) {
                foreach ($request->department_heads as $head) {
                    $department->head()->attach($head);
                    $department->save();
                }
            }
            
            if ($request->department_staff != null) {
                foreach ($request->department_staff as $staff) {
                    if($request->department_heads != null) {

                        if (!in_array($staff, $request->department_heads)) {
                            $department->users()->attach($staff);
                            $department->save();
                        }
                    } else {
                        $department->users()->attach($staff);
                        $department->save();
                    }
                }
            }

            return redirect('admin/departments')->with('success', 'Department updated successfully');

        }


        $departmentStaff = $department->users()->select('id')->get()->toArray();
        $departmentHead = $department->head()->select('id')->get()->toArray();

        $users = User::where('username', '!=', 'investgroup')->get();

        return view('backend.module.departments.update-departments', [
            'users' => $users,
            'department' => $department,
            'departmentStaff' => $departmentStaff,
            'departmentHead' => $departmentHead
        ]);
    }

    /**
     * Delete department item.
     *
     * @param Department $department
     *
     * @return Application|\Illuminate\Contracts\Foundation\Application|Factory|View|RedirectResponse|Response|Redirector
     * @throws Exception
     */
    public function deleteDepartments(Department $department)
    {
        // Remove department staff
        $department->users()->detach();

        // Remove department head
        $department->head()->detach();

        // Remove and delete department category
        $department->categories()->delete();
        $department->categories()->detach();


        // Delete department item
        $department->delete();

        return redirect('admin/departments')->with('success', 'Department deleted successfully');

    }


    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function createCategories(Request $request)
    {
        if ($request->post()) {
            $request->validate([
                'category_name' => 'required|max:255',
                'department' => 'required'
            ]);

            $category = new Category();
            $category->name = $request->category_name;
            $category->department_id = $request->department;
            $category->save();

            if ($request->department_group != null) {
                foreach ($request->department_group as $group) {
                    if ($group != $request->department) {
                        $category->departments()->attach($group);
                        $category->save();
                    }
                }
            }

            return redirect('admin/departments')->with('success', 'Category create successfully');

        }

        $departments = Department::all();

        return view('backend.module.departments.create-categories', [
            'departments' => $departments
        ]);

    }

    /**
     * Update department item.
     *
     * @param Request $request
     *
     * @param Category $category
     *
     * @return Application|\Illuminate\Contracts\Foundation\Application|Factory|View|RedirectResponse|Response|Redirector
     */
    public function categoriesUpdate(Request $request, Category $category)
    {
        if ($request->post()) {
            $request->validate([
                'category_name' => 'required|max:255',
                'department' => 'required',
            ]);

            $category->name = $request->category_name;
            $category->department_id = $request->department;
            $category->save();

            $category->departments()->detach();


            if ($request->department_group != null) {
                foreach ($request->department_group as $group) {
                    if ($group != $request->department) {
                        $category->departments()->attach($group);
                        $category->save();
                    }
                }
            }

            return redirect('admin/departments')->with('success', 'Category updated successfully');

        }

        $departments = Department::all();

        $departmentGroup = $category->departments()->select('id')->get()->toArray();

        return view('backend.module.departments.update-categories', [
            'category' => $category,
            'departments' => $departments,
            'departmentGroup' => $departmentGroup
        ]);
    }


    /**
     * Delete Category item.
     *
     * @param Category $category
     *
     * @return Application|\Illuminate\Contracts\Foundation\Application|Factory|View|RedirectResponse|Response|Redirector
     */
    public function deleteCategories(Category $category)
    {

        // Remove category departments
        $category->departments()->detach();

        // Delete Category item
        $category->delete();

        return redirect('admin/departments')->with('success', 'Category deleted successfully');

    }

}
