<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Kullanıcı Listesi
     *
     * @return void
     */
    public function userList()
    {
        $title = "Platform Kullanıcıları";
        $users = User::get();
        $roles = Role::get();

        return view('user-management.user-list', compact('title', 'users', 'roles'));
    }

    /**
     * Kullanıcıya Geçiş Yap
     *
     * @return void
     */
    public function loginAs($id)
    {
        session()->put('old_user', Auth::user()->id);

        Auth::loginUsingId($id);

        response()->json(['logged' => Auth::check(), 'user' => Auth::user()]);

        return redirect()->route('home');
    }

    /**
     * Kendi Kullanıcına Geçiş Yap
     *
     * @return void
     */
    public function switchOwnUser()
    {
        Auth::loginUsingId(session()->get('old_user'));

        response()->json(['logged' => Auth::check(), 'user' => Auth::user()]);

        Session::forget('old_user');

        return redirect()->route('home');
    }

    /**
     * Kullanıcı Ekle | Kullanıcı izinleri ile birlikte ekleme yapar
     * !Sabit şifre ile kullanıcı bellirleniyor... !!!daha sonra değiştirilecek.
     *
     * @param Request $request
     * @return void
     */
    public function userCreate(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('Bc202200')
            ]);

            $user->syncRoles($request->user_roles);

        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }

        return true;
    }
    
    /**
     * Kullanıcı Güncelle
     *
     * @param Request $request
     * @return void
     */
    public function userUpdate(Request $request)
    {
        try {
            
            User::where('id', $request->user_id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $user = User::find($request->user_id);

            $user->syncRoles($request->user_roles);

        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }

        return true;
    }

    /**
     * AJAX Role ait permissionlar listesi
     *
     * @param Request $request
     * @return void
     */
    public function userGetInfo(Request $request)
    {
        $user = User::find($request->user_id);
        $roles = Role::get();

        foreach ($roles as  $item) {
            if($user->hasRole($item->name))
                $item->checked = 'checked';
        }

        $data['user'] = $user;
        $data['roles'] = $roles;

        return response($data, 200);
    }

    /**
     * Permission List
     *
     * @return void
     */
    public function permissionList()
    {
        $title = "Permissions List";
        $permissions = Permission::get();

        return view('user-management.permissions-list', compact('title', 'permissions'));
    }

    /**
     * AJAX Create Permission
     *
     * @param Request $request
     * @return void
     */
    public function permissionCreate(Request $request)
    {
        try {
            Permission::create(['name' => $request->permission_name]);
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }

        return true;
    }
  
    /**
     * AJAX Create Permission
     *
     * @param Request $request
     * @return void
     */
    public function permissionUpdate(Request $request)
    {
        try {
            Permission::where('id', $request->permission_id)->update(['name' => $request->permission_name]);
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }

        return true;
    }

    /**
     * Role List
     *
     * @return void
     */
    public function userRolesList()
    {
        $title = "Roles List";
        $roles = Role::get();
        $permissions = Permission::get();

        return view('user-management.roles-list', compact('title', 'roles', 'permissions'));
    }

    /**
     * AJAX Create Role
     *
     * @param Request $request
     * @return void
     */
    public function roleCreate(Request $request)
    {
        try {
            $permissions = Permission::whereIn('id', $request->permission_ids)->get();
            $role = Role::create(['name' => $request->role_name]);
            $role->syncPermissions($permissions);
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }

        return true;
    }

    /**
     * AJAX Role ait permissionlar listesi
     *
     * @param Request $request
     * @return void
     */
    public function roleHasPermissions(Request $request)
    {
        $rolePermissions = DB::table('role_has_permissions')->select('permission_id')->where('role_id', $request->role_id)->get();
        $arrayData = array_map(function($item) {
            return $item->permission_id; 
        }, $rolePermissions->toArray());
        $permissions = Permission::get();

        $data = [];
        foreach ($permissions as $item) {
            if(in_array($item->id, $arrayData))
                $item->checked = 'checked';

            $data[] = $item;
        }

        return view('user-management.partials.role-permision-list-item', compact('data'));
    }

    /**
     * Role Update
     *
     * @param Request $request
     * @return void
     */
    public function roleUpdate(Request $request)
    {
        try {
            $permissions = Permission::whereIn('id', $request->permission_ids)->get();
            $role = Role::find($request->role_id);
            $role->syncPermissions($permissions);
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }

        return true;
    }
}