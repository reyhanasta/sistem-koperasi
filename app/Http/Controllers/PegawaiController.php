<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pegawai;
use App\Models\MasterJabatan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $listPegawai = Pegawai::all();
        return view('pegawai.list', compact('listPegawai'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $req)
    {
        //
        $dataPegawai = new Pegawai;
        $jabatan = MasterJabatan::all();
        $back = url()->previous();
        return view('pegawai.add', compact('dataPegawai', 'jabatan', 'back'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function store(Request $request)
     {
         try {
             DB::beginTransaction(); // Begin the transaction
     
             $validatedData = $request->validate([
                 'email' => 'required|email:dns|unique:users,email',
             ]);
     
             // Create User instance
             $newUser = new User([
                 'email' => strtolower($request->email),
                 'email_verified_at' => now(),
                 'level' => 'admin',
                 'name' => ucwords(strtolower($request->name)),
                 'password' => Hash::make('btm100'),
             ]);
             $newUser->save();
     
             // Create Pegawai instance and associate it with the newly created User
             $newPegawai = new Pegawai([
                 'name' => ucwords(strtolower($request->name)),
                 'gender' => ucwords(strtolower($request->gender)),
                 'email' => strtolower($request->email),
                 'position' => ucwords(strtolower($request->position)),
                 'user_id' => $newUser->id, // Associate Pegawai with User
             ]);
     
             // Handle profile picture
             if ($request->hasFile('profile_pict')) {
                 $file = $request->file('profile_pict');
                 $nama_file = time() . str_replace(" ", "", $file->getClientOriginalName());
                 $file->move('picture', $nama_file);
                 $newPegawai->profile_pict = $nama_file;
             }
     
             // Save Pegawai instance
             $newPegawai->save();
     
             DB::commit(); // Commit the transaction
     
             return redirect('/pegawai')->with('success', 'Data Berhasil di Simpan');
         } catch (\Exception $e) {
             DB::rollback(); // Rollback the transaction
             return redirect('/pegawai')->with('error', 'Terjadi kesalahan saat menyimpan data');
         }
     }
     

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        return DB::transaction(function () use ($id) {
            $dataPegawai = Pegawai::findOrFail($id);

            $data = [
                'dataPegawai' => $dataPegawai,
                'joindate' => $dataPegawai->created_at->format('d-m-Y'),
                'salary' => 'Rp. ' . number_format($dataPegawai->gaji),
                'gender' => ($dataPegawai->gender == 'female') ? 'Perempuan' : 'Laki-laki',
                'desc' => $dataPegawai->desc ?? '-',
                'back' => url()->previous(),
            ];

            return view('pegawai.show', $data);
        });
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $dataPegawai = Pegawai::find($id);
        $jabatan = MasterJabatan::all();
        $back = url()->previous();
        return view('pegawai.edit', compact('dataPegawai', 'jabatan', 'back'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = Pegawai::find($id);
        $data->name = ucwords($request->name);
        $data->gender = $request->gender;
        $data->email = $request->email;
        $data->position = $request->position;
        if ($request->file('profile_pict')) {
            $file = $request->file('profile_pict');
            $nama_file = time() . str_replace(" ", "", $file->getClientOriginalName());
            $file->move('picture', $nama_file);
            $image_path = public_path() . '/picture/' . $data->profile_pict;
            File::delete('picture', $image_path);
            $data->profile_pict = $nama_file;
        }
        $data->save();
      
        return redirect('/pegawai')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $data = Pegawai::find($id);
    
                // Delete profile picture if it exists
                $image_path = public_path() . '/picture/' . $data->profile_pict;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
    
                // Delete Pegawai record
                $data->delete();
    
                // Delete associated User record
                User::where('email', $data->email)->delete();
            });
    
            return redirect('/pegawai')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/pegawai')->with('error', 'Terjadi kesalahan saat menghapus data');
        }
    }
}
