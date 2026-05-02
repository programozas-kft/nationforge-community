<?php

namespace App\Livewire\Admin\Groups;

use Livewire\Component;

class GroupChat extends Component
{
    public \App\Models\Group $group;
    public $message = '';

    public function mount(\App\Models\Group $group)
    {
        $this->group = $group;
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required|string|max:1000',
        ]);

        $this->group->messages()->create([
            'user_id' => auth()->id(),
            'message' => $this->message,
        ]);

        $this->reset('message');
    }

    public function render()
    {
        // Vegyük az utolsó 50 üzenetet, hogy ne terhelje túl a klienst
        $messages = $this->group->messages()->with('user')->latest()->take(50)->get()->reverse();

        return view('livewire.admin.groups.group-chat', [
            'messages' => $messages,
        ]);
    }
}
