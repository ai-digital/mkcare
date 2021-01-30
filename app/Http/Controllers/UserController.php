<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Validator;
use Session;
class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        
        return view('pages.user', ['users' => $model->paginate(15)]);
    }
    public function store(Request $request)
    {
        $rules=array(
        'nama' => 'required|max:50', 
        'email'=>'required|email',
        'password' => 'required',
        'hak_akses'=>'required',
       );
       
       $validator = Validator::make($request->all(),$rules);
         
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        } else{ 
           User::updateOrCreate(['id' => $request->user_id], [
                
                'name' => $request->nama,
                'email'=> $request->email,
                'hak_akses'=>$request->hak_akses,
                'password'=>Hash::make($request->password),
             
                
              ]);
              return response()->json(['success'=>'Data Berhasil ditambahkan']);
  
       }
           
     
    }
    public function edit($id)
    {
        $pasien = User::find($id);
        return response()->json($pasien);
    }
    public function destroy($id)
    {
      $pasien = User::find($id)->delete();

      return response()->json(['success'=>'Data user sudah dihapus']);
    }
}
