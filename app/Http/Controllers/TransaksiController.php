<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $data = new Transaksi();
        if ($request->status) {
            $data = $data->where('status', $request->status);
        }
        if ($request->list == true) {
            $data = $data->with('dataTransaksiDetail.dataProduk')->get();
        } else {
            $data = $data->paginate(3);
        }

        // return $data;
        return $this->sendResponse($data, 'Transaksi berhasil ditampilkan');
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
            'status' => 'required|string|in:Proses,Selesai,Batal',
            'tanggal' => 'required',
            'total' => 'required',
            'tax' => 'required',
            'id_users' => 'required',
            'details' => 'required|array',
            'details.*.id_produk' => 'required',
            'details.*.harga' => 'required',
            'details.*.qty' => 'required',
            'details.*.total' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('validasi error', $validator->errors());
        }
        try {
            //code...
            DB::beginTransaction();
            $input['inv'] = 'INV-' . time() . '-' . Str::random(4);
            $data = Transaksi::create($input);
            $details = $input['details'];
            foreach ($details as $detail) {
                $detail['id_transaksi'] = $data->id;
                TransaksiDetail::create($detail);
            }
            DB::commit();
            return $this->sendResponse($data, 'Transaksi berhasil;');
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->sendError('Error ' . $e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $data = Transaksi::with('dataTransaksiDetail.dataProduk')->find($id);

        return $this->sendResponse($data, 'Data Transaksi');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'status' => 'required|string|in:Proses,Selesai',
            'tanggal' => 'required',
            'total' => 'required',
            'id_users' => 'required',
            'details' => 'required|array',
            'details.*.id_produk' => 'required',
            'details.*.harga' => 'required',
            'details.*.qty' => 'required',
            'details.*.total' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('validasi eprr', $validator->errors());
        }

        try {
            //code...
            DB::beginTransaction();
            $data = Transaksi::find($id);
            $data = $data->update($input);
            TransaksiDetail::where('id_transaksi', $id)->delete();
            $details = $input['details'];
            foreach ($details as $detail) {
                $detail['id_transaksi'] = $data->id;
                TransaksiDetail::create($detail);
            }
            DB::commit();
            return $this->sendResponse($data, 'Transaksi berhasil;');
        } catch (\Throwable $e) {
            //throw $th;
            DB::rollBack();
            return $this->sendError('Error ' . $e->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        try {
            // DB::beginTransaction();

            TransaksiDetail::where('id_transaksi', $id)->delete();
            $data = Transaksi::find($id);
            $data->delete();
            return $this->sendResponse([], 'Transaksi deleted successfully.');
        } catch (\Throwable $e) {
            // DB::rollBack();
            return $this->sendError('Error ' . $e->getMessage(), [], 400);
        }
    }
}
