<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Faq::query()->where("status", 1);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = "<a href='".route('admin.faq.edit', ['id'=> encrypt($row->id)])."' class='text-primary text-decoration-none mr-1'><i class='fa fa-edit' data-toggle='tooltip' data-placement='top' title='Update'></i></a>";
                    $btnDelete = "<a href='javascript:void(0)' class='text-danger text-decoration-none' data-toggle='tooltip' data-placement='top' title='Delete'><i class='fa fa-trash-alt' title='Delete' onclick='deleteItem(this)' data-modul='faq' data-id='$row->id' data-name='$row->title'></i></a>";

                    return $btnEdit.$btnDelete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('cms.faq.index');
    }

    public function create()
    {
        $data = null;
        return view('cms.faq.form', compact('data'));
    }

    public function edit($id)
    {
        $data = Faq::findOrFail(decrypt($id));
        
        return view('cms.faq.form', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',   
            'description' => 'required',   
            'order'  => 'required|numeric|unique:faqs,order',
        ]);

        $validator->validate();

        try {
            $param = [
                'title' => $request->title,
                'description' => $request->description,
                'order' => $request->order,
                'status' => 1,
            ];
            Faq::create($param);

            return redirect()->route('admin.faq')->with('success', 'Success created!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'  => 'required',   
            'description'  => 'required',   
            'order'  => 'required|numeric|unique:faqs,order,' . $id,
        ]);
        $validator->validate();

        try {
            $data = Faq::findOrFail($id);
            $param = [
                'title' => $request->title,
                'description' => $request->description,
                'order' => $request->order,
            ];
            $data->update($param);

            return redirect()->route('admin.faq')->with('success', 'Success updated!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $data = Faq::findOrFail($id);
            $param = [
                'status' => 0
            ];
            $data->update($param);


            return redirect()->route('admin.faq')->with('success', 'Success deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }
}