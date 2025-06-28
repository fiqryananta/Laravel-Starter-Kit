<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if (post_request($request)) {

            $data = Role::withCount('users');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('count_user', function ($row) {
                    return $row->users_count;
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex align-items-center gap-1">
                            <a href="' . route('role.edit', $row->id) . '" class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
                                <i class="material-symbols-outlined fs-16 text-body">edit</i>
                            </a>
                            <button class="ps-0 border-0 bg-transparent lh-1 position-relative top-2 delete-btn" data-id="' . $row->id . '">
                                <i class="material-symbols-outlined fs-16 text-danger">delete</i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);

        } else {

            $roles = Role::with('permissions')->get();

            $this->data['title'] = 'Role - ' . env('APP_NAME');
            $this->data['roles'] = $roles;

            return view('backend/role/index', $this->data);

        }

    }
    
    public function add(Request $request)
    {
        if (post_request($request)) {

            $rules = [
                'name' => 'required|string|unique:roles,name',
                'permissions' => 'array',
            ];
            
            $message = [
                'name.required' => 'Nama Harus Diisi',
                'name.unique' => 'Nama Role Sudah Ada Sebelumnya',
            ];
            
            $validate = validation($rules, env('APP_ENV') == 'production' ? [] : $message);
            if ($validate) {
                return api_response(422, false, $validate, null);
            }

            $role = Role::create(['name' => $request->name]);

            if ($request->filled('permissions')) {
                $role->givePermissionTo($request->permissions);
            }

            $data = [
                'redirectTo' => route('role.index')
            ];

            return api_response(200, true, 'Silahkan Klik Untuk Melanjutkan', $data);
            
        } else {
                
            $permissions = Permission::all()->groupBy(function ($p) {
                return explode('-', $p->name)[0];
            });
            
            $this->data['title'] = 'Tambah Role - ' . env('APP_NAME');

            $this->data['permissions'] = $permissions;

            return view('backend/role/form', $this->data);

        }

    }
    
    public function edit(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        if (post_request($request)) {

            $rules = [
                'name' => 'required|string|unique:roles,name,' . $role->id,
                'permissions' => 'array',
            ];
            
            $message = [
                'name.required' => 'Nama Harus Diisi',
                'name.unique' => 'Nama Role Sudah Ada Sebelumnya',
            ];
            
            $validate = validation($rules, env('APP_ENV') == 'production' ? [] : $message);
            if ($validate) {
                return api_response(422, false, $validate, null);
            }

            $edit = $role->update(['name' => $request->name]);

            if ($edit) {
                
                $role->syncPermissions([]);
                            
                if ($request->filled('permissions')) {
                    $role->givePermissionTo($request->permissions);
                }

                $data = [
                    'redirectTo' => route('role.index')
                ];

                return api_response(200, true, 'Silahkan Klik Untuk Melanjutkan', $data);

            } else {

                return api_response(422, false, 'Silahkan Coba Lagi');

            }
            
        } else {
                
            $permissions = Permission::all()->groupBy(function ($p) {
                return explode('-', $p->name)[0];
            });

            $rolePermissions = $role->permissions->pluck('name')->toArray();
            
            $this->data['title'] = 'Edit Role - ' . env('APP_NAME');

            $this->data['permissions'] = $permissions;
            $this->data['data'] = $role;
            $this->data['rolePermissions'] = $rolePermissions;

            return view('backend/role/form', $this->data);

        }

    }
    
    public function delete(Request $request, $id)
    {
        $data = Role::findOrFail($id);
        
        if ($data->delete()) {
            return api_response(200, true, 'Data Berhasil Dihapus');
        } else {
            return api_response(500, false, 'Silahkan Coba Lagi');
        }

        return true;
    }
}
