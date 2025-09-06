<x-app-layout>
    <div class="p-4 max-w-xl mx-14 space-y-6">
        @if($posts->isEmpty())
            <p class="text-gray-500 text-center mx-auto my-auto">Belum ada postingan.</p>
        @else
            @foreach($posts as $post)
                <div class="bg-white border rounded shadow-sm overflow-hidden">
                    {{-- Header: user info --}}
                    <div class="flex items-center justify-between p-2">
                        <div class="flex items-center">
                            <img src="{{ asset('storage/' . ($post->user->profile_picture ?? 'default-avatar.png')) }}" 
                                 alt="{{ $post->user->name }}" 
                                 class="w-8 h-8 rounded-full object-cover mr-2">
                            <span class="font-semibold text-sm">{{ $post->user->name }}</span>
                        </div>

                        {{-- Hanya pemilik post yang bisa hapus --}}
                        @if(Auth::id() === $post->user_id)
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Yakin hapus post ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 text-xs">Hapus</button>
                            </form>
                        @endif
                    </div>

                    {{-- Gambar post --}}
                    <div class="w-full max-h-[400px] overflow-hidden flex justify-center">
                        <img src="{{ asset('storage/' . $post->image_path) }}" 
                             alt="Post Image" 
                             class="w-full h-auto max-h-[400px] object-contain">
                    </div>

                    {{-- Like & Comment buttons --}}
                    <div class="flex items-center p-2">
                        @if($post->likes->where('user_id', auth()->id())->count() > 0)
                            {{-- Tombol UNLIKE --}}
                            <form action="{{ route('home.posts.unlike', $post->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="font-bold text-sm">
                                    <span class="text-red-500">❤️</span> {{ $post->likes->count() }}
                                </button>
                            </form>
                        @else
                            {{-- Tombol LIKE --}}
                            <form action="{{ route('home.posts.like', $post->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="font-bold text-sm">
                                    <span class="text-gray-400">🤍</span> {{ $post->likes->count() }}
                                </button>
                            </form>
                        @endif

                        {{-- Comment toggle --}}
                        <button onclick="document.getElementById('comment-{{ $post->id }}').classList.toggle('hidden')" 
                                class="text-blue-500 font-bold text-sm ml-3">💬</button>
                    </div>


                    {{-- Caption --}}
                    @if($post->caption)
                        <div class="px-2 pb-2 text-sm flex items-center">
                            <p class="font-bold mr-2">{{ $post->user->name }} </p>
                            <p>{{ $post->caption }}</p>
                        </div>
                    @endif

                    {{-- Comment form --}}
                    <form id="comment-{{ $post->id }}" action="{{ route('home.posts.comment', $post->id) }}" method="POST" class="hidden px-2 pb-2">
                        @csrf
                        <input type="text" name="comment" placeholder="Tulis komentar..." class="border p-2 w-full rounded text-sm">
                        <button type="submit" class="mt-1 px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">Kirim</button>
                    </form>

                    {{-- List komentar --}}
                    <div class="px-2 pb-2 text-sm space-y-1">
                        @foreach($post->comments as $comment)
                            <div class="flex items-center justify-between">
                                <p>
                                    <span class="font-bold">{{ $comment->user->name }}:</span> 
                                    {{ $comment->comment }}
                                </p>

                                {{-- Hapus komentar: hanya pemilik komentar atau pemilik post --}}
                                @if(Auth::id() === $comment->user_id || Auth::id() === $post->user_id)
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Yakin hapus komentar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 text-xs">🗑</button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</x-app-layout>