<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::query()->where("status", 1);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = "<a href='".route('admin.category.edit', ['id'=> encrypt($row->id)])."' class='text-primary text-decoration-none mr-1'><i class='fa fa-edit' data-toggle='tooltip' data-placement='top' title='Update'></i></a>";
                    $btnDelete = "<a href='javascript:void(0)' class='text-danger text-decoration-none' data-toggle='tooltip' data-placement='top' title='Delete'><i class='fa fa-trash-alt' title='Delete' onclick='deleteItem(this)' data-modul='category' data-id='$row->id' data-name='$row->name'></i></a>";

                    return $btnEdit.$btnDelete;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('cms.category.index');
    }

    public function create()
    {
        $data = null;
        return view('cms.category.form', compact('data'));
    }

    public function edit($id)
    {
        $data = Category::findOrFail(decrypt($id));
        
        return view('cms.category.form', compact('data'));
    }

    public function store(Request $request)
    {
        $fileSize = 1024 * 2;
        $validator = Validator::make($request->all(), [
            'name'  => 'required|unique:categories,name',
            'image' => "required|image|mimes:jpg,jpeg,svg,png|max:$fileSize"     
        ]);

        $validator->validate();

        try {
            $param = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'status' => 1,
                'image' => null
            ];
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = 'category-'.Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
                $base_path = 'uploads/category';
                $path = public_path($base_path);
                $file->move($path, $fileName);

                $param['image'] = $base_path .'/'.$fileName;
            }
            Category::create($param);

            return redirect()->route('admin.category')->with('success', 'Success created!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $fileSize = 1024 * 2;
        $validator = Validator::make($request->all(), [
            'name'  => 'required|unique:categories,name,' . $id,
            'image' => "nullable|image|mimes:jpg,jpeg,svg,png|max:$fileSize"   
        ]);
        $validator->validate();

        try {
            $data = Category::findOrFail($id);
            $param = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
            ];

            
            $image = $data->image;
            if($request->hasFile('image'))
            {
                if(isset($image) && file_exists(public_path($image)))
                {
                    $file = $request->file('image');
                    $fileName = 'category-'.Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
                    unlink(public_path($image)); 
                    $base_path = 'uploads/category';
                    $path = public_path($base_path);
                    $file->move($path, $fileName);
                } else {
                    $file = $request->file('image');
                    $fileName = 'category-'.Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
                    $base_path = 'uploads/category';
                    $path = public_path($base_path);
                    $file->move($path, $fileName);
                }
                $param['image'] = $base_path .'/'.$fileName;
            }
            
            $data->update($param);

            return redirect()->route('admin.category')->with('success', 'Success updated!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $data = Category::findOrFail($id);
            $param = [
                'status' => 0
            ];
            
            if(isset($data->image) && file_exists(public_path($data->image)))
            {
                unlink(public_path($data->image));
            }
            $data->update($param);


            return redirect()->route('admin.category')->with('success', 'Success deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }
}