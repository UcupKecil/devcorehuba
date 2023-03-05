<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Karyawan;
use File;
use Storage;

class KaryawanController extends Controller
{
    public function index()
    {
        return view('karyawan.index'); 
    }

    public function listData()
    {
    
        $user = Karyawan::orderBy('id', 'desc')->get();
        // dd($user);
        $no = 0;
        $data = array();
        foreach($user as $list){
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = $list->NIP;
            $row[] = $list->nama;
            $row[] = $list->email;
            $row[] = $list->NoKTP;
            $row[] = $list->alamat;
            $row[] = '<img src="images'.$list->foto.'" width="100%" >';
            $row[] = '<div class="btn-group">
                    <a onclick="editForm('.$list->id.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                    <a onclick="deleteData('.$list->id.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';
            $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    public function store(Request $request)
    {
        if ($request['id']){
            $user = Karyawan::find($request['id']);
            $data = $request->all();
            // dd($data);
            if($request['foto']){    
                if ($request->hasFile('foto')) {
                    File::delete('images/'.$user->foto);
                    $file = $request->file('foto');
                    
                    $nama_gambar = "/karyawan/".$data['nama']."_foto.".$file->getClientOriginalExtension();
                    $lokasi = public_path('images/karyawan');
    
                    $file->move($lokasi, $nama_gambar);
                    // dd($nama_gambar);
                    // $data['porto'] = $nama_gambar;
                }
            }else{
                $nama_gambar = $user->foto;
            }
            $user->nama = $request['nama'];
            $user->email = $request['email'];
            $user->alamat = $request['alamat'];
            $user->NoKTP = $request['NoKTP'];
            $user->NIP = $request['NIP'];
            $user->foto = $nama_gambar;
            $user->update();
            return back();
        }
        else{
            $user = new Karyawan;
            $data = $request->all();
            // dd($data);
            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                
                $nama_gambar = $data['nama']."_foto.".$file->getClientOriginalExtension();
                $lokasi = public_path('images/karyawan');

                $file->move($lokasi, $nama_gambar);
                // dd($nama_gambar);
                // $data['porto'] = $nama_gambar;
            }
            $user->nama = $request['nama'];
            $user->email = $request['email'];
            $user->alamat = $request['alamat'];
            $user->NoKTP = $request['NoKTP'];
            $user->NIP = $request['NIP'];
            $user->foto = "/karyawan/".$nama_gambar;
            $user->save();
            return back();
        }
    }

    public function edit($id)
    {
        $user = Karyawan::find($id);
        echo json_encode($user);
    }

    public function update(Request $request, $id)
    {
        $user = Karyawan::find($id);
        $data = $request->all();
        dd($data);
        if($request['foto']){    
            if ($request->hasFile('foto')) {
                File::delete('images/'.$user->foto);
                $file = $request->file('foto');
                
                $nama_gambar = $data['nama']."_foto.".$file->getClientOriginalExtension();
                $lokasi = public_path('images/karyawan');

                $file->move($lokasi, $nama_gambar);
                // dd($nama_gambar);
                // $data['porto'] = $nama_gambar;
                $user->foto = "/karyawan/".$nama_gambar;
            }
        }else{
            $sub = substr($user->foto,-4);
            $old = "images/".$user->foto;
            $new = "images/karyawan/".$request['nama']."_foto".$sub;
            Storage::move($old, $new);
            $user->foto = "/karyawan/".$request['nama']."_foto".$sub;
        }
        $user->nama = $request['nama'];
        $user->email = $request['email'];
        $user->alamat = $request['alamat'];
        $user->NoKTP = $request['NoKTP'];
        $user->NIP = $request['NIP'];
        
        $user->update();
    }

    public function destroy($id)
    {
        $user = Karyawan::find($id);
        File::delete('images/'.$user->foto);
        $user->delete();
    }
}
