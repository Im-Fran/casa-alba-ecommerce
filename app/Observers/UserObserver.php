<?php

namespace App\Observers;

use App\Models\User;
use Lunar\Models\Customer;

class UserObserver {
    public function created(User $user): void {
        /* Create customer on user creation, identified by the 'VAT No' which in Chile is the R.U.T or Tributary Unique Role */
        $user->customers()->create([
            'first_name' => $user->name,
            'last_name' => $user->last_name,
            'vat_no' => $user->rut,
        ]);
    }

    public function updated(User $user): void {
        /* Also update self customer, in case the user is part of another customer model */
        $user->customers()->whereVatNo($user->rut)->update([
            'first_name' => $user->name,
            'last_name' => $user->last_name,
        ]);
    }

    public function deleted(User $user): void {
        /* Only delete self customer */
        $user->customers()->whereVatNo($user->rut)->delete();
    }
}
