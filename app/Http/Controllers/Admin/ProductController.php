<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::query()->where("status", 1);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = "<a href='".route('admin.product.edit', ['id'=> encrypt($row->id)])."' class='text-primary text-decoration-none mr-1'><i class='fa fa-edit' data-toggle='tooltip' data-placement='top' title='Update'></i></a>";
                    $btnDelete = "<a href='javascript:void(0)' class='text-danger text-decoration-none' data-toggle='tooltip' data-placement='top' title='Delete'><i class='fa fa-trash-alt' title='Delete' onclick='deleteItem(this)' data-modul='product' data-id='$row->id' data-name='$row->name'></i></a>";

                    return $btnEdit.$btnDelete;
                })
                ->addColumn('type', function ($row) {
                    $label = 'Produk';
                    if($row->type == '1') {
                        $label = 'Sewa';
                    }
                    return $label;
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
        $images = [];
        $categories = Category::where('status', 1)->get();
        return view('cms.product.form', compact('data','type','images','categories'));
    }

    public function edit($id)
    {
        $data = Product::findOrFail(decrypt($id));
        $type = $this->type();

        $data->price = number_format($data->price, 0, ',', '.');
        $data->holiday_price_per_hour = number_format($data->holiday_price_per_hour, 0, ',', '.');
        $data->base_price_per_hour = number_format($data->base_price_per_hour, 0, ',', '.');

        $images = ProductImage::where('product_id', decrypt($id))->get();
        $categories = Category::where('status', 1)->get();

        return view('cms.product.form', compact('data','type','images','categories'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'price' => str_replace('.', '', $request->price),
            'holiday_price_per_hour' => str_replace('.', '', $request->holiday_price_per_hour),
            'base_price_per_hour' => str_replace('.', '', $request->base_price_per_hour),
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required|in:1,2',
            'category' => 'required',
            'holiday_price_per_hour' => 'nullable|numeric',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,svg,png|max:5120',
        ]);

        $validator->sometimes('price', 'required|numeric|min:1000', function ($input) {
            return $input->type == 2;
        });
        
        $validator->sometimes('qty', 'required|numeric|min:1', function ($input) {
            return $input->type == 2;
        });

        $validator->sometimes('base_price_per_hour', 'required|numeric|min:100', function ($input) {
            return $input->type == 1;
        });
        $validator->validate();

        try {
            $param = [
                'name' => $request->name,
                'type' => $request->type,
                'category' => $request->category,
                'status' => 1
            ];
            $price = null;
            $base_price_per_hour = null;
            $holiday_price_per_hour = null;
            $qty = null;
            if($request->type == 1) {
                $base_price_per_hour =  $request->base_price_per_hour;
                $holiday_price_per_hour =  $request->holiday_price_per_hour;
            } else {
                $price =  $request->price;
                $qty = $request->qty;
            }
            $param['base_price_per_hour'] = $base_price_per_hour;
            $param['holiday_price_per_hour'] = $holiday_price_per_hour;
            $param['price'] =  $price;
            $param['qty'] =  $qty;
            $product = Product::create($param);

            $productId = $product->id;
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $fileName = 'product-'.Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
                    $base_path = 'uploads/product';
                    $path = public_path($base_path);
                    $file->move($path, $fileName);

                    $paramImage = [
                        'product_id' => $productId,
                        'name' => $fileName,
                        'path' => $base_path .'/'.$fileName
                    ];
                    ProductImage::create($paramImage);
                }
            }

            return redirect()->route('admin.product')->with('success', 'Success created!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->merge([
            'price' => str_replace('.', '', $request->price),
            'holiday_price_per_hour' => str_replace('.', '', $request->holiday_price_per_hour),
            'base_price_per_hour' => str_replace('.', '', $request->base_price_per_hour),
        ]);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required|in:1,2',
            'category' => 'required',
            'holiday_price_per_hour' => 'nullable|numeric',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,svg,png|max:5120',
        ]);

        $validator->sometimes('price', 'required|numeric|min:1000', function ($input) {
            return $input->type == 2;
        });

        $validator->sometimes('qty', 'required|numeric|min:1', function ($input) {
            return $input->type == 2;
        });

        $validator->sometimes('base_price_per_hour', 'required|numeric|min:100', function ($input) {
            return $input->type == 1;
        });

        $validator->validate();

        try {
            $data = Product::findOrFail($id);
            $param = [
                'name' => $request->name,
                'type' => $request->type,
                'category' => $request->category,
                'description' => $request->description,
            ];
            $price = null;
            $base_price_per_hour = null;
            $holiday_price_per_hour = null;
            $qty = null;
            if($request->type == 1) {
                $base_price_per_hour =  $request->base_price_per_hour;
                $holiday_price_per_hour =  $request->holiday_price_per_hour;
            } else {
                $price =  $request->price;
                $qty = $request->qty;
            }
            $data['base_price_per_hour'] = $base_price_per_hour;
            $data['holiday_price_per_hour'] = $holiday_price_per_hour;
            $data['price'] =  $price;
            $data['qty'] =  $qty;
            $data->update($param);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $fileName = 'product-'.Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
                    $base_path = 'uploads/product';
                    $path = public_path($base_path);
                    $file->move($path, $fileName);

                    $paramImage = [
                        'product_id' => $id,
                        'name' => $fileName,
                        'path' => $base_path .'/'.$fileName
                    ];
                    ProductImage::create($paramImage);
                }
            }

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

    public function deleteImage($id, $imageId = null) {
        try {
            $id = decrypt($id);
            if ($imageId) {
                $image = ProductImage::findOrFail($imageId);

                $this->deleteImageFile($image->path);
                $image->delete();

            } else {
                $images = ProductImage::where('product_id', $id)->get();

                foreach ($images as $img) {
                    $this->deleteImageFile($img->path);
                    $img->delete();
                }
            }

            return redirect()->route('admin.product.edit', ['id' => encrypt($id)])->with('success', 'Success deleted!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput();
        }
    }

    private function deleteImageFile($path)
    {
        if ($path) {
            $fullPath = public_path($path);

            if (file_exists($fullPath)) {
                @unlink($fullPath); // pakai @ supaya tidak error kalau gagal
            }
        }
    }
    
    private function type() {
        return [
            '1' => 'Sewa',
            '2' => 'Produk'
        ];
    }
}