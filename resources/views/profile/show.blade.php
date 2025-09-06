<x-app-layout>
    <div class="flex items-center p-14">
        {{-- Kiri: Foto & Info User --}}
        <div class="flex items-center">
            <img src="{{ asset('storage/' . ($user->profile_picture ?? 'default-avatar.png')) }}" 
                 class="w-48 h-48 rounded-full object-cover">

            <div class="ml-14 -mt-20">
                <h2 class="text-2xl font-bold">{{ $user->name }}</h2>

                <div class="flex space-x-6 mt-2">
                    <span><b>{{ $post->count() }}</b> Posts</span>
                    <span><b>{{ $user->followers()->count() }}</b> Followers</span>
                    <span><b>{{ $user->following()->count() }}</b> Following</span>
                </div>
            </div>
        </div>

        {{-- Kanan: Edit Foto Profil / Follow-Unfollow --}}
        <div class="-mt-24">
            @if(auth()->id() === $user->id)
                {{-- Form Update Foto Profil --}}
                <form action="{{ route('profile.updatePhoto') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-7">
                    @csrf
                    <label class="cursor-pointer px-2 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        <input type="file" name="photo" class="hidden" accept="image/*" onchange="this.form.submit()">
                        Edit Profile Picture
                    </label>
                </form>
            @else
                {{-- Tombol Follow / Unfollow --}}
                @if(auth()->user()->following()->where('followed_user_id', $user->id)->exists())
                    <form action="{{ route('profile.unfollow', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                            Unfollow
                        </button>
                    </form>
                @else
                    <form action="{{ route('profile.follow', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Follow
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mx-14 mb-4 bg-green-100 text-green-700 px-4 py-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Garis pemisah --}}
    <hr class="border-t border-gray-300 -mt-2">

    {{-- Section Posts --}}
    <div class="px-14 mt-2">
        <h3 class="text-xl font-semibold mb-6 text-gray-800">Posts</h3>

        @if($post->count() > 0)
            <div class="grid grid-cols-3 gap-4">
                @foreach($post as $p)
                    <div>
                        <img src="{{ asset('storage/' . $p->image_path) }}"
                             alt="Post"
                             loading="lazy"
                             class="w-full h-72 object-cover rounded-lg shadow hover:opacity-80 cursor-pointer">
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 mt-10">
                {{ auth()->id() === $user->id ? 'Belum ada postingan yang kamu upload.' : 'User ini belum punya postingan.' }}
            </p>
        @endif
    </div>
</x-app-layout>
