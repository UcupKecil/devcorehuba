<?php

namespace App\Http\Controllers;

use PDF;
use Carbon;
use App\Member;
use App\Kategori;
use App\JenisMember;
use Illuminate\Http\Request;

class MemberDistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenismember = JenisMember::where('id_jenis','not like','1000')->where('jenis_member','=','distributor')->get();    
        $kategori = Kategori::where('id_kategori','not like','1000')->where('id_kategori','not like','1003')->get();  
       
      
        return view('member_distributor.index' , compact('jenismember','kategori')); 
    }

    public function listData()
    {
        $member = Member::leftJoin('jenis_member', 'jenis_member.jenis_member', '=', 'member.jenis_member')
        ->where('member.jenis_member','=','distributor')
        ->orderBy('id_member', 'desc')->get();
        $no = 0;
        $data = array();
        foreach($member as $list){
            $no ++;
            $row = array();
            $row[] = "<input type='checkbox' name='id[]'' value='".$list->id_member."'>";
            $row[] = $no;
            $row[] = $list->kode_member;
            $row[] = $list->nama;
            $row[] = $list->alamat;
            $row[] = $list->telpon;
            $row[] = $list->jenis_member;
            $row[] = '<div class="btn-group">
                    <a onclick="editForm('.$list->id_member.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                    <a onclick="deleteData('.$list->id_member.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';
            $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jml = Member::where('kode_member', '=', $request['kode'])->count();
        $table_no = Member::max('id_member');
        $tgl = substr(str_replace( '-', '', Carbon\carbon::now()), 0,8);
        
        $no= $tgl.$table_no;
        $auto=substr($no,8);
        $auto=intval($auto)+1;
        $auto_number=substr($no,0,8).str_repeat(0,(4-strlen($auto))).$auto;
        if($jml < 1){
            $member = new Member;
            $member->kode_member = $auto_number;
            $member->nama   = $request['nama'];
            $member->alamat = $request['alamat'];
            $member->telpon = $request['telpon'];
            $member->jenis_member = $request['jenis_member'];
            $member->save();

            echo json_encode(array('msg'=>'success'));
        }else{
            echo json_encode(array('msg'=>'error'));
        }
        // $member = new Member;
        // dd($member->id);
        // $member->kode_member = $member->id;
        // $member->nama   = $request['nama'];
        // $member->alamat = $request['alamat'];
        // $member->telpon = $request['telpon'];
        // $member->save();
        // return view('member.index');
        // echo json_encode(array('msg'=>'success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $member = Member::find($id);
        echo json_encode($member);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $member = Member::find($id);
        $member->nama = $request['nama'];
        $member->alamat = $request['alamat'];
        $member->telpon = $request['telpon'];
        $member->jenis_member = $request['jenis_member'];
        $member->update();
        echo json_encode(array('msg'=>'success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::find($id);
        $member->delete();
    }

    public function printCard(Request $request)
    {
        set_time_limit(8000000);
        $datamember = array();
        foreach($request['id'] as $id){
            $member = Member::find($id);
            $datamember[] = $member;
        }
        
        $pdf = PDF::loadView('member_distributor.card', compact('datamember'));
        $pdf->setPaper(array(0, 0, 566.93, 850.39), 'potrait');     
        return $pdf->stream();
    }
}
