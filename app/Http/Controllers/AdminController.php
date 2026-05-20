<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use App\Models\Movie;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalMovies = Movie::count();
        $totalUsers = User::count();
        $totalReviews = Review::count();
        return view('admin.dashboard', compact('totalMovies', 'totalUsers', 'totalReviews'));
    }

    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return redirect()->route('admin.users')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroyUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'No puedes eliminar a otro administrador.');
        }

        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    public function reviews()
    {
        $reviews = Review::with(['user', 'movie'])->latest()->paginate(20);
        return view('admin.reviews', compact('reviews'));
    }

    public function destroyReview(Review $review)
    {
        $movieId = $review->movie_id;
        $review->delete();

        return redirect()->route('admin.reviews')
            ->with('success', 'Comentario eliminado correctamente.');
    }
}
