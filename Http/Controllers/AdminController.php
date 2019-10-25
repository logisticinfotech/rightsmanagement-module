<?php

namespace Modules\RightsManagement\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

use Hash;
use View;
use Auth;
use DataTables;

class AdminController extends Controller
{
    public function __construct(Admin $model) {

        $this->middleware('permission:admin_view', ['only' => ['index', 'getDatatable']]);
        $this->middleware('permission:admin_add', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin_edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin_delete', ['only' => ['destroy']]);

        $this->moduleName = "Admins";
        $this->moduleRoute = url('admins/admins');
        $this->moduleView = "admins";
        $this->model = $model;

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('moduleView', $this->moduleView);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.$this->moduleView.index");
    }

    public function getDatatable(Request $request)
    {
        $result = $this->model::with('roles')->get();
        return DataTables::of($result)->addIndexColumn()->make(true);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authUser = Auth::guard('admin')->user();
        $roles = Role::select('*');

        if (!$authUser->hasRole('super_admin')) {
            $roles = $roles->where('name', '!=', 'super_admin');
        }

        $roles = $roles->get();

        $viewData = [
            "roles" => $roles
        ];

        return view("admin.general.create", $viewData);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $input = $request->only(['name', 'email']);
        $input['password'] = Hash::make($request->password);

        try {
            $admin = $this->model::create($input);

            if ($admin) {
                $roles = [];
                if ($request->has('roles')) {
                    $roles = $request->roles;
                }
                $admin->syncRoles($roles);
                return redirect($this->moduleRoute)->with("success", $this->moduleName . " Created Successfully");
            }
            return redirect($this->moduleRoute)->with("error", "Sorry, Something went wrong please try again");

        } catch (\Exception $e) {
            return redirect($this->moduleRoute)->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $authUser = Auth::guard('admin')->user();
        $admin = $this->model::find($id);
        $admin['roles'] = $admin->getRoleNames();

        $roles = Role::select('*');

        if (!$authUser->hasRole('super_admin')) {
            $roles = $roles->where('name', '!=', 'super_admin');
        }

        $roles = $roles->get();

        $viewData = [
            "result" => $admin,
            "roles" => $roles
        ];

        return view("admin.general.edit", $viewData);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,id,'.$id],
        ]);

        $input = $request->only(['name', 'email']);

        try {
            $admin = $this->model::find($id);
            if ($admin) {
                $isSaved = $admin->update($input);
                if ($isSaved) {
                    $roles = [];
                    if ($request->has('roles')) {
                        $roles = $request->roles;
                    }
                    $admin->syncRoles($roles);

                    return redirect($this->moduleRoute)->with("success", $this->moduleName . " Updated Successfully");
                }
            }

            return redirect($this->moduleRoute)->with("error", "Sorry, Something went wrong please try again");

        } catch (\Exception $e) {
            return redirect($this->moduleRoute)->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = [];

        $responseData = $this->model::find($id);

        if ($responseData) {
            $res = $this->model::whereId($id)->delete();
            if ($res) {
                $result['message'] = $this->moduleName . " Deleted.";
                $result['code'] = 200;
            } else {
                $result['message'] = "Error while deleting " . $this->moduleName;
                $result['code'] = 400;
            }
        } else {
            $result['message'] = $this->moduleName . " not Found!";
            $result['code'] = 400;
        }

        return response()->json($result, $result['code']);
    }
}
