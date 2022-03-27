<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // cek saldo saat ini
        $pemasukan = DB::table('transactions')
            ->leftJoin('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('categories.type_category', 'pemasukan')
            ->sum(DB::raw('transactions.nominal'));
        $pengeluaran = DB::table('transactions')
            ->leftJoin('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('categories.type_category', 'pengeluaran')
            ->sum(DB::raw('transactions.nominal'));

        $saldo = $pemasukan - $pengeluaran;
        return view('dashboard.index', compact(
            'saldo',
            'pengeluaran',
            'pemasukan'
        ));
    }
}
