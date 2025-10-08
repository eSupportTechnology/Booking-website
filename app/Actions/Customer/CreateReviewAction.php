<?php

namespace App\Actions\Customer;

use App\Models\Review;
use App\DTOs\Customer\ReviewDTO;

class CreateReviewAction
{
    public function execute(ReviewDTO $reviewDTO): Review
    {
        return Review::create($reviewDTO->toArray());
    }
}