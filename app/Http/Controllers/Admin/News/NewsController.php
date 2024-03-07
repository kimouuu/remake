<?php

namespace App\Http\Controllers\Admin\News;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\News\NewsStoreRequest;
use App\Http\Requests\Admin\News\NewsUpdateRequest;
use Illuminate\Support\Str;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        return view('admin.news.index', compact('news'));
    }

    public function show(News $news)
    {
        $news = News::find($news->id);
        return view('admin.news.show', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(NewsStoreRequest $request)
    {
        $validated = $request->validated();
        $news = new News();
        $news->title = $validated['title'];
        $news->description = $validated['description'];
        $news->image = null;
        $this->uploadImage($request, 'image', 'image', $news);
        $news->save();
        return to_route('admin.news.index')->with('success', 'News created successfully.');
    }

    private function uploadImage(Request $request, $inputName, $folder, $news)
    {
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $slug = Str::slug($file->getClientOriginalName());
            $newFileName = time() . '_' . $slug;
            $file->move($folder . '/', $newFileName);
            $news->$inputName = $folder . '/' . $newFileName;
        }
    }

    public function edit(News $news)
    {
        $news = News::find($news->id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(NewsUpdateRequest $request, News $news)
    {
        $validated = $request->validated();
        $news->title = $validated['title'];
        $news->description = $validated['description'];
        $this->updateImage($request, 'image', 'image', $news);
        $news->save();
        return to_route('admin.news.index')->with('success', 'News updated successfully.');
    }

    private function updateImage(Request $request, $inputName, $folder, $news)
    {
        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);
            $slug = Str::slug($file->getClientOriginalName());
            $newFileName = time() . '_' . $slug;
            $file->move($folder . '/', $newFileName);
            $news->$inputName = $folder . '/' . $newFileName;
        } elseif ($request->has($inputName . '_remove')) {
            $news->$inputName = null;
        }
    }

    public function destroy(News $news)
    {
        $news->delete();
        return to_route('admin.news.index')->with('success', 'News deleted successfully.');
    }
}
