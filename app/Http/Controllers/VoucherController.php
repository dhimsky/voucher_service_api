<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Voucher::all();
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
        $request->validate([
            'code' => 'required|unique:vouchers',
            'expiry_date' => 'required|date'
        ],[
            'code.required' => 'Masukan kode voucher!',
            'code.unique' => 'Kode sudah digunakan!',
            'expiry_date.required' => 'Masukan tanggal kedaluarsa!',
            'expiry_date.date' => 'Gunakan format tanggal!'
        ]);

        return Voucher::create($request->all());
    }

    public function redeem(Request $request)
    {
        $voucher = Voucher::where('code', $request->code)->first();
    
        if (!$voucher || $voucher->isExpired() || $voucher->is_active === 0) {
            return response(['message' => 'Voucher tidak valid atau sudah kadaluarsa'], 400);
        }
    
        return response(['message' => 'Voucher berhasil digunakan']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Voucher $voucher)
    {
        return $voucher;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Voucher $voucher)
    {
        $voucher->update($request->all());
        return $voucher;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return response(null, 204);
    }
}
