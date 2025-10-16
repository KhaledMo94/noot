<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\ServiceProvidersCreatedEvent;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Service;
use App\Models\ServiceProvider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Laravolt\Avatar\Facade as Avatar;

use Throwable;

class ServiceProviderController extends Controller
{
    public function index()
    {
        $providers = ServiceProvider::with(['category'])->latest()->get();
        return view('admin.providers.index', compact('providers'));
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->active()->get();
        return view('admin.providers.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'time_from' => 'required|date_format:H:i',
            'time_to' => 'required|date_format:H:i',
        ]);

        $image_path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_path = $image->store('providers', 'public');
        }

        ServiceProvider::create([
            'name'                      => [
                'ar'                        => $request->name_ar,
                'en'                        => $request->name_en,
            ],
            'description'               => [
                'ar'                        => $request->description_ar,
                'en'                        => $request->description_en,
            ],
            'image'                     => $image_path,
            'options'                   => [
                'open_at'                   => $request->time_from,
                'close_at'                  => $request->time_to,
            ],
            'category_id'               => $request->category_id,
        ]);

        return redirect()->route('admins.providers.index')
            ->with('success', __('Service Provider created successfully.'));
    }

    public function show(ServiceProvider $serviceProvider)
    {
        $serviceProvider->load(['category']);
        $provider = $serviceProvider;
        return view('admin.providers.show', compact('provider'));
    }

    public function edit(ServiceProvider $serviceProvider)
    {
        $categories = Category::select('id', 'name')->active()->get();
        $provider = $serviceProvider;
        return view('admin.providers.edit', compact('categories', 'provider'));
    }

    public function update(Request $request, ServiceProvider $serviceProvider)
    {
        $request->validate([
            'name_ar'                       => 'required|string|max:255',
            'name_en'                       => 'required|string|max:255',
            'description_ar'                => 'nullable|string',
            'description_en'                => 'nullable|string',
            'image'                         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category_id'                   => 'required|exists:categories,id',
            'time_from'                     => 'required|date_format:H:i',
            'time_to'                       => 'required|date_format:H:i',
        ]);

        $image_path = $serviceProvider->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_path = $image->store('providers', 'public');
            if ($serviceProvider->image) {
                Controller::deleteFile($serviceProvider->image);
            }
        }

        $serviceProvider->update([
            'name'                      => [
                'ar'                        => $request->name_ar,
                'en'                        => $request->name_en,
            ],
            'description'               => [
                'ar'                        => $request->description_ar,
                'en'                        => $request->description_en,
            ],
            'image'                     => $image_path,
            'options'                   => [
                'open_at'                   => $request->time_from,
                'close_at'                  => $request->time_to,
            ],
            'category_id'               => $request->category_id,
        ]);

        return redirect()->route('admins.providers.index')
            ->with('success', __('Service Provider update successfully.'));
    }

    public function destroy(ServiceProvider $serviceProvider)
    {
        if ($serviceProvider->image) {
            Controller::deleteFile($serviceProvider->image);
        }

        $serviceProvider->delete();

        return redirect()->route('admins.providers.index')
            ->with('success', __('Service Provider Deleted successfully.'));
    }

    public function toggleStatus($id)
    {
        $provider = ServiceProvider::findOrFail($id);
        $provider->status = $provider->status == 'active' ? 'inactive' : 'active';
        $provider->save();

        return response()->json([
            'message'           => __('Status Changed'),
        ]);
    }

    public function search(Request $request)
    {
        $locale = app()->getLocale();

        $search = "%{$request->query('q')}%";

        $providers = ServiceProvider::active()->where(function ($query) use ($search, $locale) {
            $query->where("name->{$locale}", 'LIKE', $search);
        })->limit(10)->get();

        return response()->json(
            $providers->map(function ($provider) {
                return [
                    'id' => $provider->id,
                    'name' => $provider->name,
                ];
            })
        );
    }
}
