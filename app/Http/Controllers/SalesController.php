<?php

namespace App\Http\Controllers;

use PDF;
use Carbon;
use App\Sales;
use App\Kategori;
use App\JenisSales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $kategori = Kategori::where('id_kategori','not like','1000')->where('id_kategori','not like','1003')->get();  
       
      
        return view('sales.index' , compact('kategori')); 
    }

    public function listData()
    {
        $sales = Sales::orderBy('id_sales', 'desc')->get();
        $no = 0;
        $data = array();
        foreach($sales as $list){
            $no ++;
            $row = array();
            $row[] = "<input type='checkbox' name='id[]'' value='".$list->id_sales."'>";
            $row[] = $no;
       
            $row[] = $list->nama;
            $row[] = $list->alamat;
            $row[] = $list->telpon;
            
          
            $row[] = '<div class="btn-group">
                    <a onclick="editForm('.$list->id_sales.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                    <a onclick="deleteData('.$list->id_sales.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></div>';
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
        $jml = Sales::where('kode_sales', '=', $request['kode'])->count();
        $table_no = Sales::max('id_sales');
        $tgl = substr(str_replace( '-', '', Carbon\carbon::now()), 0,8);
        
        $no= $tgl.$table_no;
        $auto=substr($no,8);
        $auto=intval($auto)+1;
        $auto_number=substr($no,0,8).str_repeat(0,(4-strlen($auto))).$auto;
        if($jml < 1){
            $sales = new Sales;
            $sales->kode_sales = $auto_number;
            $sales->nama   = $request['nama'];
            $sales->alamat = $request['alamat'];
            $sales->telpon = $request['telpon'];
            $sales->tempat_lahir = $request['tempat_lahir'];
            $sales->tanggal_lahir = $request['tanggal_lahir'];
            $sales->motivasi = $request['motivasi'];
            $sales->medsos = $request['medsos'];
 
            $sales->save();

            echo json_encode(array('msg'=>'success'));
        }else{
            echo json_encode(array('msg'=>'error'));
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show(Sales $sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $sales = Sales::find($id);
        echo json_encode($sales);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sales = Sales::find($id);
        $sales->nama = $request['nama'];
        $sales->alamat = $request['alamat'];
        $sales->telpon = $request['telpon'];
        $sales->tempat_lahir = $request['tempat_lahir'];
        $sales->tanggal_lahir = $request['tanggal_lahir'];
        $sales->motivasi = $request['motivasi'];
        $sales->medsos = $request['medsos'];

        $sales->update();
        echo json_encode(array('msg'=>'success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sales = Sales::find($id);
        $sales->delete();
    }

    public function printCard(Request $request)
    {
        set_time_limit(8000000);
        $datasales = array();
        foreach($request['id'] as $id){
            $sales = Sales::find($id);
            $datasales[] = $sales;
        }
        
        $pdf = PDF::loadView('sales.card', compact('datasales'));
        $pdf->setPaper(array(0, 0, 566.93, 850.39), 'potrait');     
        return $pdf->stream();
    }
}
