<?php

namespace App\Http\Controllers\Dashboard;

use App\Facades\Setting as FacadesSetting;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Repositories\GeneralSettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


class GeneralSettingController extends Controller
{
    public function switchLanguage(Request $request)
    {
        $request->validate(['locale' => 'required|in:en,ar']);
        App::setLocale($request->locale);
        Session::put('locale', $request->locale);
        return redirect()->back();
    }

    public function edit()
    {
        $settings = FacadesSetting::all();
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name_en'     => 'required|string|max:255',
            'site_name_ar'     => 'required|string|max:255',
            'logo'             => 'nullable|image|max:2048',
            'favicon'          => 'nullable|image|max:2048',
            'free_trail_days'  => 'required|integer|min:0|max:1000',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('uploads/settings', 'public');
        }
        $iconPath = null;
        if ($request->hasFile('favicon')) {
            $iconPath = $request->file('favicon')->store('uploads/settings', 'public');
        }

        Setting::updateOrInsert(
            ['setting_key' => 'site_name_en'],
            ['setting_value' => $request->site_name_en]
        );

        Setting::updateOrInsert(
            ['setting_key' => 'site_name_ar'],
            ['setting_value' => $request->site_name_ar]
        );

        Setting::updateOrInsert(
            ['setting_key' => 'free_trail_days'],
            ['setting_value' => $request->free_trail_days]
        );

        if ($logoPath) {
            Setting::updateOrInsert(
                ['setting_key' => 'logo'],
                ['setting_value' => $logoPath]
            );
        }

        if ($iconPath) {
            Setting::updateOrInsert(
                ['setting_key' => 'favicon'],
                ['setting_value' => $iconPath]
            );
        }

        Setting::refreshCache();

        return redirect()->back()
            ->with('success',__('Settings Updated'));
    }
}
