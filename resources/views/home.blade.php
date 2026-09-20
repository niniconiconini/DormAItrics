<x-layout>
    <x-slot:title>Home</x-slot:title>
    <header class="page-title">ANNOUNCEMENTS</header>
    <section class="post">
        <div class="input-message">
            <form method="POST" action="/">
                @csrf
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
    {{-- <section id="announcements">
        @foreach ($announcements as $announcement)
            <div class="posts">
                <div class="author">{{ $announcement['author'] }}</div>
                <div class="message">{{ $announcement['message'] }}</div>
            </div>
        @endforeach
    </section> --}}
</x-layout>