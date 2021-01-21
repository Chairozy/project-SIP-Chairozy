<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    //
    public function __construct()
    {
        $this->RoleModel = new Role();
        $this->UserModel = new User();
    }

    public function identUserRole($role)
    {
        $riur = $this->UserModel->allData();
        for ($i = 0; $i < count($riur); $i++){
            for ($e = 0; $e < count($role); $e++){
                if ($riur[$i]->role_id == $role[$e]->id) {
                    $riur[$i]->role_id = $role[$e]->name;
                }
            }
        }
        return $riur;
    }

    public function idRole($name)
    {
        $colrole = $this->RoleModel->allData();
        foreach($colrole as $itsrole)
        {
            if ($name == $itsrole->name)
            {
                return $itsrole->id;
            }
        }
    }

    public function namingRole($id)
    {
        $colrole = $this->RoleModel->allData();
        foreach($colrole as $itsrole)
        {
            if ($id == $itsrole->id)
            {
                return $itsrole->name;
            }
        }
    }

    public function index() {
        $data = [
            'all' => $this->identUserRole($this->RoleModel->allData()),
            'me' => '1'
        ];

        return view('user', $data);
    }

    public function addData()
    {
        $data = ['me' => '1'];
        return view('useradd', $data);
    }

    public function detail(Request $request)
    {
        $id = $request->session()->get('id');
        $one = $this->UserModel->oneData($id);
        $one->role_id = $this->namingRole($one->role_id);
        $data = ['me' => '1', 'ct' => $one];

        return view('userdetail', $data);
    }

    public function direct(Request $request, $id)
    {
        $request->session()->put('id', $id);
        return redirect()->route('detail');
    }

    public function sendUser()
    {
        Request()->validate([
            'name' => 'required|min:4',
            'username' => 'required|min:3',
            'email' => 'required|unique:users',
            'password' => 'required|min:8|same:c_password',
            'c_password' => 'same:password'
        ], [
            'name.required' => 'Nama belum di isi',
            'name.min' => 'Minimal 4 karakter',
            'username.required' => 'Username Belum di isi',
            'username.min' => 'Minimal 3 karakter',
            'email.required' => 'Email belum di isi',
            'email.unique' => 'Email ini sudah digunakan',
            'password.required' => 'Password belum di isi',
            'password.min' => 'Minimal 8 karakter',
            'password.same' => 'Password confirm tidak sama',
            'c_password.same' => 'Password tidak sama'
        ]);

        $data = [
            'role_id' => $this->idRole(Request()->role),
            'name' => Request()->name,
            'username' => Request()->username,
            'email' => Request()->email,
            'password' => Hash::make(Request()->password),
            'remember_token' => Str::random(10),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->UserModel->addData($data);
        return redirect()->route('user')->with('pesan', 'Data berhasil ditambahkan');
    }

    public function updateUser(Request $request)
    {
        $id = $request->session()->get('id');
        Request()->validate([
            'name' => 'required|min:4',
            'username' => 'required|min:3',
            'email' => 'required|unique:users,email,'.$id,
            'password' => 'required|min:8|same:c_password',
            'c_password' => 'same:password'
        ], [
            'name.required' => 'Nama belum di isi',
            'name.min' => 'Minimal 4 karakter',
            'username.required' => 'Username Belum di isi',
            'username.min' => 'Minimal 3 karakter',
            'email.required' => 'Email belum di isi',
            'email.unique' => 'Email ini sudah digunakan',
            'password.required' => 'Password belum di isi',
            'password.min' => 'Minimal 8 karakter',
            'password.same' => 'Password confirm tidak sama',
            'c_password.same' => 'Password tidak sama'
        ]);

        $data = [
            'role_id' => $this->idRole(Request()->role),
            'name' => Request()->name,
            'username' => Request()->username,
            'email' => Request()->email,
            'password' => Hash::make(Request()->password),
            'remember_token' => Str::random(10),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->UserModel->editData($id, $data);
        return redirect()->route('user')->with('pesan', 'Perubahan telah disimpan');
    }

    public function delete($id)
    {
        $one = $this->UserModel->oneData($id);
        $this->UserModel->deleteData($id);
        return redirect()->route('user')->with('pesan', 'Data berhasil dihapus '.$one->name);
    }
}
