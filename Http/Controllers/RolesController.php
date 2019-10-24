<?php

namespace Modules\RightsManagement\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use View;
use DataTables;

class RolesController extends Controller
{

    public function __construct(Role $model) {
        $this->moduleName = "Roles";
        $this->moduleRoute = url(config('config.routePrefix') .'/rightsmanagement/roles');
        $this->moduleView = "roles";
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
        // view()->share('isIndexPage', true);
        return view("rightsmanagement::admin.$this->moduleView.index");
    }

    public function getDatatable(Request $request)
    {
        $result = $this->model::all();
        return DataTables::of($result)->addIndexColumn()->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("rightsmanagement::admin.general.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only(['name', 'display_name', 'description']);

        try {
            $isSaved = $this->model::create($input);

            if ($isSaved) {
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
        $result = $this->model::find($id);
        if ($result) {
            return view("rightsmanagement::admin.general.edit", compact("result"));
        }
        return redirect($this->moduleRoute)->with("error", "Sorry, $this->moduleName not found");
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
        $input = $request->only(['name', 'display_name', 'description']);
        try {
            $result = $this->model::find($id);
            if ($result) {
                $isSaved = $result->update($input);
                if ($isSaved) {
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
