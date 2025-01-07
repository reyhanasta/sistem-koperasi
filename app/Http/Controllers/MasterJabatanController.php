<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterJabatan;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class MasterJabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = MasterJabatan::all();
        $back = url()->previous();
        return view('master.jabatan.list', compact('data', 'back'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = new MasterJabatan();
        $back = url()->previous();
        return view('master.jabatan.add', compact('data', 'back'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
         // Validasi input
         $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Mengubah name menjadi role
        $role = strtolower(str_replace(' ', '-', $request->name));
        $name = ucwords($request->name);
         DB::beginTransaction();

        try {
            // Menyimpan data ke master_jabatans
            $data = new MasterJabatan();
            $data->name = $name;
            $data->role = $role;
            $data->save();

            // Menambahkan data ke tabel roles
            Role::create(['name' => $role]);

            DB::commit();

            return redirect('/master-jabatan')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/master-jabatan')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
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
        //

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
        $data = MasterJabatan::find($id);
        $back = url()->previous();
        return view('master.jabatan.edit', compact('data', 'back'));
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
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Mengubah name menjadi role
        $role = strtolower(str_replace(' ', '-', $request->name));
        $name = ucwords($request->name);

        DB::beginTransaction();

        try {
            // Mengupdate data di master_jabatans
            $data = MasterJabatan::findOrFail($id);
            $data->name = $name;
            $data->role = $role;
            $data->save();

            // Mengupdate data di tabel roles
            $existingRole = Role::where('name', $data->role)->first();
            if ($existingRole) {
                $existingRole->name = $role;
                $existingRole->save();
            } else {
                Role::create(['name' => $role]);
            }

            DB::commit();

            return redirect('/master-jabatan')->with('success', 'Data berhasil diubah!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect('/master-jabatan')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = MasterJabatan::find($id);
        $data->delete();

        return redirect('/master-jabatan')->with('success', 'Data Berhasil di Hapus !');
    }
}
