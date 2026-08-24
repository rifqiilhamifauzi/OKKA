<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with('author')->orderBy('created_at', 'desc')->get();
        return Inertia::render('Admin/Announcement/Index', [
            'announcements' => $announcements
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'visibility' => 'required|in:global,participants',
            'is_published' => 'boolean'
        ]);

        $slug = Str::slug($request->title);
        
        $originalSlug = $slug;
        $counter = 1;
        while(Announcement::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        Announcement::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'visibility' => $request->visibility,
            'is_published' => $request->boolean('is_published'),
            'author_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'visibility' => 'required|in:global,participants',
            'is_published' => 'boolean'
        ]);

        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'visibility' => $request->visibility,
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}
