<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\ServiceProvider;
use App\Models\ServiceProviderBranch;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceProviderBranchController extends Controller
{

    public function index()
    {
        $branches = ServiceProviderBranch::with(['serviceProvider'])->get();
        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.branches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_ar'                => 'required|string',
            'address_en'                => 'required|string',
            'service_provider_id'       => 'required|exists:service_providers,id',
            'latitude'                  => 'required|numeric|between:-90,90',
            'longitude'                 => 'required|numeric|between:-180,180',
            'phone'                     => 'required|string|max:15',
            'phone_alt'                 => 'nullable|string|max:15',
        ]);

        ServiceProviderBranch::create([
            'service_provider_id'               => $request->service_provider_id,
            'address'                           => [
                'en'                                => $request->address_en,
                'ar'                                => $request->address_ar,
            ],
            'latitude'                          => $request->latitude,
            'longitude'                         => $request->longitude,
            'phone'                             => $request->phone,
            'phone_alt'                         => $request->phone_alt,
        ]);

        return redirect()->route('admins.branches.index')
            ->with('success', __('Branch Added'));
    }

    public function edit($id)
    {
        $branch = ServiceProviderBranch::with(['serviceProvider'])->where('id', $id)->firstOrFail();
        return view('admin.branches.edit', compact('branch'));
    }

    public function update(Request $request,  $id)
    {
        // dd($request->all());
        $request->validate([
            'address_ar'                => 'required|string',
            'address_en'                => 'required|string',
            'service_provider_id'       => 'required|exists:service_providers,id',
            'latitude'                  => 'required|numeric|between:-90,90',
            'longitude'                 => 'required|numeric|between:-180,180',
            'phone'                     => 'required|string|max:15',
            'phone_alt'                 => 'nullable|string|max:15',
        ]);

        ServiceProviderBranch::where('id',$id)->update([
            'service_provider_id'               => $request->service_provider_id,
            'latitude'                          => $request->latitude,
            'longitude'                         => $request->longitude,
            'phone'                             => $request->phone,
            'phone_alt'                         => $request->phone_alt,
            'address'                           => [
                'en'                                => $request->address_en,
                'ar'                                => $request->address_ar,
            ],
        ]);

        return redirect()->route('admins.branches.index')
            ->with('success', __('Branch Updated'));
    }

    public function destroy($id)
    {
        $serviceProviderBranch = ServiceProviderBranch::findOrFail($id);
        $serviceProviderBranch->delete();
        return redirect()->route('admins.branches.index')
            ->with('success', __('Branch Deleted'));
    }

    public function duplicate(Request $request)
    {
        $request->validate([
            'id'                => 'required|exists:service_provider_branches,id',
        ]);

        $branch = ServiceProviderBranch::with(['serviceProvider'])
            ->where('id', $request->query('id'))->firstOrFail();

        return view('admin.branches.duplicate', compact('branch'));
    }

    public function searchBranches(Request $request)
    {
        $providerId = $request->input('provider_id');
        $searchTerm = $request->input('q');
        $locale = app()->getLocale();

        $branches = ServiceProviderBranch::where('service_provider_id', $providerId)
            ->where("address->{$locale}", 'LIKE', "%{$searchTerm}%")
            ->limit(10)
            ->select('id', 'address')
            ->get();

        return response()->json(
            $branches->map(function ($branch) {
                return [
                    'id' => $branch->id,
                    'address' => $branch->address,
                ];
            })
        );
    }
}
