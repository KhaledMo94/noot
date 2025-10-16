<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Exception;
use Illuminate\Http\Request;

class PackageController extends Controller
{

    public function index(Request $request)
    {
        $filters = $request->input('filter', []);

        $packages = \App\Models\Package::query()
            ->filter($filters)
            ->withCount('serviceProviders')
            ->latest()
            ->paginate(10)
            ->appends(['filter' => $filters]);

        $search = $filters['search'] ?? '';

        return view('admin.packages.index', compact('packages', 'search'));
    }


    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en'                       => 'required|string|max:255',
            'name_ar'                       => 'required|string|max:255',
            'description_en'                => 'nullable|string',
            'description_ar'                => 'nullable|string',
            'price'                         => 'required|numeric|min:0',
            'duration_days'                 => 'required|integer|min:1',
            'trial_days'                    => 'required|integer|min:0',
//            'subscribers_count_allowed'     => 'required|integer|min:0',
            'is_active'                     => 'boolean',
        ]);

        try {

            Package::create([
                'name' => [
                    'en' => $request->name_en,
                    'ar' => $request->name_ar,
                ],
                'description' => [
                    'en' => $request->description_en,
                    'ar' => $request->description_ar,
                ],
                'price'                         => $request->price,
                'duration_days'                 => $request->duration_days,
                'trial_days'                    => $request->trial_days,
//                'subscribers_count_allowed'     => $request->subscribers_count_allowed,
                'is_active'                     => $request->has('is_active'),
            ]);

            return redirect()->route('admins.packages.index')
                ->with('success', 'Package created successfully.');

        } catch (Exception $e) {

            return redirect()->back()
                ->with('error', 'Error creating package: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Package $package)
    {
        return view('admin.packages.show', compact('package'));
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $request->validate([
            'name_en'                       => 'required|string|max:255',
            'name_ar'                       => 'required|string|max:255',
            'description_en'                => 'nullable|string',
            'description_ar'                => 'nullable|string',
            'price'                         => 'required|numeric|min:0',
            'duration_days'                 => 'required|integer|min:1',
            'trial_days'                    => 'required|integer|min:0',
//            'subscribers_count_allowed'     => 'required|integer|min:0',
            'is_active'                     => 'boolean',
        ]);

        try {

            $package->update([
                'name' => [
                    'en' => $request->name_en,
                    'ar' => $request->name_ar,
                ],
                'description' => [
                    'en' => $request->description_en,
                    'ar' => $request->description_ar,
                ],
                'price'                         => $request->price,
                'duration_days'                 => $request->duration_days,
                'trial_days'                    => $request->trial_days,
//                'subscribers_count_allowed'     => $request->subscribers_count_allowed,
                'is_active'                     => $request->has('is_active'),
            ]);

            return redirect()->route('admins.packages.index')
                ->with('success', 'Package updated successfully.');

        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating package: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        try {
            $package->delete();
            return redirect()->route('admins.packages.index')
                ->with('success', 'Package deleted successfully.');
        } catch (Exception $e) {
            return redirect()->route('admins.packages.index')
                ->with('error', 'Error deleting package: ' . $e->getMessage());
        }
    }
}
