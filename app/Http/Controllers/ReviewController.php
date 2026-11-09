<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Review;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class ReviewController extends Controller
{
    private function currentResident(): ?Resident
    {
        return Resident::where('user_id', Auth::id())->first();
    }

    public function index(): View|RedirectResponse
    {
        $reviews = Review::with('user')
            ->latest('id')
            ->paginate(8)
            ->fragment('reviews-list');

        if ($reviews->isEmpty() && $reviews->currentPage() > 1) {
            return redirect($reviews->url($reviews->lastPage()));
        }

        // dormers can only review once
        $resident = $this->currentResident();
        $isDormer = $resident !== null && ! Gate::allows('admins');
        $hasReviewed = $isDormer && Review::where('resident_id', $resident->id)->exists();

        return view('reviews', [
            'reviews' => $reviews,
            'average' => round((float) Review::avg('review_rating'), 1),
            'total' => Review::count(),
            'canPost' => $isDormer && ! $hasReviewed,
            'hasReviewed' => $hasReviewed,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $resident = $this->currentResident();
        abort_unless($resident !== null && ! Gate::allows('admins'), 403);

        $validated = $request->validate([
            'review_rating' => 'required|integer|between:1,5',
            'title' => 'nullable|string|max:100',
            'message' => 'nullable|string|max:500',
        ]);

        try {
            Review::create($validated + ['resident_id' => $resident->id]);
        } catch (UniqueConstraintViolationException) {
            return redirect()->route('reviews')->with('error', 'You have already submitted a review.');
        }

        return redirect()->route('reviews')->with('success', 'Review submitted. Thank you for your feedback!');
    }

    public function destroy(Review $review): RedirectResponse
    {
        abort_unless(Gate::allows('admins'), 403);

        $review->delete();

        return back()->with('success', 'Review deleted.');
    }
}
