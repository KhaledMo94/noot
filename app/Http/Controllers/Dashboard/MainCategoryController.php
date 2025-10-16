<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class MainCategoryController extends Controller
{
    public function index()
    {
        $categories = MainCategory::latest('updated_at')->paginate(10);
        return view('admin.main-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.main-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_en'                   => 'required|string|max:255',
            'name_ar'                   => 'required|string|max:255',
            'description_en'            => 'nullable|string',
            'description_ar'            => 'nullable|string',
            'image'                     => 'nullable|image|max:5120',
        ]);

        $image_path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_path = $image->store('categories', 'public');
        }

        MainCategory::create([
            'name'              => [
                'en'                => $request->name_en,
                'ar'                => $request->name_ar,
            ],
            'description'       => [
                'en'                => $request->description_en,
                'ar'                => $request->description_ar,
            ],
            'image'             => $image_path,
        ]);

        return redirect()->route('admins.main-categories.index')
            ->with('success', __('Category Created Successfully'));
    }

    public function edit(MainCategory $mainCategory)
    {
        $category = $mainCategory;
        return view('admin.main-categories.edit', compact('category'));
    }

    public function update(Request $request, MainCategory $mainCategory)
    {
        $request->validate([
            'name_en'                   => 'required|string|max:255',
            'name_ar'                   => 'required|string|max:255',
            'description_en'            => 'nullable|string',
            'description_ar'            => 'nullable|string',
            'image'                     => 'nullable|image|max:5120',
        ]);
        $category = $mainCategory;

        $image_path = $category->image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_path = $image->store('categories', 'public');
        }

        $category->update([
            'name'              => [
                'en'                => $request->name_en,
                'ar'                => $request->name_ar,
            ],
            'description'       => [
                'en'                => $request->description_en,
                'ar'                => $request->description_ar,
            ],
            'image'             => $image_path,
        ]);

        return redirect()->route('admins.main-categories.index')
            ->with('success', __('Category Updated Successfully'));
    }

    public function destroy(MainCategory $mainCategory)
    {
        if ($mainCategory->image) {
            Controller::deleteFile($mainCategory->image);
        }
        $mainCategory->delete();
        return redirect()->route('admins.main-categories.index')
            ->with('success', __('Category Deleted Successfully'));
    }

    public function toggleStatus($id)
    {
        $category = MainCategory::findOrFail($id);

        $category->status = $category->status == 'active' ? 'inactive' : 'active';
        $category->save();

        return response()->json([
            'message'               => __('status changed successfully!')
        ]);
    }
}
