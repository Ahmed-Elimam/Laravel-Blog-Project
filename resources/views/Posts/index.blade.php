    <x-layout>
    <div id="app">
    <div class="text-center">
            <a href="{{ 'posts/create' }}" class="mt-4 px-4 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                Create Post
            </a>
        </div>
        <!-- Table Component -->
        <div class="mt-6 rounded-lg border border-gray-200">
            <div class="overflow-x-auto rounded-t-lg">
                <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                    <thead class="text-left">
                        <tr>
                            <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">ID</th>
                            <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">Title</th>
                            <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">Posted By</th>
                            <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">Created At</th>
                            <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">Slug</th>
                            <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">Image</th>
                            <th class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach ($posts as $post)
                        <tr>
                            <td class="px-4 py-2 font-medium whitespace-nowrap text-gray-900">{{ $post->id }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-gray-700">{{$post->Title}}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-gray-700">{{ $post->user ? $post->user->name : "No User Found" }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-gray-700">{{ $post->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-gray-700">{{$post->slug}}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{!! $post->image ? '<img src="' . asset('storage/' . $post->image) . '" alt="Post Image" class="w-16 h-16 object-cover rounded">' : 'No Image' !!}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-gray-700 flex items-center space-x-2">                                <a href="{{ route('posts.show', $post->id) }}" class="inline-block px-4 py-1 text-xs font-medium text-white bg-blue-400 rounded hover:bg-blue-500">View</a>
                                <a href="{{ route('posts.edit', $post->id) }}" class="inline-block bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600">Edit</a>
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline-block" onsubmit="return confirmDelete()">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-block px-4 py-1 text-xs font-medium text-white bg-red-500 rounded hover:bg-red-600">Delete</button>
                                </form>
                                <view-ajax :id="'{{ $post->id }}'" class="inline-block"></view-ajax>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="rounded-b-lg border-t border-gray-200 px-4 py-2"  >{{ $posts->links() }}</div>
        </div>
    </div>
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this post? This action cannot be undone.');
        }
    </script>
    @vite('resources/js/app.js')
    <!-- Include compiled Vue app -->
    </x-layout> 