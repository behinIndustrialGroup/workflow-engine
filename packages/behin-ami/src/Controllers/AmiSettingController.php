<?php

namespace Behin\Ami\Controllers;

use Behin\Ami\Models\AmiSetting;
use Illuminate\Http\Request;

class AmiSettingController
{
    public function index()
    {
        $setting = AmiSetting::first();
        return view('ami::settings', compact('setting'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'host' => 'required',
            'port' => 'required|integer',
            'username' => 'required',
            'password' => 'required',
        ]);
        AmiSetting::query()->updateOrCreate(['id' => 1], $data);
        return redirect()->back()->with('status', 'Settings saved');
    }
}
