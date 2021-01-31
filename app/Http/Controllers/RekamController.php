<?php

namespace App\Http\Controllers;
use App\Models\Pasien;
use App\Models\Nkri;
use App\Models\Rekam;
use DataTables;
use Validator,Redirect,Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use DB;
use Carbon\Carbon;
use Auth;
class RekamController extends Controller
{
    //
    public function index(Request $request)

    {
        if ($request->ajax()) {
            $nama = (!empty($_GET["nama"])) ? ($_GET["nama"]) : ('');
            $nik = (!empty($_GET["nik"])) ? ($_GET["nik"]) : ('');
            $no_mkcare= (!empty($_GET["no_mkcare"])) ? ($_GET["no_mkcare"]) : ('');
            $no_jkn = (!empty($_GET["no_jkn"])) ? ($_GET["no_jkn"]) : ('');

            if($nama){
             $data=DB::table('rekams')->join('pasiens','rekams.id_pasien','=','pasiens.id')
            ->select('rekams.id','rekams.id_pasien','pasiens.no_mkcare','pasiens.no_jkn','pasiens.nik','pasiens.nama','rekams.tgl_rekam','rekams.keluhan','rekams.diagnosa','rekams.tindakan','rekams.petugas')
            ->where('pasiens.nama','like','%'.$nama.'%')         
            ->whereRaw('rekams.id in (SELECT max(id) from rekams group by id_pasien)')->get();
                
            }
            else if($nik) {
             $data=DB::table('rekams')->join('pasiens','rekams.id_pasien','=','pasiens.id')
            ->select('rekams.id','rekams.id_pasien','pasiens.no_mkcare','pasiens.no_jkn','pasiens.nik','pasiens.nama','rekams.tgl_rekam','rekams.keluhan','rekams.diagnosa','rekams.tindakan','rekams.petugas')
            ->where('pasiens.nik','=',$nik)
            ->whereRaw('rekams.id in (SELECT max(id) from rekams group by id_pasien)')->get();
            }
            else if($no_mkcare){
            $data=DB::table('rekams')->join('pasiens','rekams.id_pasien','=','pasiens.id')
            ->select('rekams.id','rekams.id_pasien','pasiens.no_mkcare','pasiens.no_jkn','pasiens.nik','pasiens.nama','rekams.tgl_rekam','rekams.keluhan','rekams.diagnosa','rekams.tindakan','rekams.petugas')
            ->where('pasiens.no_mkcare','=',$no_mkcare)
            ->whereRaw('rekams.id in (SELECT max(id) from rekams group by id_pasien)')->get();

            }
            else if($no_jkn){
             $data=DB::table('rekams')->join('pasiens','rekams.id_pasien','=','pasiens.id')
            ->select('rekams.id','rekams.id_pasien','pasiens.no_mkcare','pasiens.no_jkn','pasiens.nik','pasiens.nama','rekams.tgl_rekam','rekams.keluhan','rekams.diagnosa','rekams.tindakan','rekams.petugas')
            ->where('pasiens.no_jkn','=',$no_jkn)
            ->whereRaw('rekams.id in (SELECT max(id) from rekams group by id_pasien)')->get();

            }

            else{
            $data=DB::table('rekams')->join('pasiens','rekams.id_pasien','=','pasiens.id')
            ->select('rekams.id','rekams.id_pasien','pasiens.no_mkcare','pasiens.no_jkn','pasiens.nik','pasiens.nama','rekams.tgl_rekam','rekams.keluhan','rekams.diagnosa','rekams.tindakan','rekams.petugas')
            ->whereRaw('rekams.id in (SELECT max(id) from rekams group by id_pasien)')
            ->orderBy('rekams.tgl_rekam', 'DESC')->get();
            
           }
            return Datatables::of($data)
           ->editColumn('tgl_rekam', function ($user) {
                return $user->tgl_rekam ? with(new Carbon($user->tgl_rekam))->format('d/m/Y') : '';;
            })
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="./rekam/detail/'. $row->id_pasien .'"data-toggle="tooltip"  data-id="'.$row->id_pasien.'" data-original-title="View" title="Lihat Detail" alt="Lihat Detail Rekam Medis" class="btn btn-success btn-sm viewrekam"><i class="material-icons">pageview</i></a>';
               // $btn = $btn. '<a href="./rekam/cetak/'. $row->id_pasien .'" data-toggle="tooltip"  data-id="'.$row->id_pasien.'" data-original-title="View" title="Cetak Rekam Medis" alt="Cetak Rekam Medis" class="btn btn-info btn-sm cetakrekam"><i class="material-icons">print</i></a>';
                return $btn;
                    })
            ->rawColumns(['action'])
            ->make(true);
           
        }  
        
        return view('pages.rekam');

        
    }
    public function showrekam($id){ 
            
            if ($request->ajax()) {
                $id = (!empty($_GET["detail"])) ? ($_GET["detail"]) : ('');
                $data=DB::table('rekams')->join('pasiens','rekams.id_pasien','=','pasiens.id')
                ->select('rekams.id','rekams.id_pasien','pasiens.nik','pasiens.no_mkcare','pasiens.no_jkn','pasiens.nama','rekams.tgl_rekam','rekams.keluhan','rekams.diagnosa','rekams.tindakan','rekams.petugas')
                ->where('rekams.id_pasiens','=',$id)
                
                ->orderBy('rekams.tgl_rekam', 'DESC')->get();
                
               
                return Datatables::of($data)
               ->editColumn('tgl_rekam', function ($user) {
                    return $user->tgl_rekam ? with(new Carbon($user->tgl_rekam))->format('d/m/Y') : '';;
                })
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="./rekam/detail/'. $row->id_pasien .'"data-toggle="tooltip"  data-id="'.$row->id_pasien.'" data-original-title="View" title="Lihat Detail" alt="Lihat Detail Rekam Medis" class="btn btn-success btn-sm viewrekam"><i class="material-icons">pageview</i></a>';
                   // $btn = $btn. '<a href="./rekam/cetak/'. $row->id_pasien .'" data-toggle="tooltip"  data-id="'.$row->id_pasien.'" data-original-title="View" title="Cetak Rekam Medis" alt="Cetak Rekam Medis" class="btn btn-info btn-sm cetakrekam"><i class="material-icons">print</i></a>';
                    return $btn;
                        })
                ->rawColumns(['action'])
                ->make(true);
               
            }  
            
            return view('pages.rekam_detail');
    
            
        
    }
    public function isi()
    {
        return view('pages.rekam_isi');
    }
   

    public function store(Request $request)
    {
       
        $rules=array('pasien_id' =>  'required', 
        
        'keluhan' => 'required', 
        'diagnosa'=>'required',
        'tgl_rekam'=>'required|date',
        'tindakan' => 'required',  );
       // 'nomor_wa'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
       $validator = Validator::make($request->all(),$rules);
         
        if ($validator->fails()) {
          //  if ($validator->fails()) {
            //    return response()->json(['status' => $validator->errors()->all()]);
          //  }
          return response()->json(['error'=>$validator->errors()->all()]);
        } else{ 
          
           Rekam::updateOrCreate(['id' => $request->id],['id_pasien' => $request->pasien_id,
                'tgl_rekam' => $request->tgl_rekam,
                'keluhan'=> $request->keluhan,
                'tindakan'=> $request->tindakan,
                'diagnosa' => $request->diagnosa,
                'petugas' => $request->petugas,
                'id_user'=>Auth::user()->id
          
              ]);
               

          
        return redirect()->route('rekam_isi')
        ->with('status', 'Data sudah disimpan');

       }
    }
    public function update(Request $request)
    {
        $rules=array('nik' =>  'required|max:16', 
        'id_pasien'=>'required',
        'keluhan' => 'required', 
        'diagnosa'=>'required',
        'tgl_rekam'=>'required|date',
        'tindakan' => 'required',  );
     
       $validator = Validator::make($request->all(),$rules);
       if ($validator->fails()) {
        
        return back()->withInput($request->all())
        ->withErrors($validator->errors());
    } else{ 
      
     $pasien= Rekam::where('id',$request->rekam_id)
        ->update(['id_pasien' => $request->id_pasien, 
        'tgl_rekam' => $request->tgl_rekam,
        'keluhan'=> $request->keluhan,
        'tindakan'=> $request->tindakan,
        'diagnosa' => $request->diagnosa,
        'petugas' => $request->petugas
  
      ]);
     
        return redirect()->route('rekam_isi')
            ->with('status', 'Data sudah disimpan');
    }
  
        
}

public function show($id)
{
    $rekam=Pasien::with(['rekam'])->find($id); 
   //return response()->json($rekam);
   return view('pages.rekam_detail',compact('rekam'));
}
public function edit($id)
{
    $rekam = Rekam::with(['pasien'])->find($id);
    dd($rekam);
    return response()->json($rekam);
    
    
}
public function destroy($id)
{

    
  $pasien = Rekam::find($id);
  Rekam::destroy($id);

  return Redirect::back()->with('message','Operation Successful !');
}
}