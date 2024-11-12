<div class="container mx-auto mt-2">
    <div class="flex justify-end m-2 p-2">
        <button wire:click="showCreatePostModal" class="bg-green-500 text-white rounded px-4 py-2">
            Create Post
        </button>
    </div>

    <div class="overflow-x-auto">
        <div class="align-middle inline-block min-w-full">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Id</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                        <th scope="col" class="relative px-6 py-3">Edit</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($posts as $post)
                        <tr>
                            <td class="px-6 py-4">{{ $post->id }}</td>
                            <td class="px-6 py-4">{{ $post->title }}</td>
                            <td class="px-6 py-4 text-right">
                                <button wire:click="deletePost({{ $post->id }})" class="bg-red-700 text-white px-4 py-2 rounded">Delete</button>
                                <button wire:click="editPost({{ $post->id }})" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</button>
                                <button wire:click="$dispatch('showComments', {{ $post->id }})" class="bg-blue-500 text-white px-4 py-2 rounded">Comments</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="m-2 p-2">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Create Post Modal -->
    <div class="{{ $showModal ? 'block' : 'hidden' }} fixed inset-0 z-50 overflow-auto bg-smoke-light flex justify-center items-center">
        <div class="bg-white w-full md:max-w-md md:mx-auto rounded shadow-lg mt-10 p-5">
            <h2 class="text-lg font-semibold">Create Post</h2>
            <form enctype="multipart/form-data">
                <div class="mt-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Post Title</label>
                    <input type="text" id="title" wire:model.lazy="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                    @error('title') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mt-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Post Image</label>
                    <input type="file" id="image" wire:model="image" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                    @if ($image)
                        <img src="{{ $image->temporaryUrl() }}" class="mt-2 w-32 h-32" alt="Image Preview" />
                    @elseif ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="mt-2 w-32 h-32" alt="Post Image" />
                    @endif                    @error('image') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mt-4">
                    <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                    <textarea id="body" rows="3" wire:model.lazy="body" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                    @error('body') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>
                <div class="mt-4">
                    <button type="button" wire:click="storePost" class="bg-blue-500 text-white px-4 py-2 rounded">Store</button>
                    <button type="button" wire:click="$set('showModal', false)" class="bg-gray-300 text-black px-4 py-2 rounded">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
