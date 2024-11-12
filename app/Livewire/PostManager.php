<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostManager extends Component
{
    use WithFileUploads, WithPagination;

    public $title, $body, $image, $postId, $showModal = false;

    public function render()
    {
        $posts = Post::with('user')->paginate(10);
        return view('livewire.post-manager', ['posts' => $posts]);
    }

    public function showCreatePostModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }



    public function storePost()
    {
        $this->validate([
            'title' => 'required',
            'body' => 'required',
            'image' => 'image|max:2048', // Ensure this validation is correct
        ]);

        if ($this->image) {
            $imagePath = $this->image->store('photos', 'public'); // Store the image
        }

        Post::create([
            'title' => $this->title,
            'body' => $this->body,
            'image' => $imagePath ?? null, // Use the stored path
            'user_id' => Auth::id(),
        ]);

        // Reset form fields after submission
        $this->reset(['title', 'body', 'image']);
        session()->flash('message', 'Post created successfully.');
    }

        public function resetForm()
    {
        $this->title = '';
        $this->body = '';
        $this->image = null;
        $this->postId = null;
    }

    public function deletePost($id)
    {
        Post::find($id)->delete();
        session()->flash('message', 'Post deleted successfully.');
    }
    public $selectedPostId;

    public function editPost($id)
    {
        $this->selectedPostId = $id;
        $post = Post::find($id);
        $this->title = $post->title;
        $this->body = $post->body;
        $this->image = null; // Reset image if you don't want to pre-fill it
        $this->showModal = true; // Show the modal
    }

    public function updatePost()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'image' => 'nullable|image|max:2048', // Validate image
        ]);

        $post = Post::find($this->selectedPostId);
        $post->title = $this->title;
        $post->body = $this->body;

        if ($this->image) {
            // Handle image upload
            $post->image = $this->image->store('posts', 'public');
        }

        $post->save();

        // Reset fields and close modal
        $this->reset(['title', 'body', 'image', 'showModal']);
        $this->emit('postUpdated'); // Optional: Emit an event for other components to listen
    }
}
