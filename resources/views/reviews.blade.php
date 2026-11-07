<x-layout>
    <x-slot:title>Reviews</x-slot:title>
    <section class="announcement">
        <header class="page-title">REVIEWS</header>

        @if (session('success'))
            <div class="announcement-card">
                <p class="slip-success">{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="announcement-card">
                <p class="slip-error">{{ session('error') }}</p>
            </div>
        @endif

        {{-- average of all reviews --}}
        <div class="card announcement-card review-summary">
            @if ($total > 0)
                <div class="review-average">{{ number_format($average, 1) }}<small> / 5</small></div>
                <div class="avg-stars" style="--fill: {{ $average / 5 * 100 }}%" aria-label="{{ $average }} out of 5 stars">★★★★★</div>
                <div>Based on {{ $total }} {{ $total == 1 ? 'review' : 'reviews' }}</div>
            @else
                <div>No reviews yet.</div>
            @endif
        </div>

        {{-- dormers who already reviewed can't submit another one --}}
        @if ($hasReviewed)
            <div class="announcement-card">
                <p class="slip-success">You have already submitted your review. Thank you for your feedback!</p>
            </div>
            <hr>
        @endif  
        
        {{-- only dormers can submit a review --}}
        @if ($canPost)
            <section class="post-box">
            <div class="input-message">
                <div class="author post-author">
                    <img src="{{ asset('images/users/user-profile.png') }}" alt="">
                    <span>{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</span>
                </div>
                <form method="POST" action="{{ route('reviews.store') }}" id="reviewForm">
                    @csrf
                    <p class="slip-error" id="reviewError" @unless ($errors->any()) hidden @endunless>{{ $errors->first() }}</p>

                    <div class="star-rating">
                        <div id="starButtons">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" class="rate-star" data-value="{{ $i }}" aria-label="{{ $i }} star">★</button>
                            @endfor
                        </div>
                        <span class="rating-word" id="ratingWord">Select a rating</span>
                    </div>
                    <input type="hidden" name="review_rating" id="reviewRating" value="{{ old('review_rating') }}">

                    <textarea
                        name="title"
                        placeholder="Give your review a title"
                        class="message-box"
                        rows="1"
                        maxlength="100"
                    >{{ old('title') }}</textarea>
                    <textarea
                        name="message"
                        placeholder="Tell us about your experience"
                        class="message-box"
                        maxlength="500"
                    >{{ old('message') }}</textarea>
                    <div style="text-align: center; padding-top: 1vh; justify-content: center;">
                        <button type="submit" class="btn-primary">Submit Review</button>
                    </div>
                </form>
            </div>
        </section>
        <hr>
        @endif

        <section id="reviews-list" class="list-view">
            @forelse ($reviews as $review)
                <div class="card announcement-card">
                    <div class="author post-author">
                        <img src="{{ asset('images/users/user-profile.png') }}" alt="">
                        <div>
                            <span>{{ $review->reviewerName() }}</span><br>
                            <small class="post-time">{{ $review->created_at->format('M j, Y \a\t g:i A') }}</small>
                        </div>

                        {{-- admins can delete any review --}}
                        @can('admins')
                            <div class="post-actions">
                                <form method="POST" action="{{ route('reviews.destroy', $review) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-primary btn-danger review-delete">Delete</button>
                                </form>
                            </div>
                        @endcan
                    </div>
                    <div class="review-stars" aria-label="{{ $review->review_rating }} out of 5 stars">{{ str_repeat('★', (int) $review->review_rating) }}{{ str_repeat('☆', 5 - (int) $review->review_rating) }}</div>
                    @if ($review->title)
                        <div class="title">{{ $review->title }}</div>
                    @endif
                    @if ($review->message)
                        <div class="message">{{ $review->message }}</div>
                    @endif
                </div>
            @empty
                <p>No reviews to show.</p>
            @endforelse

            {{-- page numbers: first pages, "...", last page (only shown when there is more than one page) --}}
            @if ($reviews->hasPages())
                @php
                    $current = $reviews->currentPage();
                    $last = $reviews->lastPage();

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
                <nav class="pager" aria-label="Pagination" data-last="{{ $last }}" data-url="{{ $reviews->url(1) }}" data-page-name="{{ $reviews->getPageName() }}">
                    @if ($reviews->onFirstPage())
                        <span class="disabled" aria-label="Previous page">&#9664;&#xFE0E;</span>
                    @else
                        <a href="{{ $reviews->previousPageUrl() }}" aria-label="Previous page">&#9664;&#xFE0E;</a>
                    @endif

                    @foreach ($pages as $page)
                        @if ($page === '...')
                            <button type="button" class="dots" aria-label="Jump to a page">&hellip;</button>
                        @elseif ($page == $current)
                            <span class="active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $reviews->url($page) }}">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($reviews->hasMorePages())
                        <a href="{{ $reviews->nextPageUrl() }}" aria-label="Next page">&#9654;&#xFE0E;</a>
                    @else
                        <span class="disabled" aria-label="Next page">&#9654;&#xFE0E;</span>
                    @endif
                </nav>
            @endif
        </section>

        {{-- ===== DORMERS: confirm before submitting a review ===== --}}
        @if ($canPost)
            <div id="submitReviewModal" hidden>
                <div class="modal">
                    <div class="room-modal delete-modal">
                        <h2 class="modal-title">Are you sure you want to submit this review?</h2>
                        <p>You won't be able to edit or delete this review afterwards.</p>
                        <div class="slip-submit">
                            <button type="button" class="btn-primary" id="cancelSubmit">Cancel</button>
                            <button type="button" class="btn-primary" id="confirmSubmit">Submit Review</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            (() => {
                console.log('Reviews script loaded');

                // the word shown for each star
                const words = { 1: 'Poor', 2: 'Fair', 3: 'Good', 4: 'Very Good', 5: 'Excellent' };

                const stars = document.querySelectorAll('#starButtons .rate-star');
                const ratingInput = document.getElementById('reviewRating');
                const ratingWord = document.getElementById('ratingWord');
                const reviewError = document.getElementById('reviewError');
                const reviewForm = document.getElementById('reviewForm');
                const submitModal = document.getElementById('submitReviewModal');

                function paint(value) {
                    stars.forEach(star => star.classList.toggle('on', Number(star.dataset.value) <= value));
                    ratingWord.textContent = value ? words[value] : 'Select a rating';
                }

                stars.forEach(star => {
                    star.addEventListener('mouseenter', () => paint(Number(star.dataset.value)));

                    star.addEventListener('click', () => {
                        ratingInput.value = star.dataset.value;
                        paint(Number(star.dataset.value));
                    });
                });

                document.getElementById('starButtons').addEventListener('mouseleave', () => paint(Number(ratingInput.value) || 0));

                paint(Number(ratingInput.value) || 0);

                reviewForm.addEventListener('submit', e => {
                    e.preventDefault();

                    if (!ratingInput.value) {
                        reviewError.textContent = 'Please select a star rating.';
                        reviewError.hidden = false;
                        return;
                    }

                    reviewError.hidden = true;
                    submitModal.hidden = false;
                });

                document.getElementById('cancelSubmit').addEventListener('click', () => submitModal.hidden = true);
                document.getElementById('confirmSubmit').addEventListener('click', () => reviewForm.submit());
                document.addEventListener('keydown', e => { if (e.key === 'Escape') submitModal.hidden = true; });
            })();
            </script>
        @endif

        {{-- ===== ADMINS: confirm before deleting a review ===== --}}
        @can('admins')
            <div id="deleteReviewModal" hidden>
                <div class="modal">
                    <div class="room-modal delete-modal">
                        <h2 class="modal-title">Delete Review</h2>
                        <p>Are you sure you want to delete this review? This cannot be undone.</p>
                        <div class="slip-submit">
                            <button type="button" class="btn-primary" id="cancelDeleteReview">Cancel</button>
                            <button type="button" class="btn-primary btn-danger" id="confirmDeleteReview">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            (() => {
                const deleteModal = document.getElementById('deleteReviewModal');
                let pendingForm = null;  

                document.querySelectorAll('.review-delete').forEach(btn => {
                    btn.addEventListener('click', () => {
                        pendingForm = btn.closest('form');
                        deleteModal.hidden = false;
                    });
                });

                document.getElementById('cancelDeleteReview').addEventListener('click', () => deleteModal.hidden = true);
                document.getElementById('confirmDeleteReview').addEventListener('click', () => pendingForm?.submit());
                document.addEventListener('keydown', e => { if (e.key === 'Escape') deleteModal.hidden = true; });
            })();
            </script>
        @endcan
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