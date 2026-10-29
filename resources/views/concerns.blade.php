<x-layout>
    <x-slot:title>Concerns</x-slot:title>
    <section class="announcement">
        <header class="page-title">CONCERNS</header>

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
            <section class="post-box">
            <div class="input-message">
                <div class="author post-author">
                    <img src="{{ asset('images/users/user-profile.png') }}" alt="">
                    <span>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</span>
                </div>
                <form method="POST" action="{{ route('concerns.store') }}">
                    @csrf
                    @if ($errors->any())
                        <p class="slip-error">{{ $errors->first() }}</p>
                    @endif
                    <textarea
                        name="subject"
                        placeholder="What is your concern about?"
                        class="message-box"
                        maxlength="200"
                        required
                    >{{ old('subject') }}</textarea>
                    <textarea
                        name="message"
                        placeholder="Describe your concern"
                        class="message-box"
                        maxlength="750"
                        required
                    >{{ old('message') }}</textarea>
                    <div style="text-align: center; padding-top: 1vh; justify-content: center;">
                        <button type="submit" class="btn-primary">Submit!</button>
                    </div>
                </form>
            </div>
        </section>
        <hr>
        @endif

        <section id="concerns-list" class="list-view">
            @forelse ($concerns as $concern)
                <div class="card announcement-card" id="concern-{{ $concern->id }}">
                    <div class="author post-author">
                        <img src="{{ asset('images/users/user-profile.png') }}" alt="">
                        <div>
                            <span>{{ $concern->reporterName() }}</span><br>
                            <small class="post-time">{{ $concern->created_at->format('M j, Y \a\t g:i A') }}</small>
                        </div>
                        @can('admins')
                            <div class="post-actions">
                                <form method="POST" action="{{ route('concerns.destroy', $concern) }}" onsubmit="return confirm('Are you sure you want to delete this concern? Its replies and likes will be deleted too.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-primary btn-danger">Delete</button>
                                </form>
                            </div>
                        @endcan
                    </div>
                    <div class="title">{{ $concern->subject }}</div>
                    <div class="message">{{ $concern->message }}</div>

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

            {{-- page numbers (only shown when there is more than one page) --}}
            @if ($concerns->hasPages())
                <nav class="pager" aria-label="Pagination">
                    @if ($concerns->onFirstPage())
                        <span class="disabled">&laquo; Previous</span>
                    @else
                        <a href="{{ $concerns->previousPageUrl() }}">&laquo; Previous</a>
                    @endif

                    @foreach ($concerns->getUrlRange(1, $concerns->lastPage()) as $page => $url)
                        @if ($page == $concerns->currentPage())
                            <span class="active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($concerns->hasMorePages())
                        <a href="{{ $concerns->nextPageUrl() }}">Next &raquo;</a>
                    @else
                        <span class="disabled">Next &raquo;</span>
                    @endif
                </nav>
            @endif
        </section>
    </section>

        <script>
            const csrf = "{{ csrf_token() }}";

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
    </section>
</x-layout>