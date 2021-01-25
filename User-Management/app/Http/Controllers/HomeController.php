<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\User;
use App\Models\Memory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\File;

class HomeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->RoleModel = new Role();
        $this->UserModel = new User();
    }

    //Method
    public function identUserRole()
    {
        $role = $this->RoleModel->allData();
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

    //Views
    public function index() {
        $owner = auth()->user();
        $role = $owner->getRoleNames();
        $user = User::find($owner->id);
        $data = ['me' => '2', 'ct' => $user];
        if($role == 'Admin'){
            return view('admin/dashboard', $data);
        }else{
            return view('member/dashboard', $data);
        }
    }

    public function storage() {
        $user = auth()->user();
        $file = User::find($user->id)->memory;

        $data = ['me' => '4', 'all' =>$file];
        return view('member/storage', $data);
    }

    public function keluhan() {
        $owner = auth()->user();
        $user = User::find($owner->id);

        $data = ['me' => '5', 'ct' =>$user];
        return view('member/reportbug', $data);
    }

    public function user() {
        $data = [
            'all' => $this->identUserRole(),
            'me' => '1'
        ];

        return view('admin/user', $data);
    }

    public function addData()
    {
        $data = ['me' => '1'];
        return view('admin/useradd', $data);
    }

    public function detail(Request $request)
    {
        $id = $request->session()->get('id');
        $one = User::find($id);
        $one->role_id = $this->namingRole($one->role_id);
        $data = ['me' => '1', 'ct' => $one];

        return view('admin/userdetail', $data);
    }

    public function buku() {
        $buku = Buku::all();
        $data = [
            'me' => '3',
            'ib' => $buku
        ];

        return view('member/buku', $data);
    }

    //Action
    public function uploadFile(Request $request)
    {
        $user = auth()->user();
        $fname = $request->file('file')->getClientOriginalName();
        Request()->validate(['file' => 'required|file|max:5000']);
        $path = $user->name.'/'.$fname;
        Storage::putFileAs('public/'.$user->name, $request->file('file'), $fname);
        Memory::create(['user_id' => $user->id, 'name' => $fname, 'path' => $path]);
        return redirect()->to('/memory');
    }

    public function deleteFile($id)
    {
        $file = Memory::where('id', $id)->first();
        Storage::delete('public/'.$file->path);
        Memory::where('id', $id)->delete();
        return redirect()->to('/memory');
    }

    public function deleteFiles(Request $request)
    {
        foreach($request->id as $id){
            $file = Memory::where('id', $id)->first();
            Storage::delete('public/'.$file->path);
            Memory::where('id', $id)->delete();
        }
        return redirect()->to('/memory');
    }

    public function direct(Request $request, $id)
    {
        $request->session()->put('id', $id);
        return redirect()->route('detail');
    }

    public function sendUser(Request $request)
    {
        Request()->validate([
            'name' => 'required|min:4',
            'username' => 'required|min:3',
            'email' => 'required|unique:users',
            'phone' => 'required|numeric|min:8',
            'alamat' => 'required',
            'tgl_lahir' => 'required',
            'password' => 'required|min:8|same:c_password',
            'c_password' => 'same:password'
        ], [
            'name.required' => 'Nama belum di isi',
            'name.min' => 'Minimal 4 karakter',
            'username.required' => 'Username Belum di isi',
            'username.min' => 'Minimal 3 karakter',
            'email.required' => 'Email belum di isi',
            'email.unique' => 'Email ini sudah digunakan',
            'phone.required' => 'Nomor HP belum di isi',
            'phone.numeric' => 'Hanya boleh memasukkan angka saja',
            'phone.min' => 'Minimal 8 digit',
            'alamat.required' => 'Alamat belum di isi',
            'tgl_lahir.required' => 'Tnggal lahir belum di isi',
            'password.required' => 'Password belum di isi',
            'password.min' => 'Minimal 8 karakter',
            'password.same' => 'Password confirm tidak sama',
            'c_password.same' => 'Password tidak sama'
        ]);
        
        if (is_null($request->file('photo'))) {
            $path = '';
        }else{
            $fname = $request->file('photo')->getClientOriginalName();
            $path = Request()->name.'/'.$fname;
            Storage::putFileAs('public/'.Request()->name, $request->file('photo'), $fname);
        }

        $user = User::create([
            'role_id' => $this->idRole(Request()->role),
            'photo' => $path,
            'name' => Request()->name,
            'username' => Request()->username,
            'email' => Request()->email,
            'gender' => Request()->gender,
            'phone' => Request()->phone,
            'alamat' => Request()->alamat,
            'kebangsaan' => Request()->kebangsaan,
            'tgl_lahir' => Request()->tgl_lahir,
            'password' => bcrypt(Request()->password),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $user->assignRole(Request()->role);

        return redirect()->route('user')->with('pesan', 'Data berhasil ditambahkan');
    }

    public function updateUser(Request $request)
    {
        $id = $request->session()->get('id');
        Request()->validate([
            'name' => 'required|min:4',
            'username' => 'required|min:3',
            'email' => 'required|unique:users,email,'.$id,
            'phone' => 'required|numeric|min:8',
            'alamat' => 'required',
            'tgl_lahir' => 'required',
            'password' => 'required|min:8|same:c_password',
            'c_password' => 'same:password'
        ], [
            'name.required' => 'Nama belum di isi',
            'name.min' => 'Minimal 4 karakter',
            'username.required' => 'Username Belum di isi',
            'username.min' => 'Minimal 3 karakter',
            'email.required' => 'Email belum di isi',
            'email.unique' => 'Email ini sudah digunakan',
            'phone.required' => 'Nomor HP belum di isi',
            'phone.numeric' => 'Hanya boleh memasukkan angka saja',
            'phone.min' => 'Minimal 8 digit',
            'alamat.required' => 'Alamat belum di isi',
            'tgl_lahir.required' => 'Tnggal lahir belum di isi',
            'password.required' => 'Password belum di isi',
            'password.min' => 'Minimal 8 karakter',
            'password.same' => 'Password confirm tidak sama',
            'c_password.same' => 'Password tidak sama'
        ]);

        $data = User::find($id);

        if ($this->idRole(Request()->role) != $data->role_id) {
            $data->removeRole($this->namingRole($data->role_id));
            $data->assignRole(Request()->role);
        }

        if (is_null($request->file('photo'))) {
            $path = $data->photo;
        }else{
            Storage::delete('public/'.$data->photo);
            $fname = $request->file('photo')->getClientOriginalName();
            $path = Request()->name.'/'.$fname;
            Storage::putFileAs('public/'.Request()->name, $request->file('photo'), $fname);
        }

        User::find($id)->update([
            'role_id' => $this->idRole(Request()->role),
            'photo' => $path,
            'name' => Request()->name,
            'username' => Request()->username,
            'email' => Request()->email,
            'gender' => Request()->gender,
            'phone' => Request()->phone,
            'alamat' => Request()->alamat,
            'kebangsaan' => Request()->kebangsaan,
            'tgl_lahir' => Request()->tgl_lahir,
            'password' => bcrypt(Request()->password),
            'updated_at' => now()
        ]);

        return redirect()->route('user')->with('pesan', 'Perubahan telah disimpan');
    }

    public function delete($id)
    {
        $user = User::find($id);
        Storage::delete('public/'.$user->photo);
        $hismemory = Memory::where('user_id', $id)->get();
        foreach ($hismemory as $file) {
            Storage::delete('public/'.$file->path);
        }
        $hismemory->each->delete();
        $user->removeRole($this->namingRole($user->role_id));
        $name = $user->name;
        $user->delete();
        return redirect()->route('user')->with('pesan', 'Data berhasil dihapus '.$name);
    }

    public function deletes(Request $request)
    {
        foreach($request->id as $id){
            $user = User::find($id);
            $hismemory = Memory::where('user_id', $id)->get();
            foreach ($hismemory as $file) {
                Storage::delete('public/'.$file->path);
            }
            $hismemory->each->delete();
            Storage::delete('public/'.$user->photo);
            $user->removeRole($this->namingRole($user->role_id));
            $user->delete();
        }
        return redirect()->route('user')->with('pesan', 'Data berhasil dihapus');
    }

    public function sendBuku(Request $request)
    {
        if (is_null($request->file('cover'))) {
            $path_cover = '';
        }else{
            $fname_cover = $request->file('cover')->getClientOriginalName();
            Storage::putFileAs('public/buku/'.Request()->name, $request->file('cover'), $fname_cover);
        }

        if (is_null($request->file('pdf'))) {
            $path_pdf = '';
        }else{
            $fname_pdf = $request->file('pdf')->getClientOriginalName();
            Storage::putFileAs('public/buku/'.Request()->name, $request->file('pdf'), $fname_pdf);
        }

        User::create([
            'userpost_id' => $this->idRole(Request()->role),
            'cover' => $fname_cover,
            'cover_path' => $path_cover,
            'pdf' => $fname_pdf,
            'pdf_path' => $path_pdf,
            'judul' => Request()->judul,
            'jumlah' => Request()->jumlah,
            'pengarang' => Request()->pengarang,
            'penerbit' => Request()->penerbit,
            'terbit' => Request()->terbit,
            'tebal_buku' => Request()->tebal_buku,
            'harga' => Request()->harga,
            'harga_sebelumnya' => '',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('buku')->with('pesan', 'Buku berhasil ditambahkan');
    }
}