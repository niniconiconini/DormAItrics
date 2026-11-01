<x-layout>
    <x-slot:title>Home</x-slot:title>
    <section class="announcement">
        <header class="page-title">ANNOUNCEMENTS</header>
        @if (session('success'))
            <div class="announcement-card">
                <p class="slip-success">{{ session('success') }}</p>
            </div>
        @endif
        @if (auth()->user()->isAdmin())
            <section class="post-box">
            <div class="input-message">
                <div class="author post-author">
                    <img src="{{ asset('images/users/user-profile.png') }}" alt="">
                    <span>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</span>
                </div>
                <form method="POST" action="{{ route('announcements.store') }}">
                    @csrf
                    @if ($errors->any())
                        <p class="slip-error">{{ $errors->first() }}</p>
                    @endif
                    <textarea
                        name="title"
                        placeholder="What is the title of your announcement?"
                        class="message-box"
                        maxlength="200"
                    >{{ old('title') }}</textarea>
                    <textarea
                        name="message"
                        placeholder="What would you like to announce?"
                        class="message-box"
                        maxlength="750"
                    >{{ old('message') }}</textarea>
                    <div style="text-align: center; padding-top: 1vh; justify-content: center;">
                        <button type="submit" class="btn-primary">Post!</button>
                    </div>
                </form>
            </div>
        </section>
        <hr>
        @endif
        <section id="list-view" class="list-view">
            @forelse ($announcements as $announcement)
                <div class="card announcement-card">
                    <div class="author post-author">
                        <img src="{{ asset('images/users/user-profile.png') }}" alt="">
                        <div>
                            <span>{{ $announcement->user->first_name . ' ' . $announcement->user->last_name }}</span><br>
                            <small class="post-time">{{ $announcement->created_at->format('M j, Y \a\t g:i A') }}@if ($announcement->updated_at->gt($announcement->created_at)) &middot; Edited @endif</small>
                        </div>

                        {{-- edit and delete: only for the admin who posted it --}}
                        @if ((int) $announcement->user_id === (int) auth()->id())
                            <div class="post-actions">
                                <button type="button" class="btn-primary edit-announcement"
                                    data-action="{{ route('announcements.update', $announcement) }}"
                                    data-title="{{ $announcement->title }}"
                                    data-message="{{ $announcement->message }}">Edit</button>
                                <form action="{{ route('announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your announcement?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-primary btn-danger">Delete</button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <div class="title">{{ $announcement->title }}</div>
                    <div class="message">{{ $announcement->message }}</div>
                </div>
            @empty 
                <p>No announcements yet. Please standby.</p>
            @endforelse
            {{-- Page numbers --}}
            @if ($announcements->hasPages())
                @php
                    $current = $announcements->currentPage();
                    $last = $announcements->lastPage();

                    if ($last <= 7) {
                        $pages = range(1, $last);
                    } elseif ($current <= 4) {
                        $pages = [...range(1, 5), '...', $last];
                    } elseif ($current >= $last - 3) {
                        $pages = [1, '...', ...range($last - 4, $last)];
                    } else {
                        $pages = [1, '...', $current - 1, $current, $current + 1, '...', $last];
                    }
                @endphp
                <nav class="pager" aria-label="Pagination" data-last="{{ $last }}" data-url="{{ $announcements->url(1) }}" data-page-name="{{ $announcements->getPageName() }}">
                    @if ($announcements->onFirstPage())
                        <span class="disabled" aria-label="Previous page">&#9664;&#xFE0E;</span>
                    @else
                        <a href="{{ $announcements->previousPageUrl() }}" aria-label="Previous page">&#9664;&#xFE0E;</a>
                    @endif

                    @foreach ($pages as $page)
                        @if ($page === '...')
                            <button type="button" class="dots" aria-label="Jump to a page">&hellip;</button>
                        @elseif ($page == $current)
                            <span class="active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $announcements->url($page) }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($announcements->hasMorePages())
                        <a href="{{ $announcements->nextPageUrl() }}" aria-label="Next page">&#9654;&#xFE0E;</a>
                    @else
                        <span class="disabled" aria-label="Next page">&#9654;&#xFE0E;</span>
                    @endif
                </nav>
            @endif
        </section>

        {{-- ===== EDIT ANNOUNCEMENT POPUP ===== --}}
        <div id="editModal" hidden>
            <div class="modal">
                <div class="room-modal edit-modal">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <h2 class="modal-title">Edit Announcement</h2>

                        <div class="slip-field">
                            <label for="editTitle">Title</label>
                            <textarea id="editTitle" name="title" rows="2" maxlength="200" required></textarea>
                        </div>
                        <div class="slip-field">
                            <label for="editMessage">Message</label>
                            <textarea id="editMessage" name="message" rows="8" maxlength="750" required></textarea>
                        </div>

                        <div class="slip-submit">
                            <button type="button" class="btn-primary" id="closeEdit">Cancel</button>
                            <button type="submit" class="btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
            const editModal = document.getElementById('editModal');
            const editForm = document.getElementById('editForm');

            document.querySelectorAll('.edit-announcement').forEach(btn => {
                btn.addEventListener('click', () => {
                    editForm.action = btn.dataset.action;
                    document.getElementById('editTitle').value = btn.dataset.title;
                    document.getElementById('editMessage').value = btn.dataset.message;
                    editModal.hidden = false;
                });
            });

            document.getElementById('closeEdit').addEventListener('click', () => editModal.hidden = true);
            document.addEventListener('keydown', e => { if (e.key === 'Escape') editModal.hidden = true; });
        </script>
        
        <script>
            // clicking "..." turns it into a box where you can type a page number
            (() => {
                document.querySelectorAll('.pager .dots').forEach(dots => {
                    dots.addEventListener('click', () => {
                        const nav = dots.closest('.pager');
                        const last = Number(nav.dataset.last);

                        const input = document.createElement('input');
                        input.type = 'number';
                        input.min = 1;
                        input.max = last;
                        input.setAttribute('aria-label', 'Go to page');

                        const restore = () => input.replaceWith(dots);

                        input.addEventListener('keydown', e => {
                            if (e.key === 'Escape') restore();

                            if (e.key === 'Enter') {
                                e.preventDefault();
                                const page = Math.min(Math.max(parseInt(input.value, 10), 1), last);
                                if (!page) return restore();

                                const url = new URL(nav.dataset.url);
                                url.searchParams.set(nav.dataset.pageName, page);
                                location.href = url.href;
                            }
                        });
                        input.addEventListener('blur', restore);

                        dots.replaceWith(input);
                        input.focus();
                    });
                });
            })();
        </script>
    </section>
</x-layout>