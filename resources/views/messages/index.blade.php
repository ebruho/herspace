<x-layouts.messages title="Messages — HerSpace">
    <div class="messages-grid flex w-full">
        <x-messages.conversation-list :conversations="$conversations" />

        <x-messages.chat-window
            contact-name="Elena Rose"
            :online="true"
            :messages="$messages"
        />

        <x-messages.contact-panel :contact="$contact" />
    </div>
</x-layouts.messages>
