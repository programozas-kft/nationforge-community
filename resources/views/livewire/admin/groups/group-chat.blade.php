<div class="nf-card flex flex-col" style="height: 600px;">
    <div class="nf-card-header flex justify-between items-center bg-gray-50 border-b">
        <h3 class="font-semibold text-gray-800">Szakmai Társalgás</h3>
        <span class="text-xs text-gray-500">Belső kommunikáció</span>
    </div>

    <!-- Üzenetek listája -->
    <div class="flex-1 overflow-y-auto p-4 space-y-4" wire:poll.3s id="chat-messages-container"
         x-data
         x-init="$nextTick(() => { $el.scrollTop = $el.scrollHeight; })"
         x-on:message-sent.window="$nextTick(() => { $el.scrollTop = $el.scrollHeight; })">
        
        @forelse($messages as $msg)
            @php
                $isOwn = $msg->user_id === auth()->id();
            @endphp
            <div class="flex {{ $isOwn ? 'justify-end' : 'justify-start' }}">
                <div class="flex items-end gap-2 max-w-[80%] {{ $isOwn ? 'flex-row-reverse' : '' }}">
                    
                    <!-- Avatar -->
                    <div class="flex-shrink-0">
                        @if($msg->user->photo)
                            <div class="w-8 h-8 rounded-full overflow-hidden shadow-sm">
                                <img src="{{ asset('storage/' . $msg->user->photo) }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-sm"
                                 style="background: {{ $isOwn ? 'linear-gradient(135deg, #405189, #364474)' : 'linear-gradient(135deg, #0ab39c, #099d89)' }}">
                                {{ strtoupper(substr($msg->user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <!-- Üzenet buborék -->
                    <div class="flex flex-col {{ $isOwn ? 'items-end' : 'items-start' }}">
                        <span class="text-[10px] text-gray-400 mb-1 mx-1">{{ $msg->user->name }} • {{ $msg->created_at->format('H:i') }}</span>
                        <div class="px-4 py-2 rounded-2xl text-sm shadow-sm whitespace-pre-wrap {{ $isOwn ? 'bg-[#405189] text-white rounded-br-sm' : 'bg-white border border-gray-100 text-gray-800 rounded-bl-sm' }}">
                            {{ $msg->message }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center h-full text-gray-400 space-y-3">
                <svg class="w-12 h-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                <p class="text-sm">Még nincs üzenet a csoportban.</p>
                <p class="text-xs">Légy te az első!</p>
            </div>
        @endforelse
    </div>

    <!-- Üzenetküldő űrlap -->
    <div class="p-4 bg-gray-50 border-t">
        <form wire:submit.prevent="sendMessage" class="flex gap-2">
            <input type="text" wire:model="message" class="nf-input flex-1 bg-white" placeholder="Írj egy üzenetet..." required autocomplete="off">
            <button type="submit" class="btn-primary px-5 shadow-sm" wire:loading.attr="disabled" wire:target="sendMessage">
                <span wire:loading.remove wire:target="sendMessage">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </span>
                <span wire:loading wire:target="sendMessage">
                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </span>
            </button>
        </form>
        @error('message') <span class="nf-error mt-1">{{ $message }}</span> @enderror
    </div>
</div>
