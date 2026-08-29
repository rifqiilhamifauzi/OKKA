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
            'is_published' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $slug = Str::slug($request->title);
        
        $originalSlug = $slug;
        $counter = 1;
        while(Announcement::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcements', 'public');
        }

        $announcement = Announcement::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'visibility' => $request->visibility,
            'is_published' => $request->boolean('is_published'),
            'author_id' => Auth::id(),
            'image' => $imagePath,
        ]);

        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Create Announcement',
            'description' => 'Membuat pengumuman baru: ' . $announcement->title,
        ]);

        if ($announcement->is_published) {
            \Illuminate\Support\Facades\Notification::send(\App\Models\User::all(), new \App\Notifications\NewAnnouncement($announcement));
        }

        return redirect()->back()->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function update(Request $request, Announcement $announcement)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'visibility' => 'required|in:global,participants',
            'is_published' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'visibility' => $request->visibility,
            'is_published' => $request->boolean('is_published'),
        ];

        if ($request->hasFile('image')) {
            if ($announcement->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($announcement->image);
            }
            $data['image'] = $request->file('image')->store('announcements', 'public');
        }

        $announcement->update($data);

        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update Announcement',
            'description' => 'Memperbarui pengumuman: ' . $announcement->title,
        ]);

        return redirect()->back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $title = $announcement->title;
        $announcement->delete();

        \App\Models\ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Delete Announcement',
            'description' => 'Menghapus pengumuman: ' . $title,
        ]);

        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}
