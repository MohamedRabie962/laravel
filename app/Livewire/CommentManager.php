<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Comment;
use App\Models\Reply;
use Auth;

class CommentManager extends Component
{
    public $postId, $body, $replyBody, $commentId;

    public function render()
    {
        return view('livewire.comment-manager', [
            'comments' => Comment::where('post_id', $this->postId)->with(['user', 'replies.user'])->get(),
        ]);
    }

    public function storeComment()
    {
        $this->validate([
            'body' => 'required',
        ]);

        Comment::create([
            'body' => $this->body,
            'post_id' => $this->postId,
            'user_id' => Auth::id(),
        ]);

        $this->body = '';
        session()->flash('message', 'Comment added successfully.');
    }
    public function showComments($postId)
    {
        $this->selectedPostId = $postId;
        // Fetch comments for the selected post
        $this->comments = Comment::where('post_id', $postId)->get();
        // Optionally, you can show a modal or a section for comments
    }

    public function storeReply($commentId)
    {
        $this->validate([
            'replyBody' => 'required',
        ]);

        Reply::create([
            'body' => $this->replyBody,
            'comment_id' => $commentId,
            'user_id' => Auth::id(),
        ]);

        $this->replyBody = '';
        session()->flash('message', 'Reply added successfully.');
    }

    public function deleteComment($id)
    {
        Comment::find($id)->delete();
        session()->flash('message', 'Comment deleted successfully.');
    }

    public function deleteReply($id)
    {
        Reply::find($id)->delete();
        session()->flash('message', 'Reply deleted successfully.');
    }
}
