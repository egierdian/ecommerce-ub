<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::query();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = "<a href='".route('admin.product.edit', ['id'=> encrypt($row->id)])."' class='text-primary text-decoration-none mr-1'><i class='fa fa-edit' data-toggle='tooltip' data-placement='top' title='Update'></i></a>";
                    $btnDelete = "<a href='javascript:void(0)' class='text-danger text-decoration-none' data-toggle='tooltip' data-placement='top' title='Delete'><i class='fa fa-trash-alt' title='Delete' onclick='deleteItem(this)' data-modul='product' data-id='$row->id' data-name='$row->name'></i></a>";

                    return $btnEdit.$btnDelete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('cms.product.index');
    }

    public function create()
    {
        $data = null;
        $type = $this->type();
        return view('cms.product.form', compact('data','type'));
    }

    public function edit($id)
    {
        $data = Product::findOrFail(decrypt($id));
        $type = $this->type();

        return view('cms.product.form', compact('data','type'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:1,2',
            'price' => 'required_if:type,2|numeric|min:1000',
            'base_price_per_hour' => 'required_if:type,1|numeric|min:100',
            'holiday_price_per_hour' => 'nullable|numeric|min:100',
        ]);

        try {
            $param = [
                'name' => $request->name,
                'type' => $request->type,
                'price' => $request->price,
                'base_price_per_hour' => $request->base_price_per_hour,
                'holiday_price_per_hour' => $request->holiday_price_per_hour,
                'description' => $request->description,
                'status' => 1
            ];
            Product::create($param);

            return redirect()->route('admin.product')->with('success', 'Success created!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:1,2',
            'price' => 'required_if:type,2|numeric|min:1000',
            'base_price_per_hour' => 'required_if:type,1|numeric|min:100',
            'holiday_price_per_hour' => 'nullable|numeric|min:100',
        ]);

        try {
            $data = Product::findOrFail($id);
            $param = [
                'name' => $request->name,
                'type' => $request->type,
                'price' => $request->price,
                'base_price_per_hour' => $request->base_price_per_hour,
                'holiday_price_per_hour' => $request->holiday_price_per_hour,
                'description' => $request->description,
            ];
            $data->update($param);

            return redirect()->route('admin.product')->with('success', 'Success updated!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $data = Product::findOrFail($id);
            $param = [
                'status' => 0
            ];
            $data->update($param);


            return redirect()->route('admin.product')->with('success', 'Success deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    private function type() {
        return [
            '1' => 'Sewa',
            '2' => 'Produk'
        ];
    }
}