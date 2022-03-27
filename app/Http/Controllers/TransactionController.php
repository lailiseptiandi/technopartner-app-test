<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $mont = date("m");
        $transactions = Transaction::with('Category')->whereMonth('created_at', $mont)->get();
        $categories = Category::all();

        // jumlah pemasukan
        $pemasukan = DB::table('transactions')
            ->leftJoin('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('categories.type_category', 'pemasukan')
            ->sum(DB::raw('transactions.nominal'));

        // jumlah pengeluaran
        $pengeluaran = DB::table('transactions')
            ->leftJoin('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('categories.type_category', 'pengeluaran')
            ->sum(DB::raw('transactions.nominal'));

        // sisa saldo
        $saldo = $pemasukan - $pengeluaran;

        return view('dashboard.transaction.index', compact(
            'transactions',
            'categories',
            'saldo',
            'pengeluaran',
            'pemasukan'
        ));
    }

    public function filter_transaction(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $transactions = Transaction::whereBetween('created_at', [$start, $end])->get();
        $categories = Category::all();

        // jumlah pemasukan
        $pemasukan = DB::table('transactions')
            ->leftJoin('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('categories.type_category', 'pemasukan')
            ->sum(DB::raw('transactions.nominal'));

        // jumlah pengeluaran
        $pengeluaran = DB::table('transactions')
            ->leftJoin('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('categories.type_category', 'pengeluaran')
            ->sum(DB::raw('transactions.nominal'));

        // sisa saldo
        $saldo = $pemasukan - $pengeluaran;

        return view('dashboard.transaction.index', compact(
            'transactions',
            'categories',
            'saldo',
            'pengeluaran',
            'pemasukan'
        ));
        // return response()->json([
        //     'data' => $transactions
        // ]);
    }

    public function get_category($id_category)
    {
        $categories_data = Category::where('type_category', $id_category)->get();
        return response()->json([
            'data' => $categories_data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'description' => 'required',
            'nominal' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        $transactions = Transaction::create([
            'category_id' => $request->input('category_id'),
            'nominal' => $request->input('nominal'),
            'description' => $request->input('description'),
        ]);
        if (!$transactions) {
            return redirect()->route('transaction.index')->with('toast_error', 'Data gagal disimpan');
        } else {
            return redirect()->route('transaction.index')->with('toast_success', 'Data berhasil disimpan');
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
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'description' => 'required',
            'nominal' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
        }

        $transactions = Transaction::find($id)->update([
            'category_id' => $request->input('category_id'),
            'nominal' => $request->input('nominal'),
            'description' => $request->input('description'),
        ]);
        if (!$transactions) {
            return redirect()->route('transaction.index')->with('toast_error', 'Data gagal disimpan');
        } else {
            return redirect()->route('transaction.index')->with('toast_success', 'Data berhasil disimpan');
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
        Transaction::find($id)->delete();
        return redirect()->back()->with('toast_success', 'Data berhasil dihapus');
    }
}
