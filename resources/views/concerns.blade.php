<x-layout>
    <x-slot:title>Concerns</x-slot:title>
    <section class="announcement concerns-page">
        <header class="page-title">CONCERNS</header>
            @can('admins')
                <nav class="concern-management-tabs" aria-label="Filter concerns by visibility">
                    <a href="{{ route('concerns', ['visibility' => 'public']) }}" class="concern-tab {{ $visibility === 'public' ? 'active' : '' }}" @if ($visibility === 'public') aria-current="page" @endif>PUBLIC</a>
                    <span class="concern-tab-divider" aria-hidden="true">|</span>
                    <a href="{{ route('concerns', ['visibility' => 'private']) }}" class="concern-tab {{ $visibility === 'private' ? 'active' : '' }}" @if ($visibility === 'private') aria-current="page" @endif>PRIVATE</a>
                </nav>
            @endcan

        @if (session('success'))
            <div class="announcement-card">
                <p class="slip-success">{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->reply->any())
            <div class="announcement-card">
                <p class="slip-error">{{ $errors->reply->first() }}</p>
            </div>
        @endif

        {{-- only residents can post a concern --}}
        @if ($canPost)
            <section class="post-box concern-compose">
            <div class="input-message">
                <div class="author post-author">
                    <img src="{{ asset(auth()->user()->profile_picture ?: 'images/users/user-profile.png') }}" alt="{{ auth()->user()->userName() }} profile picture">
                    <span>{{ auth()->user()->userName() }}</span>
                </div>
                <form id="concern-form" method="POST" action="{{ route('concerns.store') }}">
                    @csrf
                    @if ($errors->any())
                        <p class="slip-error">{{ $errors->first() }}</p>
                    @endif
                    <label for="concern-message">Your concern:</label>
                    <textarea id="concern-message" name="message" placeholder="Write your concern..." class="message-box" maxlength="750" required>{{ old('message') }}</textarea>
                    <label for="concern-visibility">Who can see this?</label>
                    <select id="concern-visibility" name="visibility" required>
                        <option value="public" @selected(old('visibility', 'public') === 'public')>Public - visible to all dormers and admins</option>
                        <option value="private" @selected(old('visibility') === 'private')>Private - visible to you and admins</option>
                    </select> 
                    <div style="text-align: center; padding-top: 1vh; justify-content: center;">
                        <button type="submit" class="btn-primary">Submit!</button>
                    </div>
                </form>
                <dialog id="concern-confirmation" class="concern-confirmation confirmation-modal" aria-labelledby="concern-confirmation-title" aria-describedby="concern-confirmation-message">
                    <h2 id="concern-confirmation-title">Submit this concern?</h2>
                    <p id="concern-confirmation-message">After submitting, you will not be able to edit or delete this concern. Are you sure you want to continue?</p>
                    <div class="concern-confirmation-actions">
                        <button type="button" id="cancel-concern-submit" class="btn-primary btn-danger">Cancel</button>
                        <button type="button" id="confirm-concern-submit" class="btn-primary">Continue</button>
                    </div>
                </dialog>                
            </div>
        </section>
        <hr>
        @endif

        @if ($canPost)
            <nav class="concern-management-tabs" aria-label="Filter concerns">
                <a href="{{ route('concerns', ['visibility' => 'public']) }}" class="concern-tab {{ $visibility === 'public' ? 'active' : '' }}" @if ($visibility === 'public') aria-current="page" @endif>PUBLIC CONCERNS</a>
                <span class="concern-tab-divider" aria-hidden="true">|</span>
                <a href="{{ route('concerns', ['visibility' => 'private']) }}" class="concern-tab {{ $visibility === 'private' ? 'active' : '' }}" @if ($visibility === 'private') aria-current="page" @endif>MY PRIVATE CONCERNS</a>
            </nav>
        @endif

        <section id="concerns-list" class="list-view">
            @forelse ($concerns as $concern)
                <div class="card announcement-card concern-card" id="concern-{{ $concern->id }}">
                    <div class="author post-author">
                        <img src="{{ asset($concern->user?->profile_picture ?: 'images/users/user-profile.png') }}" alt="{{ $concern->reporterName() }} profile picture">
                            <div class="concern-author-info">
                                <div class="concern-author-name">
                                    <span>{{ $concern->reporterName() }}</span>
                                    <span class="concern-visibility-badge {{ $concern->visibility === 'private' ? 'is-private' : 'is-public' }}">{{ strtoupper($concern->visibility) }}</span>
                                    <span class="concern-status-badge status-{{ $concern->status }}">{{ strtoupper($concern->status) }}</span>
                                </div>
                                <small class="post-time">{{ $concern->created_at->format('M j, Y \a\t g:i A') }}</small>
                            </div>
                        @can('admins')
                            <div class="post-actions concern-admin-actions">
                                @if ($concern->status === 'pending')
                                    <form method="POST" action="{{ route('concerns.status', $concern) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="acknowledged">
                                        <button type="submit" class="btn-primary concern-acknowledge-button">Acknowledge</button>
                                    </form>
                                @endif
                                @if ($concern->status !== 'resolved')
                                    <form method="POST" action="{{ route('concerns.status', $concern) }}" class="resolve-concern-form">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="resolved">
                                        <button type="submit" class="btn-primary concern-resolve-button">Resolve</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('concerns.destroy', $concern) }}" onsubmit="return confirm('Are you sure you want to delete this concern? Its replies and likes will be deleted too.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-primary btn-danger">Delete</button>
                                </form>
                            </div>
                        @endcan           
                    </div>
                <div class="message concern-message">{{ $concern->message }}</div>

                    <div class="concern-actions">
                        <form method="POST" action="{{ route('concerns.like', $concern) }}" class="like-form">
                            @csrf
                            <button type="submit" class="like-btn {{ $concern->liked_by_me ? 'liked' : '' }}">
                                {{ $concern->liked_by_me ? '♥ Liked' : '♡ Like' }}
                            </button>
                        </form>
                        <span class="like-total">{{ $concern->liked_by_count }} {{ $concern->liked_by_count == 1 ? 'like' : 'likes' }}</span>
                        @php $replyCount = $concern->replies->whereNull('deleted_at')->count(); @endphp
                        <span class="reply-total">{{ $replyCount }} {{ $replyCount == 1 ? 'reply' : 'replies' }}</span>
                    </div>

                    <div class="concern-replies">
                        <div class="reply-list">
                            @foreach ($concern->replies as $reply)
                                @include('concernsreply', ['reply' => $reply])
                            @endforeach
                        </div>

                        <form method="POST" action="{{ route('concerns.reply', $concern) }}" class="reply-form">
                            @csrf
                            <input type="text" name="reply" placeholder="Write a reply..." maxlength="1000" required>
                            <button type="submit" class="btn-primary">Reply</button>
                        </form>
                        <p class="slip-error reply-error" hidden></p>
                    </div>
                </div>
            @empty
                <p>No concerns yet.</p>
            @endforelse

            {{-- page numbers --}}
            @if ($concerns->hasPages())
                @php
                    $current = $concerns->currentPage();
                    $last = $concerns->lastPage();

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
                <nav class="pager" aria-label="Pagination" data-last="{{ $last }}" data-url="{{ $concerns->url(1) }}" data-page-name="{{ $concerns->getPageName() }}">
                    @if ($concerns->onFirstPage())
                        <span class="disabled" aria-label="Previous page">&#9664;&#xFE0E;</span>
                    @else
                        <a href="{{ $concerns->previousPageUrl() }}" aria-label="Previous page">&#9664;&#xFE0E;</a>
                    @endif

                    @foreach ($pages as $page)
                        @if ($page === '...')
                            <button type="button" class="dots" aria-label="Jump to a page">&hellip;</button>
                        @elseif ($page == $current)
                            <span class="active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $concerns->url($page) }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($concerns->hasMorePages())
                        <a href="{{ $concerns->nextPageUrl() }}" aria-label="Next page">&#9654;&#xFE0E;</a>
                    @else
                        <span class="disabled" aria-label="Next page">&#9654;&#xFE0E;</span>
                    @endif
                </nav>
            @endif
        </section>

        @can('admins')
            <dialog id="resolve-confirmation" class="concern-confirmation" aria-labelledby="resolve-confirmation-title" aria-describedby="resolve-confirmation-message">
                <h2 id="resolve-confirmation-title">Resolve this concern?</h2>
                <p id="resolve-confirmation-message">Are you sure you want to mark this concern as resolved?</p>
                <div class="concern-confirmation-actions">
                    <button type="button" id="cancel-resolve-concern" class="btn-primary btn-danger">Cancel</button>
                    <button type="button" id="confirm-resolve-concern" class="btn-primary">Resolve</button>
                </div>
            </dialog>
        @endcan        

        <script>
            const csrf = "{{ csrf_token() }}";

            // ask for confirmation before resolving a concern
            const resolveConfirmation = document.getElementById('resolve-confirmation');
            const confirmResolveButton = document.getElementById('confirm-resolve-concern');
            const cancelResolveButton = document.getElementById('cancel-resolve-concern');
            let pendingResolveForm = null;

            if (resolveConfirmation && confirmResolveButton && cancelResolveButton) {
                document.querySelectorAll('.resolve-concern-form').forEach(form => {
                    form.addEventListener('submit', event => {
                        if (form.dataset.confirmed === 'true') {
                            form.dataset.confirmed = 'false';
                            return;
                        }

                        event.preventDefault();
                        pendingResolveForm = form;
                        resolveConfirmation.showModal();
                    });
                });

                cancelResolveButton.addEventListener('click', () => {
                    pendingResolveForm = null;
                    resolveConfirmation.close();
                });

                confirmResolveButton.addEventListener('click', () => {
                    if (!pendingResolveForm) {
                        return;
                    }

                    const form = pendingResolveForm;
                    pendingResolveForm = null;
                    form.dataset.confirmed = 'true';
                    resolveConfirmation.close();
                    form.requestSubmit();
                });

                resolveConfirmation.addEventListener('cancel', () => {
                    pendingResolveForm = null;
                });
            }

            // ask for confirmation before sending a concern 
            const concernForm = document.getElementById('concern-form');
            const concernConfirmation = document.getElementById('concern-confirmation');
            const confirmConcernButton = document.getElementById('confirm-concern-submit');
            const cancelConcernButton = document.getElementById('cancel-concern-submit');
            let concernSubmissionConfirmed = false;

            if (concernForm && concernConfirmation && confirmConcernButton && cancelConcernButton) {
                concernForm.addEventListener('submit', event => {
                    if (concernSubmissionConfirmed) {
                        concernSubmissionConfirmed = false;
                        return;
                    }

                    event.preventDefault();
                    concernConfirmation.showModal();
                });

                cancelConcernButton.addEventListener('click', () => {
                    concernConfirmation.close();
                });

                confirmConcernButton.addEventListener('click', () => {
                    concernSubmissionConfirmed = true;
                    concernConfirmation.close();
                    concernForm.requestSubmit();
                });
            }            

            function htmlToElement(html) {
                const tpl = document.createElement('template');
                tpl.innerHTML = html.trim();
                return tpl.content.firstElementChild;
            }

            function send(url, method, fields = {}) {
                const body = new FormData();
                body.append('_token', csrf);
                if (method !== 'POST') body.append('_method', method);
                Object.entries(fields).forEach(([key, value]) => body.append(key, value));
                return fetch(url, { method: 'POST', body, headers: { 'Accept': 'application/json' } });
            }

            function setReplyTotal(card, count) {
                card.querySelector('.reply-total').textContent = `${count} ${count === 1 ? 'reply' : 'replies'}`;
            }

            // like or unlike without reloading
            document.querySelectorAll('.like-form').forEach(form => {
                form.addEventListener('submit', async e => {
                    e.preventDefault();
                    const btn = form.querySelector('button');
                    btn.disabled = true;

                    try {
                        const res = await fetch(form.action, {
                            method: 'POST',
                            body: new FormData(form),
                            headers: { 'Accept': 'application/json' },
                        });
                        if (!res.ok) throw new Error();
                        const data = await res.json();

                        btn.classList.toggle('liked', data.liked);
                        btn.textContent = data.liked ? '♥ Liked' : '♡ Like';
                        form.closest('.concern-actions').querySelector('.like-total').textContent =
                            `${data.likes} ${data.likes === 1 ? 'like' : 'likes'}`;
                    } catch {
                        location.reload(); 
                    }

                    btn.disabled = false;
                });
            });

            // reply without reloading
            document.querySelectorAll('.reply-form').forEach(form => {
                form.addEventListener('submit', async e => {
                    e.preventDefault();
                    const card = form.closest('.announcement-card');
                    const errorEl = card.querySelector('.reply-error');
                    const btn = form.querySelector('button');
                    btn.disabled = true;
                    errorEl.hidden = true;

                    try {
                        const res = await fetch(form.action, {
                            method: 'POST',
                            body: new FormData(form),
                            headers: { 'Accept': 'application/json' },
                        });

                        if (res.status === 422) {
                            const data = await res.json();
                            errorEl.textContent = Object.values(data.errors).flat()[0];
                            errorEl.hidden = false;
                        } else if (res.ok) {
                            const data = await res.json();
                            card.querySelector('.reply-list').append(htmlToElement(data.html));
                            setReplyTotal(card, data.count);
                            form.reset();
                        } else {
                            location.reload();
                        }
                    } catch {
                        location.reload();
                    }

                    btn.disabled = false;
                });
            });

            document.addEventListener('click', async e => {
                const editBtn = e.target.closest('.reply-edit');
                if (editBtn) {
                    const body = editBtn.closest('.reply-body');
                    const message = body.querySelector('.message');

                    const form = document.createElement('form');
                    form.className = 'reply-edit-form';
                    form.dataset.url = editBtn.dataset.url;
                    form.innerHTML = `
                        <input type="text" maxlength="1000" required>
                        <button type="submit" class="btn-primary">Save</button>
                        <button type="button" class="btn-primary reply-edit-cancel">Cancel</button>`;
                    form.querySelector('input').value = message.textContent;

                    message.hidden = true;
                    body.querySelector('.reply-actions').hidden = true;
                    body.append(form);
                    form.querySelector('input').focus();
                    return;
                }

                const cancelBtn = e.target.closest('.reply-edit-cancel');
                if (cancelBtn) {
                    const body = cancelBtn.closest('.reply-body');
                    body.querySelector('.reply-edit-form').remove();
                    body.querySelector('.message').hidden = false;
                    body.querySelector('.reply-actions').hidden = false;
                    return;
                }

                const deleteBtn = e.target.closest('.reply-delete');
                if (deleteBtn) {
                    if (!confirm('Are you sure you want to delete this reply?')) return;

                    const reply = deleteBtn.closest('.reply');
                    const card = reply.closest('.announcement-card');

                    try {
                        const res = await send(deleteBtn.dataset.url, 'DELETE');
                        if (!res.ok) throw new Error();
                        const data = await res.json();

                        reply.replaceWith(htmlToElement(data.html));
                        setReplyTotal(card, data.count);
                    } catch {
                        location.reload();
                    }
                }
            });

            document.addEventListener('submit', async e => {
                const form = e.target.closest('.reply-edit-form');
                if (!form) return;
                e.preventDefault();

                const reply = form.closest('.reply');
                const errorEl = reply.closest('.announcement-card').querySelector('.reply-error');
                errorEl.hidden = true;

                try {
                    const res = await send(form.dataset.url, 'PUT', { reply: form.querySelector('input').value });

                    if (res.status === 422) {
                        const data = await res.json();
                        errorEl.textContent = Object.values(data.errors).flat()[0];
                        errorEl.hidden = false;
                    } else if (res.ok) {
                        const data = await res.json();
                        reply.replaceWith(htmlToElement(data.html));
                    } else {
                        location.reload();
                    }
                } catch {
                    location.reload();
                }
            });
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

                        // put the "..." back
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