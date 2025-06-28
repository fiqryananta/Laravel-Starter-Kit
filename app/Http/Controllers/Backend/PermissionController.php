<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if (post_request($request)) {

            $data = Permission::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('group', function ($row) {
                    $parts = explode('-', $row->name);
                    return $parts[0] ?? $row->name;
                })
                ->addColumn('detail', function ($row) {
                    return $row->name;
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex align-items-center gap-1">
                            <a href="' . route('permission.edit', $row->id) . '" class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                <i class="material-symbols-outlined fs-16 text-body">edit</i>
                            </a>
                            <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2 delete-btn" data-id="' . $row->id . '">
                                <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['action', 'detail'])
                ->make(true);

        } else {
                
            $permission = Permission::get();

            $this->data['title'] = 'Permission - ' . env('APP_NAME');
            $this->data['permission'] = $permission;

            return view('backend/permission/index', $this->data);

        }

    }
    
    public function add(Request $request)
    {
        if (post_request($request)) {

            $rules = [
                'name' => 'required|unique:permissions,name',
                'default_permission' => 'nullable',
            ];
            
            $message = [
                'name.required' => 'Nama Harus Diisi',
                'name.unique' => 'Nama Permission Sudah Ada Sebelumnya',
            ];
            
            $validate = validation($rules, env('APP_ENV') == 'production' ? [] : $message);
            if ($validate) {
                return api_response(422, false, $validate, null);
            }

            if ($request->default_permission) {

                $base = $request->name;
                $defaults = ['index', 'add', 'edit', 'delete'];

                foreach ($defaults as $action) {
                    $permName = "{$base}-{$action}";
                    if (!Permission::where('name', $permName)->exists()) {
                        Permission::create(['name' => $permName]);
                    }
                }

            } else {

                $base = $request->name;
                Permission::create(['name' => $base]);

            }

            $data = [
                'redirectTo' => route('permission.index')
            ];

            return api_response(200, true, 'Silahkan Klik Untuk Melanjutkan', $data);
            
        } else {
                
            $this->data['title'] = 'Tambah Permission - ' . env('APP_NAME');

            return view('backend/permission/form', $this->data);

        }

    }
    
    public function edit(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        if (post_request($request)) {

            $rules = [
                'name' => 'required|unique:permissions,name,' . $permission->id,
            ];
            
            $message = [
                'name.required' => 'Nama Harus Diisi',
                'name.unique' => 'Nama Permission Sudah Ada Sebelumnya',
            ];
            
            $validate = validation($rules, env('APP_ENV') == 'production' ? [] : $message);
            if ($validate) {
                return api_response(422, false, $validate, null);
            }

            $edit = $permission->update(['name' => $request->name]);

            if ($edit) {

                $data = [
                    'redirectTo' => route('permission.index')
                ];

                return api_response(200, true, 'Silahkan Klik Untuk Melanjutkan', $data);

            } else {

                return api_response(422, false, 'Silahkan Coba Lagi');

            }
            
        } else {
                
            $this->data['title'] = 'Edit Permission - ' . env('APP_NAME');
            $this->data['data'] = $permission;

            return view('backend/permission/form', $this->data);

        }

    }
    
    public function delete(Request $request, $id)
    {
        $data = Permission::findOrFail($id);
        
        if ($data->delete()) {
            return api_response(200, true, 'Data Berhasil Dihapus');
        } else {
            return api_response(500, false, 'Silahkan Coba Lagi');
        }

        return true;
    }
}
