<x-layout>
    <x-slot:title>Home</x-slot:title>
    <header class="page-title">ANNOUNCEMENTS</header>
    @if (auth()->user()->isAdmin())
        <section class="post">
        <div class="input-message">
            <form method="POST" action="{{ route('post-announcement') }}">
                @csrf
                <textarea
                    name="title"
                    placeholder="What is the title of your announcement?"
                    class="message-box"
                    minlength="10"
                ></textarea>
                <textarea
                    name="message"
                    placeholder="What would you like to announce?"
                    class="message-box"
                    minlength="50"
                ></textarea>
                <div style="text-align: center; padding-top: 1vh; justify-content: center;">
                    <button type="submit" class="btn-primary">Post!</button>
                </div>
            </form>
        </div>
    </section>
    <hr>
    @endif
    <section id="announcements">
        @forelse ($announcements as $announcement)
            <div class="posts">
                {{-- <div class="author">{{ $announcement->author }}</div> --}}
                <div class="message">{{ $announcement->message }}</div>
            </div>
        @empty 
            <p>No announcements yet. Please standby.</p>
        @endforelse
    </section>
</x-layout>