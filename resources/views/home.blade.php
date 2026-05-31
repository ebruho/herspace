<x-layouts.app title="Home - HerSpace">
    <div class="space-y-6">
        <x-feed.composer />

        <x-feed.tabs active="for-you" />

        <div class="space-y-6 pt-2">
            <x-feed.post-card
                author-name="Elena Rose"
                author-initials="ER"
                meta="in Self-Care Sunday · 2 hours ago"
                body="Caught the most beautiful sunset tonight. Sometimes the simplest moments are the ones that heal us the most. Taking a deep breath and letting the day go."
                image="https://images.unsplash.com/photo-1495616811223-4d98c6e9c869?auto=format&w=900&q=80"
                image-alt="Sunset over the ocean"
                likes="1.2k"
                comments="84"
            />

            <x-feed.post-card
                author-name="Maya Lin"
                author-initials="ML"
                meta="in Book Club · 5 hours ago"
                quote="Books are uniquely portable magic."
                body="Looking for my next read — something uplifting with strong female characters. What would you recommend?"  
                likes="432"
                comments="156"  
            />

             <x-feed.post-card
                author-name="Jordan Ellis"
                author-initials="JE"
                meta="in Creative Souls · 8 hours ago"
                body="Started a morning journaling ritual this week. Three things I'm grateful for, one intention for the day. Small habit, big shift in mindset."
                likes="289"
                comments="41"
            />

            <x-feed.post-card
                author-name="Priya Shah"
                author-initials="PS"
                meta="in Mindful Leaders · 1 day ago"
                body="Reminder: rest is productive. You don't have to earn your right to pause."
                image="https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&w=900&q=80"
                image-alt="Calm morning tea setup"
                likes="876"
                comments="92"
            />

             <x-feed.post-card
                author-name="Elena Rose"
                author-initials="ER"
                meta="in Self-Care Sunday · 2 hours ago"
                body="Caught the most beautiful sunset tonight. Sometimes the simplest moments are the ones that heal us the most. Taking a deep breath and letting the day go."
                image="https://images.unsplash.com/photo-1495616811223-4d98c6e9c869?auto=format&w=900&q=80"
                image-alt="Sunset over the ocean"
                likes="1.2k"
                comments="84"
            />

            <x-feed.post-card
                author-name="Maya Lin"
                author-initials="ML"
                meta="in Book Club · 5 hours ago"
                quote="Books are uniquely portable magic."
                body="Looking for my next read — something uplifting with strong female characters. What would you recommend?"
                likes="432"
                comments="156"
                :show-share="false"
            />

            <x-feed.post-card
                author-name="Jordan Ellis"
                author-initials="JE"
                meta="in Creative Souls · 8 hours ago"
                body="Started a morning journaling ritual this week. Three things I'm grateful for, one intention for the day. Small habit, big shift in mindset."
                likes="289"
                comments="41"
            />

            <x-feed.post-card
                author-name="Priya Shah"
                author-initials="PS"
                meta="in Mindful Leaders · 1 day ago"
                body="Reminder: rest is productive. You don't have to earn your right to pause."
                image="https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&w=900&q=80"
                image-alt="Calm morning tea setup"
                likes="876"
                comments="92"
            />
        </div>
    </div>

</x-layouts.app>