<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store new review
     */
    public function store(Request $request)
    {
        $review = $this->checkIfUserAlreadyReviewedTheProduct($request->product_id,$request->user()->id);

        if($review) {
            return response()->json(([
                'error' => 'You have already reviewed this product.'
            ]));
        }else {
            Review::create([
                'product_id' => $request->product_id,
                'user_id' => $request->user()->id,
                'title' => $request->title,
                'body' => $request->body,
                'rating' => $request->rating
            ]);
            return response()->json(([
                'message' => 'Your review has been added and will be published soon.'
            ]));
        }
    }

    /**
     * Update review
     */
    public function update(Request $request)
    {
        $review = $this->checkIfUserAlreadyReviewedTheProduct($request->product_id,$request->user()->id);

        if($review) {
            $review->update([
                'product_id' => $request->product_id,
                'user_id' => $request->user()->id,
                'title' => $request->title,
                'body' => $request->body,
                'rating' => $request->rating,
                'approved' => 0
            ]);
            return response()->json(([
                'message' => 'Your review has been updated and will be published soon.'
            ]));
        }else {
            return response()->json(([
                'error' => 'Something went wrong try again later.'
            ]));
        }
    }

    /**
     * Delete review
     */
    public function delete(Request $request)
    {
        $review = $this->checkIfUserAlreadyReviewedTheProduct($request->product_id,$request->user()->id);

        if($review) {
            $review->delete();
            return response()->json(([
                'message' => 'Your review has been deleted successfully.'
            ]));
        }else {
            return response()->json(([
                'error' => 'Something went wrong try again later.'
            ]));
        }
    }

    /**
     * Check if the user has already reviewed the product
     */
    public function checkIfUserAlreadyReviewedTheProduct($productId,$userId)
    {
        $review = Review::where([
            'product_id' => $productId,
            'user_id' => $userId
        ])->first();

        return $review;
    }
}
