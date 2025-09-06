<div class="w-64 h-screen bg-white border-r border-gray-200 fixed top-0 left-0 flex flex-col">
    <!-- Logo -->
    <div class="flex items-center justify-center h-20 font-bold text-xl border-b">
        InstaApp
    </div>

    <!-- Menu Utama -->
    <nav class="flex-1 p-6 space-y-4">
        <!-- 🔍 Search Box -->
        <div x-data="{ query: '', results: [] }" class="relative">
            <input type="text" 
                   x-model="query"
                   @keydown.enter.prevent="
                       fetch('/search?keyword=' + query)
                           .then(res => res.json())
                           .then(data => results = data)
                   "
                   placeholder="Search users..."
                   class="w-full border rounded px-3 py-2 text-sm focus:ring focus:ring-blue-300 focus:outline-none" />

            <!-- Dropdown -->
            <div x-show="results.length > 0" 
                 class="absolute top-full mt-1 left-0 w-full bg-white border rounded shadow z-50">
                <template x-for="item in results" :key="item.id">
                    <a :href="'/profile/' + item.name" 
                       class="block px-3 py-2 hover:bg-gray-100 text-sm"
                       x-text="item.name"></a>
                </template>
            </div>
        </div>

        <!-- Navigation Links -->
        <a href="{{ route('home') }}" 
           class="flex items-center space-x-2 text-gray-900 hover:text-blue-500">
            <span>Home</span>
        </a>

        <a href="#" 
           class="flex items-center space-x-2 text-gray-700 hover:text-blue-500">
            <span>Notifications</span>
        </a>

        <a href="{{ route('posts.create') }}" 
           class="flex items-center space-x-2 text-gray-700 hover:text-blue-500">
            <span>Create</span>
        </a>

        <a href="{{ route('profile') }}" 
           class="flex items-center space-x-2 text-gray-700 hover:text-blue-500">
            <span>Profile</span>
        </a>
    </nav>

    <!-- Logout -->
    <div class="p-6 mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="flex items-center space-x-2 text-gray-700 hover:bg-gray-100 w-full text-left px-2 py-2 rounded transition">
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>
