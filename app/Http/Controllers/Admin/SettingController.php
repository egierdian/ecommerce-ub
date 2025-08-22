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
            foreach($request->id as $k => $v) {
                $data = Setting::where('id', $request->id[$k])->first();
                $data->update([
                    'value' => $request->value[$k]
                ]);
            }

            return redirect()->route('admin.setting')->with('success', 'Success updated!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->withInput();
        }
    }
}