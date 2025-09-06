<x-app-layout>
    <div class="max-w-2xl mx-auto mt-8 p-6 bg-white rounded shadow border border-gray-350">
        <h1 class="text-2xl font-bold mb-4">Bagikan Momenmu Disini</h1>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="image" class="block font-semibold mb-2">Unggah Foto</label>
                <input type="file" name="image" accept="image/*" required>
                @error('image')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="caption" class="block font-semibold mb-1">Caption</label>
                <textarea name="caption" id="caption" rows="3"
                          class="w-full border rounded p-2"
                          placeholder="Tulis sesuatu...">{{ old('caption') }}</textarea>
                @error('caption')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Upload Post
            </button>
        </form>
    </div>
</x-app-layout>
