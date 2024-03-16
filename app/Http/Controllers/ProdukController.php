<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        $data = Produk::with('dataKategori','dataSupplier')->get();

        // return $data;
        return $this->sendResponse($data, 'Produk berhasil ditampilkan');
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
            'nama' => 'required|string|unique:produks',
            'gambar' => 'required|string',
            'harga' => 'required',
            'sn' => 'required|string',
            'stock' => 'required',
            'id_kategori' => 'required',
            'id_supplier' => 'required',

        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors(), 422);
        }
        try {
            //code...
            $data = Produk::create($input);

            return $this->sendResponse($data, 'Produk berhasil di buat');
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
        $data = Produk::find($id);

        return $this->sendResponse($data, "Data Produk");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
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
        $data = Produk::find($id);
        $validator = Validator::make($input, [
            'nama' => 'required|string|unique:produks,nama,' . $id,
            'gambar' => 'required|string',
            'harga' => 'required',
            'sn' => 'required|string',
            'stock' => 'required',
            'id_kategori' => 'required',
            'id_supplier' => 'required',

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
        $data = Produk::find($id);
        try {
            //code...

            $data->delete();
            return $this->sendResponse([], 'Produk berhasil di hapus');
        } catch (\Throwable $e) {
            //throw $th;
            return $this->sendError('Error ' . $e->getMessage(), 400);
        }
    }
}
