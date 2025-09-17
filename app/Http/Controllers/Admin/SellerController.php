<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query()->where("role", "seller");

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = "<a href='".route('admin.seller.edit', ['id'=> encrypt($row->id)])."' class='text-primary text-decoration-none mr-1'><i class='fa fa-edit' data-toggle='tooltip' data-placement='top' title='Update'></i></a>";
                    $btnDelete = "<a href='javascript:void(0)' class='text-danger text-decoration-none' data-toggle='tooltip' data-placement='top' title='Delete'><i class='fa fa-trash-alt' title='Delete' onclick='deleteItem(this)' data-modul='seller' data-id='$row->id' data-name='$row->name'></i></a>";

                    return $btnEdit.$btnDelete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('cms.seller.index');
    }

    public function create()
    {
        $data = null;
        return view('cms.seller.form', compact('data'));
    }

    public function edit($id)
    {
        $data = User::findOrFail(decrypt($id));
        
        return view('cms.seller.form', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',     
            'password'  => 'required',   
            'email'  => 'required|unique:users,email',
            'phone' => ['required', 'regex:/^0[0-9]{0,15}$/', 'max:16'],
        ]);

        $validator->validate();

        try {
            $param = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'status' => 1,
                'role' => 'seller'
            ];
            User::create($param);

            return redirect()->route('admin.seller')->with('success', 'Success created!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'  => 'required|unique:users,email,' . $id,
            'phone' => ['required', 'regex:/^0[0-9]{0,15}$/', 'max:16'],
        ]);
        $validator->validate();

        try {
            $data = User::findOrFail($id);
            $param = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ];
            $data->update($param);

            return redirect()->route('admin.seller')->with('success', 'Success updated!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $data = User::findOrFail($id);
            $param = [
                'status' => 0
            ];
            $data->update($param);


            return redirect()->route('admin.seller')->with('success', 'Success deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }
}