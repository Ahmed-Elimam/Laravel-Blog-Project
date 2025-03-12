<x-layout :title="$post ? 'Edit Post' : 'Create Post'">
    <div class="max-w-3xl mx-auto">
        @if ($errors->any())
        <div role="alert" class="rounded-sm border-s-4 border-red-500 bg-red-50 p-4">
            <div class="flex items-center gap-2 text-red-800">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                <path
                    fill-rule="evenodd"
                    d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z"
                    clip-rule="evenodd"/>
                </svg>
                <strong class="block font-medium"> Something went wrong </strong>
            </div>
                <ul class="mt-2 list-disc list-inside text-red-700">
                @foreach ($errors->all() as $error) 
                     <li>{{ $error }}</li>
                @endforeach
                </ul>
        </div>
        @endif
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">
                    {{ $post ? 'Edit Post' : 'Create New Post' }}
                </h2>
            </div>
            
            <div class="px-6 py-4">
                <form method="POST" action="{{ $post ? route('posts.update', $post['id']) : route('posts.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if($post)
                        @method('PUT')
                    @endif
                
                    <!-- Title Input -->
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input
                            name="title"
                            type="text"
                            id="title"
                            value="{{ old('title', $post['Title'] ?? '') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-2 px-3 border">
                    </div>

                    <!-- Description Textarea -->
                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea
                            name="description"
                            id="description"
                            rows="5"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-2 px-3 border"
                        >{{ old('description', $post['description'] ?? '') }}</textarea>
                    </div>

                     <!-- Post Creator Select -->
                    <div class="mb-6">
                    <label for="creator" class="block text-sm font-medium text-gray-700 mb-1">Post Creator</label>
                    <select
                        name="post_creator"
                        id="creator"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 py-2 px-3 border bg-white">
                        <option value="" disabled {{ !$post ? 'selected' : '' }}>-- Select a Post Creator --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('post_creator', $post['posted_by'] ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    </div>

                    <!-- image upload -->
                    <div class="mb-4">
                        <label for="image" class="block">Image</label>
                        <input
                            name="image"
                            type="file"
                            class="border rounded p-2">
                    </div>
                    @if ($post && $post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-32 h-32">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="remove_image" value="1">
                            <span>Remove Image</span>
                        </label>
                    @endif

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 hover:cursor-pointer">
                            {{ $post ? 'Update' : 'Submit' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
