@if ($reply->trashed())
    <div class="reply reply-deleted" id="reply-{{ $reply->id }}">This reply has been deleted</div>
@else
    @php
        $isOwner = (int) $reply->user_id === (int) auth()->id();
        $canDelete = $isOwner || auth()->user()->can('admins');
    @endphp
    <div class="post-author reply" id="reply-{{ $reply->id }}">
        <img src="{{ asset('images/user-profile.png') }}" alt="">
        <div class="reply-body">
            <strong>{{ $reply->user->first_name . ' ' . $reply->user->last_name }}</strong>
            <small class="post-time">{{ $reply->created_at->format('M j, Y \a\t g:i A') }}@if ($reply->updated_at->gt($reply->created_at)) &middot; Edited @endif</small>
            <div class="message">{{ $reply->message }}</div>

            @if ($canDelete)
                <div class="reply-actions">
                    @if ($isOwner)
                        <button type="button" class="link-btn reply-edit" data-url="{{ route('concern-replies.update', $reply) }}">Edit</button>
                    @endif
                    <button type="button" class="link-btn reply-delete" data-url="{{ route('concern-replies.destroy', $reply) }}">Delete</button>
                </div>
            @endif
        </div>
    </div>
@endif