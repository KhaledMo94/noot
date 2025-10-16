<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $categories = Category::latest('updated_at')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

        Category::create([
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

        return redirect()->route('admins.categories.index')
            ->with('success', __('Category Created Successfully'));
    }


    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name_en'                   => 'required|string|max:255',
            'name_ar'                   => 'required|string|max:255',
            'description_en'            => 'nullable|string',
            'description_ar'            => 'nullable|string',
            'image'                     => 'nullable|image|max:5120',
        ]);

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

        return redirect()->route('admins.categories.index')
            ->with('success', __('Category Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->image) {
            Controller::deleteFile($category->image);
        }
        $category->delete();
        return redirect()->route('admins.categories.index')
            ->with('success', __('Category Updated Successfully'));
    }

    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);

        $category->status = $category->status == 'active' ? 'inactive' : 'active';
        $category->save();

        return response()->json([
            'message'               => __('status changed successfully!')
        ]);
    }

    public function search(Request $request)
    {
        $locale = app()->getLocale();

        $search = "%{$request->query('q')}%";

        $categories = Category::where(function ($query) use ($search, $locale) {
            $query->where("name->{$locale}", 'LIKE', $search)
                ->orWhere("description->{$locale}", 'LIKE', $search);
        })->limit(10)->get();

        return response()->json(
            $categories->map(function ($provider) {
                return [
                    'id' => $provider->id,
                    'text' => $provider->name,
                ];
            })
        );
    }
}
