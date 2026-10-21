<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class PageController extends Controller
{
    /**
     * Ensure the meta_keywords column exists in the pages table.
     */
    private function ensureMetaKeywordsColumn(): void
    {
        try {
            if (!Schema::hasColumn('pages', 'meta_keywords')) {
                Schema::table('pages', function (Blueprint $table) {
                    $table->text('meta_keywords')->nullable()->after('meta_description');
                });
            }
        } catch (\Throwable $e) {
            // Ignore if already exists or DB schema query fails
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $pages = Page::latest()->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->ensureMetaKeywordsColumn();
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $this->ensureMetaKeywordsColumn();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug',
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|string|max:255',
        ]);

        Page::create($validated);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->ensureMetaKeywordsColumn();
        $page = Page::findOrFail($id);

        return view('admin.pages.create', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, string $id)
    {
        $this->ensureMetaKeywordsColumn();
        $page = Page::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'content' => 'required',
            'status' => 'required|in:draft,published',
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|string|max:255',
        ]);

        $page->update($validated);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         Page::findOrFail($id)->delete();
         return back()->with('success', 'Page deleted successfully');
    }
}
