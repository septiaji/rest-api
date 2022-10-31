<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class KendaraanController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = JWTAuth::parseToken()->authenticate();
    }

    public function index()
    {
        return $this->user->kendaraan()->get();
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->only('tahun_keluaran', 'warna', 'harga');
        $validator = Validator::make($data, [
            'tahun_keluaran'    => 'required|string',
            'warna'             => 'required',
            'harga'             => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $kendaraan = $this->user->kendaraan()->create([
            'tahun_keluaran'    => $request->tahun_keluaran,
            'warna'             => $request->warna,
            'harga'             => $request->harga
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kendaraan created successfully',
            'data' => $kendaraan
        ], Response::HTTP_OK);
    }

    public function show($id)
    {
        $kendaraan = $this->user->kendaraan()->find($id);

        if (!$kendaraan) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, kendaraan not found.'
            ], 400);
        }

        return $kendaraan;
    }

    public function edit(Kendaraan $kendaraan)
    {
        //
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $data = $request->only('tahun_keluaran', 'warna', 'harga');
        $validator = Validator::make($data, [
            'tahun_keluaran'    => 'required|string',
            'warna'             => 'required',
            'harga'             => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $kendaraan = $this->user->kendaraan()->update([
            'tahun_keluaran'    => $request->tahun_keluaran,
            'warna'             => $request->warna,
            'harga'             => $request->harga
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kendataan updated successfully',
            'data' => $kendaraan
        ], Response::HTTP_OK);
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kendaraan deleted successfully'
        ], Response::HTTP_OK);
    }
}
