<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
// use AuthorizesRequests;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Post::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $post = Auth::user()->posts()->create($validated);
        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $post = Post::findOrFail($id);
        $post = Post::find($id);
        // $post = Post::whereNull('deleted_at')->find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post, string $id)
    {
        // $post = Post::findOrFail($id);
        $post = Post::find($id);
        // $this->authorize('update', $post);

        // Jika post tidak ditemukan atau telah dihapus
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Pastikan hanya pemilik post yang bisa mengedit
        if ($post->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required',
        ]);

        $post->update($validated);
        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, string $id)
    {
        // $post = Post::findOrFail($id);
        $post = Post::find($id);
        // $this->authorize('delete', $post);

        // Jika post tidak ditemukan atau telah dihapus
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Pastikan hanya pemilik post yang bisa menghapus
        if ($post->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $post->delete(); // Soft delete

        return response()->json(['message' => 'Post deleted']);
    }
}
