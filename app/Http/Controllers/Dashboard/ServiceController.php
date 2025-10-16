<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::withCount('serviceProviders')->latest()->get();
        return view('admin.services.index', compact('services'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_ar'                       => 'required|string|max:255',
            'name_en'                       => 'required|string|max:255',
            'description_ar'                => 'nullable|string',
            'description_en'                => 'nullable|string',
            'discount_label'                => 'required|numeric|min:0|max:100',
            'image'                         => 'nullable|image|max:2048',
        ]);

        $image_path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_path = $image->store('services', 'public');
        }

        $service = Service::create([
            'name'                  => [
                'ar'                    => $request->name_ar,
                'en'                    => $request->name_en,
            ],
            'description'           => [
                'ar'                    => $request->description_ar,
                'en'                    => $request->description_en,
            ],
            'discount_label'        => $request->discount_label,
            'image'                 => $image_path,
        ]);

        if ($service) {
            return redirect()->route('admins.services.index')
                ->with('success', __('Service Added Successfully'));
        }
        return redirect()->back()
            ->with('error', __('Error Occurred Try Again'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name_ar'                       => 'required|string|max:255',
            'name_en'                       => 'required|string|max:255',
            'description_ar'                => 'nullable|string',
            'description_en'                => 'nullable|string',
            'discount_label'                => 'required|numeric|min:0|max:100',
            'image'                         => 'nullable|image|max:2048',
        ]);

        $image_path = $service->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_path = $image->store('services', 'public');
            if ($service->image) {
                Controller::deleteFile($service->image);
            }
        }

        $service->update([
            'name'                  => [
                'ar'                    => $request->name_ar,
                'en'                    => $request->name_en,
            ],
            'description'           => [
                'ar'                    => $request->description_ar,
                'en'                    => $request->description_en,
            ],
            'discount_label'        => $request->discount_label,
            'image'                 => $image_path,
        ]);

        if ($service) {
            return redirect()->route('admins.services.index')
                ->with('success', __('Service Updated Successfully'));
        }
        return redirect()->back()
            ->with('error', __('Error Occurred Try Again'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        if ($service->image) {
            Controller::deleteFile($service->image);
        }

        $service->delete();

        return redirect()->route('admins.services.index')
            ->with('success', __('Service Deleted Successfully'));
    }

}
