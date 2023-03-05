<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\User;
    use App\Karyawan;

    use Auth;
    use Hash;
    class UserController extends Controller
    {
    public function index()
    {
        return view('user.index'); 
    }

    public function listData()
    {
    
        $user = User::orderBy('id', 'desc')->get();
        $no = 0;
        $data = array();
        foreach($user as $list){
            $no ++;
            $row = array();
            $row[] = $no;
            $row[] = $list->name;
            $row[] = $list->email;
            if($list->level == '1'){
                $row[] = 'Admin';
            }elseif($list->level == '2'){
                $row[] = 'Kasir';
            }
            elseif($list->level == '3'){
                $row[] = 'Inventory';
            }elseif($list->level == '4'){
                $row[] = 'Management';
            }elseif($list->level == '5'){
                $row[] = 'Finance';
            }
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
        $user = new User;
        $data = Karyawan::where('nama',$request['nama'])->get();
        foreach($data as $dt){
            $email = $dt->email;
            $foto = $dt->foto;
        }
        $user->name = $request['nama'];
        $user->email = $email;
        $user->password = bcrypt($request['password']);
        $user->level = $request['level'];
        $user->foto = $foto;
        $user->save();
    }

    public function edit($id)
    {
        $user = User::find($id);
        echo json_encode($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request['nama'];
        $user->email = $request['email'];
        if(!empty($request['password'])) $user->password = bcrypt($request['password']);
        $user->update();
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
    }

    public function profil()
    {
        $user = Auth::user();
        return view('user.profil', compact('user')); 
    }

    public function changeProfil(Request $request, $id)
    {
        $msg = "succcess";
        $user = User::find($id);
        if(!empty($request['password'])){
            if(Hash::check($request['passwordlama'], $user->password)){
                $user->password = bcrypt($request['password']);
            }else{
                $msg = 'error';
            }
        } 

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama_gambar = "fotouser_".$id.".".$file->getClientOriginalExtension();
            $lokasi = public_path('images');

            $file->move($lokasi, $nama_gambar);
            $user->foto         = $nama_gambar;  
            
            $datagambar = $nama_gambar;
        }else{
            $datagambar = $user->foto; 
        }

        $user->update();
        echo json_encode(array('msg'=>$msg, 'url'=> asset('public/images/'.$datagambar))); 
    }
}
