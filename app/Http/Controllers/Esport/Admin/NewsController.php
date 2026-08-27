<?php

namespace App\Http\Controllers\Esport\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Esport\StoreNewsRequest;
use App\Http\Requests\Esport\UpdateNewsRequest;
use App\Models\News;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $rows = News::latest()->paginate(10);

        return view('esport.admin.news.index', compact('rows'));
    }

    public function create()
    {
        return view('esport.admin.news.create');
    }

    public function store(StoreNewsRequest $r)
    {
        $data = $r->validated();
        if ($r->hasFile('image')) {
            $data['image'] = $r->file('image')->store('news', 'public');
        }
        News::create($data);

        return redirect()->route('esport.admin.news.index')->with('ok', 'Created');
    }

    public function edit(News $news)
    {
        return view('esport.admin.news.edit', compact('news'));
    }

    public function update(UpdateNewsRequest $r, News $news)
    {
        $data = $r->validated();
        if ($r->hasFile('image')) {
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $data['image'] = $r->file('image')->store('news', 'public');
        }
        $news->update($data);

        return redirect()->route('esport.admin.news.index')->with('ok', 'Updated');
    }

    public function destroy(News $news)
    {
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        $news->delete();

        return back()->with('ok', 'Deleted');
    }
}
