<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Kategori::all();

        // return $data;
        return $this->sendResponse($data, 'Kategori berhasil ditampilkan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        $validator = Validator::make($input, [
            'nama' => 'required|string|unique:kategoris',
            'keterangan' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors(), 422);
        }
        try {
            //code...
            $data = Kategori::create($input);
            return $this->sendResponse($data, 'Kategori berhasil di buat');
        } catch (\Throwable $e) {
            //throw $th;
            return $this->sendError('Error ' . $e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $data = Kategori::find($id);

        return $this->sendResponse($data, "Data kategori");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $input = $request->all();
        $data = Kategori::find($id);
        $validator = Validator::make($input, [
            'nama' => 'required|string|unique:kategoris,nama,' . $id,
            'keterangan' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors(), 422);
        }
        try {
            //code...
            $data->update($input);

            return $this->sendResponse($data, "Kategori berhasil diupdate");

        } catch (\Throwable $e) {
            return $this->sendError('Error ' . $e->getMessage(), 400);
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //

        $data = Kategori::find($id);
        try {
            //code...

            $data->delete();
            return $this->sendResponse([], 'Kategori berhasil di hapus');
        } catch (\Throwable $e) {
            //throw $th;
            return $this->sendError('Error ' . $e->getMessage(), 400);
        }
    }
}
