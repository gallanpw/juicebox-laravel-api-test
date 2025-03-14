<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // return false;
        return true; // Semua user bisa melihat daftar post
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        // return false;
        return true; // Semua user bisa melihat post tertentu
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // return false;
        return true; // Semua user yang login bisa membuat post
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        // return false;

        // dd($user->id, $post->user_id, $user->role);
        return ($user->id === $post->user_id) || ($user->role === 'admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        // return false;
        return ($user->id === $post->user_id) || ($user->role === 'admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
