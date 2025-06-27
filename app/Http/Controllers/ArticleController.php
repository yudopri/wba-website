<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(9); // Pagination
        return view('admin.article.index', compact('articles'));
    }

    public function showUser()
    {
        $articles = Article::latest()->paginate(9); // Pagination
        return view('articles', compact('articles'));
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.article.show', compact('article'));
    }

    public function showReadmore($id)
    {
        $article = Article::findOrFail($id);

        $latestArticles = Article::latest()
            ->where('id', '!=', $id) // Exclude the current article
            ->take(3)
            ->get();

        return view('readmore', compact('article', 'latestArticles'));
    }

    public function create()
    {
        return view('admin.article.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'date' => 'nullable|date',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $directory = public_path('assets/articles');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true); // Buat folder jika belum ada
            }

            $imagePath = 'assets/articles/' . time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move($directory, $imagePath);
        }

        Article::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'date' => $request->date,
        ]);

        return redirect()->route('admin.article.index')->with('success', 'Article created successfully.');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('admin.article.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'date' => 'nullable|date',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($article->image && File::exists(public_path($article->image))) {
                File::delete(public_path($article->image));
            }

            $directory = public_path('assets/articles');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            $imagePath = 'assets/articles/' . time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move($directory, $imagePath);

            $article->image = $imagePath;
        }

        $article->update($request->only(['title', 'description', 'date']));

        return redirect()->route('admin.article.index')->with('success', 'Article updated successfully.');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        // Hapus gambar jika ada
        if ($article->image && File::exists(public_path($article->image))) {
            File::delete(public_path($article->image));
        }

        $article->delete();

        return redirect()->route('admin.article.index')->with('success', 'Article deleted successfully.');
    }
}
