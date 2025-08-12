<?php

namespace App\Actions\Partner;

use App\Services\Partner\ReviewService;

class GetReviewsDataAction
{
    public function __construct(
        private ReviewService $reviewService
    ) {}

    public function execute(): array
    {
        return [
            'stats' => $this->reviewService->getReviewStats(),
            'reviews' => $this->reviewService->getReviews(),
            'ratingDistribution' => $this->reviewService->getRatingDistribution()
        ];
    }
}