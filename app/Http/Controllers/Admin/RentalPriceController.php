<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\RentalPrice;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RentalPriceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RentalPrice::query()
                ->leftJoin('products', 'products.id', '=', 'rental_prices.product_id')
                ->select("rental_prices.*","products.name as productName")
                ->where("rental_prices.status", 1);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = "<a href='".route('admin.rental-price.edit', ['id'=> encrypt($row->id)])."' class='text-primary text-decoration-none mr-1'><i class='fa fa-edit' data-toggle='tooltip' data-placement='top' title='Update'></i></a>";
                    $btnDelete = "<a href='javascript:void(0)' class='text-danger text-decoration-none' data-toggle='tooltip' data-placement='top' title='Delete'><i class='fa fa-trash-alt' title='Delete' onclick='deleteItem(this)' data-modul='rental-price' data-id='$row->id' data-name='$row->productName'></i></a>";

                    return $btnEdit.$btnDelete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('cms.rental-price.index');
    }

    public function create()
    {
        $data = null;
        $products = Product::where('status',1)->get();
        return view('cms.rental-price.form', compact('data','products'));
    }

    public function edit($id)
    {
        $data = RentalPrice::findOrFail(decrypt($id));
        $products = Product::where('status',1)->get();

        $data->spesial_price = number_format($data->spesial_price, 0, ',', '.');

        return view('cms.rental-price.form', compact('data','products'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'spesial_price' => str_replace('.', '', $request->spesial_price),
        ]);

        $validator = Validator::make($request->all(), [
            'product' => 'required',
            'date' => 'required|date',
            'spesial_price' => 'required|numeric|min:100',
        ]);

        $validator->validate();

        try {
            $param = [
                'date' => $request->date,
                'product_id' => $request->product,
                'spesial_price' => $request->spesial_price,
                'status' => 1
            ];
            RentalPrice::create($param);

            return redirect()->route('admin.rental-price')->with('success', 'Success created!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'spesial_price' => str_replace('.', '', $request->spesial_price),
        ]);

        $validator = Validator::make($request->all(), [
            'product' => 'required',
            'date' => 'required|date',
            'spesial_price' => 'required|numeric|min:100',
        ]);

        $validator->validate();

        try {
            $data = RentalPrice::findOrFail($id);
            $param = [
                'date' => $request->date,
                'product_id' => $request->product,
                'spesial_price' => $request->spesial_price,
            ];
            $data->update($param);

            return redirect()->route('admin.rental-price')->with('success', 'Success updated!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $data = RentalPrice::findOrFail($id);
            $param = [
                'status' => 0
            ];
            $data->update($param);


            return redirect()->route('admin.rental-price')->with('success', 'Success deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }
}