<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        $conversations = [
            [
                'id' => 1,
                'active' => true,
                'name' => 'Elena Rose',
                'initials' => 'ER',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&w=128&q=80',
                'online' => true,
                'verified' => false,
                'is_group' => false,
                'preview' => 'That sounds wonderful! Let\'s plan it this weekend.',
                'time' => '2m ago',
            ],
            [
                'id' => 2,
                'active' => false,
                'name' => 'Dr. Sofia Chen',
                'initials' => 'SC',
                'avatar' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&w=128&q=80',
                'online' => false,
                'verified' => true,
                'is_group' => false,
                'preview' => 'Remember to take small breaks between sessions.',
                'time' => '1h ago',
            ],
            [
                'id' => 3,
                'active' => false,
                'name' => 'Mindful Leaders',
                'initials' => 'ML',
                'avatar' => null,
                'online' => false,
                'verified' => false,
                'is_group' => true,
                'preview' => 'Anna: The new journaling prompt is live!',
                'time' => 'Yesterday',
            ],
        ];

        $messages = [
            [
                'type' => 'date',
                'label' => 'Monday, Oct 24',
            ],
            [
                'type' => 'incoming',
                'content' => 'Hey! How was your morning walk? I tried the new route you suggested.',
                'time' => '10:24 AM',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&w=128&q=80',
                'initials' => 'ER',
            ],
            [
                'type' => 'outgoing',
                'content' => 'It was peaceful! The park was quiet and the air felt crisp. You should join me tomorrow.',
                'time' => '10:26 AM',
                'read' => true,
            ],
            [
                'type' => 'incoming',
                'content' => 'That sounds wonderful! Let\'s plan it this weekend.',
                'time' => '10:28 AM',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&w=128&q=80',
                'initials' => 'ER',
            ],
            [
                'type' => 'incoming',
                'content' => 'Also found this calming yoga flow — thought you might like it.',
                'time' => '10:29 AM',
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&w=128&q=80',
                'initials' => 'ER',
                'image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&w=600&q=80',
            ],
        ];

        $contact = [
            'name' => 'Elena Rose',
            'initials' => 'ER',
            'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&w=256&q=80',
            'location' => 'Sofia, Bulgaria',
            'followers' => '120',
            'joined' => "March '26",
            'interests' => ['#SelfCare', '#Mindfulness', '#Books', '#Yoga'],
            'communities' => [
                ['name' => 'Mindful Leaders', 'members' => '12.4k Members', 'color' => 'bg-[#f3d6d8] text-[#8b5a62]'],
                ['name' => 'Daily Zen', 'members' => '8.2k Members', 'color' => 'bg-[#d4e8e8] text-[#2e7d7d]'],
            ],
        ];

        return view('messages.index', compact('conversations', 'messages', 'contact'));
    }
}
