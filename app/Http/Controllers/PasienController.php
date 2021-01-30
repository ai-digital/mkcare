<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Nkri;
use App\Imports\PasiensImport;
use Laravolt\Indonesia\Models\Province;
use Validator;
use DataTables;
use Session;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
class PasienController extends Controller
{
    //
    public function index(Request $request){
        
        if ($request->ajax()) {
            $data = Pasien::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    
                    ->addColumn('action', function($row){
                        $btn = '<a href="#ModalDetail" id="'.$row->nik.'|'.$row->no_mkcare.'|'.$row->no_jkn.'|'.ucfirst(strtolower($row->nama)).'|'.ucfirst(strtolower($row->tempat_lahir)).'|'.$row->tanggal_lahir.'|'.$row->jenis_kelamin.'|'.$row->alamat.'|'.ucfirst(strtolower($row->nomor_hp)).'|'.ucfirst(strtolower($row->nomor_wa)).'"  data-toggle="modal"  class="btn btn-sm btn-success detailPasien" alt="Lihat" title="Lihat"><i class="material-icons">visibility</i></a>';
                        $btn = $btn. '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm editPasien" alt="Edit" title="Edit"><i class="material-icons">edit</i></a>';
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePasien" alt="Hapus" title="hapus"><i class="material-icons">delete</i></a>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                   
                  
        }
       //dd($data);
        return view('pages.pasien');

    }
    public function store(Request $request)
    {
        $rules=array('nik' =>  'required|digits:16|numeric', 
        
        'nama' => 'required|max:50', 
        'tempat_lahir'=>'required|max:50',
        'tanggal_lahir'=>'required|date',
        'provinsi_id'=>'required',
        'kabupaten_id'=>'required',
        'kecamatan_id'=>'required',
        'kelurahan_id'=>'required',
        'alamat' => 'required', 
        'jenis_kelamin' => 'required',
        'nomor_hp'=>'phone:id',
        'nomor_wa'=>'phone:id', );
       $validator = Validator::make($request->all(),$rules);
         
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        } else{ 
           Pasien::updateOrCreate(['id' => $request->pasien_id], [
                'nik' => $request->nik,
                'no_mkcare'=> $request->no_mkcare,
                'no_jkn'=> $request->no_jkn,
                'nama' => $request->nama,
                'alamat'=> $request->alamat,
                'provinsi_id'=> $request->provinsi_id,
                'kabupaten_id'=> $request->kabupaten_id,
                'tempat_lahir'=>$request->tempat_lahir,
                'tanggal_lahir'=>$request->tanggal_lahir,
                'jenis_kelamin'=>$request->jenis_kelamin,
                'nomor_hp'=>$request->nomor_hp,
                'nomor_wa'=>phone($request->nomor_wa,'id')->formatE164()
              ]);
            return response()->json(['success'=>'Data Berhasil ditambahkan']);
       }
        
            
     
    }
    public function cari(Request $request)
	{
       $pasien = null;
        $search = $request->input('search');
        if (!empty($search)){
        $pasien = Pasien::query()
        ->where('nama','like',"%{$search}%")
        ->orWhere('no_mkcare','=',$search)
        ->get();

        if(empty($pasien)){
            return false;
        }
        	// mengirim data pegawai ke view index
		return view('hasil',['pasien' => $pasien]);
        }
        
    	 
 
	}
    public function NIKSearch(Request $request)
    {
    	$pasien = [];
        $results=array();
        if($request->has('term')){
            $search = $request->term;
            $pasien =Pasien::select("id","nama","nik","no_mkcare","no_jkn")
            		->where('nik', 'LIKE', "%$search%")
            		->take(6)->get();
        }
        foreach ($pasien as $query)
        {
            $results[] = ['id' => $query->id, 
                         'value' => $query->nik,
                         'nama'=> $query->nama,
                         'nik'=> $query->nik,
                         'no_mkcare'=>$query->no_mkcare,
                         'no_jkn'=>$query->no_jkn]; //you can take custom values as you want
        }
        return response()->json($results);
    }

    public function show($id)
    {
        $pasien = Pasien::find($id);

        return response()->json($pasien);
    }
    public function edit($id)
    {
        $pasien = Pasien::find($id);
        return response()->json($pasien);
    }
    public function destroy($id)
    {
      $pasien = Pasien::find($id)->delete();

      return response()->json(['success'=>'Data pasien sudah dihapus']);
    }
    public function fileImport(Request $request) 
    {
        $this->validate($request, [
			'file' => 'required|mimes:csv,xls,xlsx'
		]);
 
		// menangkap file excel
		$file = $request->file('file');
 
		// membuat nama file unik
		$nama_file = rand().$file->getClientOriginalName();
 
		// upload ke folder file_siswa di dalam folder public
		$file->move(public_path('/file_pasien'),$nama_file);
 
		// import data
		Excel::import(new PasiensImport, public_path('/file_pasien/'.$nama_file));
 
		// notifikasi dengan session
		Session::flash('sukses','Data Pasien Berhasil Diimport!');
 
		// alihkan halaman kembali
		return redirect('/pasien');
        //return back();
    }
    public function createPDF() {
        // retreive all records from db
        $data = Pasien::all();
        
       view()->share('pasien',$data);
      $pdf = PDF::loadview('pages.pasien_pdf',$data);
        // download PDF file with download method
       return $pdf->download('pasien_file.pdf');
      }
  
}
