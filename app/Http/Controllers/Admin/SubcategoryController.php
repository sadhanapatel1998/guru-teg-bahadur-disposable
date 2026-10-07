<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index()
    {
        $subcategories = Subcategory::with('category')->latest()->paginate(10);
        $categories    = Category::active()->get();
        return view('admin.categories.subcategories', compact('subcategories', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', 1)
                        ->orderBy('name')
                        ->get();

        return view('admin.categories.sub-cat-create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'slug'        => 'nullable|string|unique:subcategories',
            'image'       => 'nullable|image|max:2048',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
        ]);
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        if ($request->hasFile('image')) {
            $data['image'] = $this->imageService->store($request->file('image'), 'subcategories');
        }
        Subcategory::create($data);
        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory created.');
    }

    
        /**
         * Edit Form
         */
        public function edit(Subcategory $subcategory)
        {
            $categories = Category::where('is_active', 1)
                            ->orderBy('name')
                            ->get();

            return view(
                'admin.categories.sub-cat-create',
                compact('subcategory', 'categories')
            );
        }

    public function update(Request $request, Subcategory $subcategory)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'slug'        => 'nullable|string|unique:subcategories,slug,'.$subcategory->id,
            'image'       => 'nullable|image|max:2048',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
        ]);
        if ($request->hasFile('image')) {
            $this->imageService->delete($subcategory->image);
            $data['image'] = $this->imageService->store($request->file('image'), 'subcategories');
        }
        $subcategory->update($data);
        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory updated.');
    }

    public function destroy(Subcategory $subcategory)
    {
        $this->imageService->delete($subcategory->image);
        $subcategory->delete();
        return back()->with('success', 'Subcategory deleted.');
    }
}
