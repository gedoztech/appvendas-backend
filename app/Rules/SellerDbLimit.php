<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Seller;

class SellerDbLimit implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Seller::count() <= 10;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The table has limit of 10 rows. Delete some seller and try again.';
    }
}