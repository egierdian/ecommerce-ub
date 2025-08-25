<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $settings = Setting::get();

        return view('cms.setting.index', compact('settings'));
    }

    public function update(Request $request)
    {
        try {
            foreach($request->value as $id => $v) {
                $data = Setting::where('id', $id)->first();

                $value = $v;
                if($data->type == 'file' && $request->hasFile("value.$id")) {
                    $file = $request->file("value.$id");

                    if($data->value && file_exists(public_path($data->value))) {
                        unlink(public_path($data->value));
                    }

                    $fileName = 'setting-'.Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
                    $base_path = 'uploads/setting';
                    $path = public_path($base_path);
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $file->move($path, $fileName);

                    $value = $base_path.'/'.$fileName;
                }

                $data->update([
                    'value' => $value
                ]);
            }

            return redirect()->route('admin.setting')->with('success', 'Success updated!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}