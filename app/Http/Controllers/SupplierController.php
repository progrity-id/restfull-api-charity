<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = Supplier::all();

        // return $data;
        return $this->sendResponse($data, 'Supplier berhasil ditampilkan');
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
            'nama' => 'required|string|unique:suppliers',
            'nomor_hp' => 'required|string',
            'alamat' => 'required|string',
            'keterangan' => 'required|string',
            'email' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors(), 422);
        }
        try {
            //code...
            $data = Supplier::create($input);

            return $this->sendResponse($data, 'Supplier berhasil di buat');
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
        $data = Supplier::find($id);

        return $this->sendResponse($data, 'Data supplier');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
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
        $data = Supplier::find($id);
        $validator = Validator::make($input, [
            'nama' => 'required|string|unique:suppliers,nama,' . $id,
            'nomor_hp' => 'required|string',
            'alamat' => 'required|string',
            'keterangan' => 'required|string',
            'email' => 'required|string',
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
        $data = Supplier::find($id);
        try {
            //code...
            $data->delete();
            return $this->sendResponse([], 'Supplier berhasil di hapus');
        } catch (\Throwable $e) {
            //throw $th;
            return $this->sendError('Error ' . $e->getMessage(), 400);
        }
    }
}
