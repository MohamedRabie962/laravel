<div>
    <h3 class="font-semibold">Comments</h3>
    <form wire:submit.prevent="storeComment">
        <textarea wire:model="body" class="border rounded w-full mt-2"></textarea>
        @error('body') <span class="text-red-500">{{ $message }}</span> @enderror
        <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2 mt-2">Add Comment</button>
    </form>

    <ul class="mt-4">
        @foreach($comments as $comment)
            <li class="flex justify-between items-center mt-2">
                <p>{{ $comment->body }} - <small>{{ $comment->user->name }}</small></p>
                <button wire:click="deleteComment({{ $comment->id }})" class="bg-red-500 text-white rounded px-2">Delete</button>

                <!-- Reply Form -->
                <form wire:submit.prevent="storeReply({{ $comment->id }})" class="ml-4">
                    <input type="text" wire:model="replyBody" class="border rounded w-1/2" placeholder="Reply...">
                    @error('replyBody') <span class="text-red-500">{{ $message }}</span> @enderror
                    <button type="submit" class="bg-green-500 text-white rounded px-2">Reply</button>
                </form>

                <ul class="mt-2 ml-4">
                    @foreach($comment->replies as $reply)
                        <li class="flex justify-between items-center">
                            <p>{{ $reply->body }} - <small>{{ $reply->user->name }}</small></p>
                            <button wire:click="deleteReply({{ $reply->id }})" class="bg-red-500 text-white rounded px-2">Delete</button>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
</div>
