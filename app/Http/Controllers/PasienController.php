<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Province;
use App\Imports\PasiensImport;
use App\Exports\PasienExport;
 
use Validator;
use DataTables;
use Session;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Auth;
use GuzzleHttp\Client;

class PasienController extends Controller
{
    //
    public function index(Request $request){
       
       
        $provinces=Province::get();
        if ($request->ajax()) {
            $data = Pasien::latest()->get();
           
            return Datatables::of($data)
                    ->addIndexColumn()
                     ->editColumn('provinsi_id',function($dt){
                        return outnama($dt['provinsi_id'], 'provinsi', 'name');
                     })
                     ->editColumn('kabupaten_id',function($dt){
                        return outnama($dt['kabupaten_id'], 'kota', 'name');
                        
                      })
                      ->editColumn('kecamatan_id',function($dt){
                        return outnama($dt['kecamatan_id'], 'camat', 'name');
                      })
                    ->addColumn('action', function($row){
                        $btn = '<a href="#ModalDetail" id="'.$row->nik.'"  data-toggle="modal"  class="btn btn-sm btn-success detailPasien" alt="Lihat" title="Lihat"><i class="material-icons">visibility</i></a>';
                        $btn = $btn. '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm editPasien" alt="Edit" title="Edit"><i class="material-icons">edit</i></a>';
                        $btn= $btn.' <a href="pasien/createPDF/'.$row->id.'" class="btn btn-info btn-sm" alt="cetak" title="cetak pdf" ><i class="material-icons">picture_as_pdf</i></a>';
                
                        $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePasien" alt="Hapus" title="hapus"><i class="material-icons">delete</i></a>';
                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
                   
                  
        }
       //dd($data);
        return view('pages.pasien',['provinces' => $provinces]);

    }
    
    
      public function cek_nik(Request $request)
    {
        $nik = $request->input('nik');
        $pasien = Pasien::where('nik',$nik)->count();
        if($pasien > 0){
            $respon = array('status' => 1, 'error' => 'NIK yang diinputkan sudah ada pada database', 'program' => '');
        } 
        

        return $respon;
    }
    public function store(Request $request)
    {
        $nik_rule = 'required|digits:16|unique:pasiens,nik';
        if($request->pasien_id<>'') {
          $nik_rule = 'required|digits:16|unique:pasiens,nik,'. $request->pasien_id;
        }
         
        
         $rules=array('nik' =>  $nik_rule,
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
                'kecamatan_id'=> $request->kecamatan_id,
                'kelurahan_id'=> $request->kelurahan_id,
                'tempat_lahir'=>$request->tempat_lahir,
                'tanggal_lahir'=>$request->tanggal_lahir,
                'jenis_kelamin'=>$request->jenis_kelamin,
                'nomor_hp'=>$request->nomor_hp,
                'nomor_wa'=>phone($request->nomor_wa,'id')->formatE164(),
                'email'=> $request->email,
                'id_user'=>Auth::user()->id
              ]);
            //return response()->json(['success'=>'Data Berhasil ditambahkan']);
            
            Session::flash('sukses','Data Pasien Berhasil Diimport!');
            return redirect('/pasien','refresh');
       }
        
            
     
    }

    
    public function cari(Request $request)
	{
       $pasien = null;
        $search = $request->input('search');
        if (!empty($search)){
        $pasien = Pasien::query()
        ->where('nik','=',$search)
        ->orWhere('no_mkcare','=',$search)
        ->get();

        if(empty($pasien)){
            return false;
        }
        	// mengirim data pegawai ke view index
		return view('hasil',['pasien' => $pasien]);
        }
        
    	 
 
	}
    public function nomkcareSearch(Request $request)
    {
    	$pasien = [];
        $results=array();
        if($request->has('term')){
            $search = $request->term;
            $pasien =Pasien::select("id","nama","nik","no_mkcare","no_jkn")
            		->where('no_mkcare', 'LIKE', "%$search%")
            		->take(6)->get();
        }
        foreach ($pasien as $query)
        {
            $results[] = ['id' => $query->id, 
                         'value' => $query->no_mkcare,
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
    public function createPDF($id) {
        // retreive all records from db
        $data = Pasien::find($id);
        $data['provinsi']=$this->provinsi($data->provinsi_id);
        $data['kabupaten']=$this->kabupaten($data->kabupaten_id);
        $data['kecamatan']=$this->kecamatan($data->kecamatan_id);
        $data['kelurahan']=$this->kelurahan($data->kelurahan_id);
       
         
       view()->share('pasien',$data);
      $pdf = PDF::loadview('pages.pasien_detail_pdf',$data);
        // download PDF file with download method
       return $pdf->download('pasien_file.pdf');
      }
      public function export_excel()
	{
		return Excel::download(new PasienExport, 'pasien.xlsx');
	}
     
}
