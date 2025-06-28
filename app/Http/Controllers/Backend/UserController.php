<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;

use App\Models\User;
use App\Models\Company;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (post_request($request)) {

            $data = User::query();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('role', function ($row) {
                    return $row->getRole()->name ?? '-';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex align-items-center gap-1">
                            <a href="' . route('user.edit', $row->id) . '" class="ps-0 border-0 bg-transparent lh-1 position-relative top-2">
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
                
            $user = User::get();

            $this->data['title'] = 'Pengguna - ' . env('APP_NAME');
            $this->data['user'] = $user;

            return view('backend/user/index', $this->data);

        }

    }
    
    public function add(Request $request)
    {
        if (post_request($request)) {

            $rules = [
                'name' => 'required',
                'email' => 'required|string|email|unique:users',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/'
                ],
                'role' => 'required',
                'copmany_id' => 'nullable',
            ];
            
            $message = [
                'name.required' => 'Nama Harus Diisi',
                'email.required' => 'Email Harus Diisi',
                'email.email' => 'Email Tidak Valid',
                'email.unique' => 'Email Sudah Digunakan Oleh Pengguna Lain',
                'password.required' => 'Password Harus Diisi',
                'password.min' => 'Password harus minimal 8 karakter.',
                'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
                'role.required' => 'Role Harus Dipilih.'
            ];
            
            $validate = validation($rules, env('APP_ENV') == 'production' ? [] : $message);
            if ($validate) {
                return api_response(422, false, $validate, null);
            }

            $user = User::create([ 
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'copmany_id' => $request->copmany_id ?? null,
            ]);

            $role = Role::find($request->role);
            $user->assignRole($role->name);

            $data = [
                'redirectTo' => route('user.index')
            ];

            return api_response(200, true, 'Silahkan Klik Untuk Melanjutkan', $data);
            
        } else {

            $roles = Role::get();
            $company = Company::get();
                
            $this->data['title'] = 'Tambah Pengguna - ' . env('APP_NAME');
            $this->data['roles'] = $roles;
            $this->data['company'] = $company;

            return view('backend/user/form', $this->data);

        }

    }
    
    public function edit(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (post_request($request)) {

            $rules = [
                'name' => 'required',
                'email' => 'required|string|email|unique:permissions,name,' . $user->id,
                'password' => [
                    'nullable',
                    'string',
                    'min:8',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/'
                ],
                'role' => 'required',
                'copmany_id' => 'nullable',
            ];
            
            $message = [
                'name.required' => 'Nama Harus Diisi',
                'email.required' => 'Email Harus Diisi',
                'email.email' => 'Email Tidak Valid',
                'email.unique' => 'Email Sudah Digunakan Oleh Pengguna Lain',
                'password.min' => 'Password harus minimal 8 karakter.',
                'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
                'role.required' => 'Role Harus Dipilih.'
            ];
            
            $validate = validation($rules, env('APP_ENV') == 'production' ? [] : $message);
            if ($validate) {
                return api_response(422, false, $validate, null);
            }

            $data = [
                'name'       => $request->name,
                'email'      => $request->email,
                'copmany_id' => $request->copmany_id ?? null,
            ];

            if (!empty($request->password)) {
                $data['password'] = Hash::make($request->password);
            }

            $edit = $user->update($data);

            $role = Role::find($request->role);
            $user->syncRoles([$role->name]);

            if ($edit) {

                $data = [
                    'redirectTo' => route('user.index')
                ];

                return api_response(200, true, 'Silahkan Klik Untuk Melanjutkan', $data);

            } else {

                return api_response(422, false, 'Silahkan Coba Lagi');

            }
            
        } else {

            $roles = Role::get();
            $company = Company::get();
                
            $this->data['title'] = 'Edit Pengguna - ' . env('APP_NAME');
            $this->data['data'] = $user;
            $this->data['roles'] = $roles;
            $this->data['company'] = $company;

            return view('backend/user/form', $this->data);

        }

    }
    
    public function delete(Request $request, $id)
    {
        $data = User::findOrFail($id);
        
        if ($data->delete()) {
            return api_response(200, true, 'Data Berhasil Dihapus');
        } else {
            return api_response(500, false, 'Silahkan Coba Lagi');
        }

        return true;
    }
}
