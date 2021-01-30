<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\User;
use App\Models\Memory;
use Illuminate\Support\Facades\Schema;
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
        $role = Role::all();
        $riur = User::all();
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
        $colrole = Role::all();
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
        $colrole = Role::all();
        
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
        $artype = [];
        $buku = Buku::all();
        $table = Schema::getColumnListing('bukus');
        array_splice($table, 5, 1);
        array_splice($table, 3, 1);
        array_splice($table, 0, 1);
        foreach($table as $col){
            array_push($artype, Schema::getColumnType('bukus', $col));
        }
        $data = [
            'me' => '3',
            'ib' => $buku,
            'cf' => $artype,
            'ch' => $table
        ];

        return view('member/buku', $data);
    }

    public function addBuku()
    {
        $data = ['me' => '3'];
        return view('buku_app/bukuadd', $data);
    }

    public function buku_detail(Request $request)
    {
        $id = $request->session()->get('id');
        $one = Buku::find($id);
        $data = ['me' => '3', 'bk' => $one];

        return view('buku_app/bukudetail', $data);
    }

    //Action
    public function uploadFile(Request $request)
    {
        $user = auth()->user();
        $fname = $request->file('file')->getClientOriginalName();
        $request->validate(['file' => 'required|file|max:5000']);
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

    public function buku_direct(Request $request, $id)
    {
        $request->session()->put('id', $id);
        return redirect()->route('buku_detail');
    }

    public function sendUser(Request $request)
    {
        $request->validate([
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
            $path = $request->name.'/'.$fname;
            Storage::putFileAs('public/'.$request->name, $request->file('photo'), $fname);
        }

        $user = User::create([
            'role_id' => $this->idRole($request->role),
            'photo' => $path,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'alamat' => $request->alamat,
            'kebangsaan' => $request->kebangsaan,
            'tgl_lahir' => $request->tgl_lahir,
            'password' => bcrypt($request->password),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $user->assignRole($request->role);

        return redirect()->route('user')->with('pesan', 'Data berhasil ditambahkan');
    }

    public function updateUser(Request $request)
    {
        $id = $request->session()->get('id');
        $request->validate([
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

        if ($this->idRole($request->role) != $data->role_id) {
            $data->removeRole($this->namingRole($data->role_id));
            $data->assignRole($request->role);
        }

        if (is_null($request->file('photo'))) {
            $path = $data->photo;
        }else{
            Storage::delete('public/'.$data->photo);
            $fname = $request->file('photo')->getClientOriginalName();
            $path = $request->name.'/'.$fname;
            Storage::putFileAs('public/'.$request->name, $request->file('photo'), $fname);
        }

        User::find($id)->update([
            'role_id' => $this->idRole($request->role),
            'photo' => $path,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'gender' => $request->gender,
            'phone' => $request->phone,
            'alamat' => $request->alamat,
            'kebangsaan' => $request->kebangsaan,
            'tgl_lahir' => $request->tgl_lahir,
            'password' => bcrypt($request->password),
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
        $request->validate([
            'judul' => 'required',
            'jumlah' => 'required|numeric',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'terbit' => 'required|max:4|min:4|numeric',
            'tebal_buku' => 'required|numeric',
            'harga' => 'required|numeric',
        ], [
            'judul.required' => 'Judul belum di isi',
            'jumlah.numeric' => 'Hanya boleh memasukkan angka saja',
            'jumlah.required' => 'Jumlah belum di isi',
            'pengarang.required' => 'Minimal 3 karakter',
            'terbit.required' => 'Terbit belum di isi',
            'terbit.min' => 'Minimal 4 huruf',
            'terbit.max' => 'Maximal 4 huruf',
            'terbit.numeric' => 'Hanya boleh memasukkan angka saja',
            'tebal_buku.required' => 'Tebal buku belum di isi',
            'tebal_buku.numeric' => 'Hanya boleh memasukkan angka saja',
            'harga.required' => 'Harga belum di isi',
            'harga.numeric' => 'Hanya boleh memasukkan angka saja',
        ]);

        if (is_null($request->file('cover'))) {
            $path_cover = '';
            $fname_cover = '';
        }else{
            $fname_cover = $request->file('cover')->getClientOriginalName();
            $path_cover = 'buku/'.$fname_cover;
            Storage::putFileAs('public/buku/', $request->file('cover'), $fname_cover);
        }

        if (is_null($request->file('pdf'))) {
            $path_pdf = '';
            $fname_pdf = '';
        }else{
            $fname_pdf = $request->file('pdf')->getClientOriginalName();
            $path_pdf = 'buku/'.$fname_pdf;
            Storage::putFileAs('public/buku/', $request->file('pdf'), $fname_pdf);
        }

        Buku::create([
            'userpost_id' => Auth()->user()->id,
            'cover' => $fname_cover,
            'cover_path' => $path_cover,
            'pdf' => $fname_pdf,
            'pdf_path' => $path_pdf,
            'judul' => $request->judul,
            'jumlah' => $request->jumlah,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'terbit' => $request->terbit,
            'tebal_buku' => $request->tebal_buku,
            'harga' => $request->harga,
            'harga_sebelumnya' => '0',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('buku')->with('pesan', 'Buku berhasil ditambahkan');
    }

    public function updateBuku(Request $request)
    {
        $id = $request->session()->get('id');
        $request->validate([
            'judul' => 'required',
            'jumlah' => 'required|numeric',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'terbit' => 'required|numeric',
            'tebal_buku' => 'required|numeric',
            'harga' => 'required|numeric',
        ], [
            'judul.required' => 'Judul belum di isi',
            'jumlah.numeric' => 'Hanya boleh memasukkan angka saja',
            'jumlah.required' => 'Jumlah belum di isi',
            'pengarang.required' => 'Minimal 3 karakter',
            'terbit.required' => 'Terbit belum di isi',
            'terbit.numeric' => 'Hanya boleh memasukkan angka saja',
            'tebal_buku.required' => 'Tebal buku belum di isi',
            'tebal_buku.numeric' => 'Hanya boleh memasukkan angka saja',
            'harga.required' => 'Harga belum di isi',
            'harga.numeric' => 'Hanya boleh memasukkan angka saja',
        ]);

        $data = Buku::find($id);

        if (is_null($request->file('cover'))) {
            $fname_cover = $data->cover;
            $path_cover = $data->cover_path;;
        }else{
            Storage::delete('public/'.$data->cover_path);
            $fname_cover = $request->file('cover')->getClientOriginalName();
            $path_cover = 'buku/'.$fname_cover;
            Storage::putFileAs('public/buku/', $request->file('cover'), $fname_cover);
        }

        if (is_null($request->file('pdf'))) {
            $fname_pdf = $data->pdf;
            $path_pdf = $data->pdf_path;
        }else{
            Storage::delete('public/'.$data->pdf_path);
            $fname_pdf = $request->file('pdf')->getClientOriginalName();
            $path_pdf = 'buku/'.$fname_pdf;
            Storage::putFileAs('public/buku/', $request->file('pdf'), $fname_pdf);
        }

        Buku::find($id)->update([
            'userpost_id' => Auth()->user()->id,
            'cover' => $fname_cover,
            'cover_path' => $path_cover,
            'pdf' => $fname_pdf,
            'pdf_path' => $path_pdf,
            'judul' => $request->judul,
            'jumlah' => $request->jumlah,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'terbit' => $request->terbit,
            'tebal_buku' => $request->tebal_buku,
            'harga' => $request->harga,
            'harga_sebelumnya' => '0',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('buku')->with('pesan', 'Perubahan berhasil disimpan');
    }

    public function bukudelete($id)
    {
        $buku = Buku::find($id);
        Storage::delete('public/'.$buku->cover_path);
        Storage::delete('public/'.$buku->pdf_path);
        $judul = $buku->judul;
        $buku->delete();
        return redirect()->route('buku')->with('pesan', 'Data berhasil dihapus '.$judul);
    }

    public function bukudeletes(Request $request)
    {
        foreach($request->id as $id){
            $buku = Buku::find($id);
            Storage::delete('public/'.$buku->cover_path);
            Storage::delete('public/'.$buku->pdf_path);
            $buku->delete();
        }
        return redirect()->route('buku')->with('pesan', 'Data berhasil dihapus');
    }

    public function pdfpreview($id)
    {
        $buku = Buku::find($id);
        $filename = $buku->pdf;
        $path = storage_path('public/'.$buku->pdf_path);

        return Response::make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }
}