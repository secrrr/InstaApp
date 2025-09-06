<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(string $name)
    {
        $user = User::where('name', $name)->firstOrFail();

        $post = $user->posts()->latest()->get();

        $isOwner = auth()->check() && auth()->id() === $user->id;

        return view('profile.show', compact('user', 'post', 'isOwner'));
    }


    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $request->user();

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $path = $photo->storeAs('profile_picture', $filename, 'public');
            
            if (!empty($user->profile_picture) && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $user->update([
                'profile_picture' => $path,
            ]);
        }
        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');


    }

    public function follow($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            return back()->with('error', 'Kamu tidak bisa follow diri sendiri.');
        }

        // cek dulu kalau sudah follow biar gak error duplicate
        if (!auth()->user()->following()->where('followed_user_id', $user->id)->exists()) {
            auth()->user()->following()->attach($user->id);
        }

        return back()->with('success', 'Kamu berhasil follow ' . $user->name);
    }

    public function unfollow($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            return back()->with('error', 'Kamu tidak bisa unfollow diri sendiri.');
        }

        auth()->user()->following()->detach($user->id);

        return back()->with('success', 'Kamu berhenti follow ' . $user->name);
    }


}
