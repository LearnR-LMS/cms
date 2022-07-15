<?php

namespace App\Services;

use App\Models\User;

class LRService extends BaseService
{
    public function usePen($address_wallet, $pen_id)
    {
        if (!$user = User::where("address_vallet", $address_wallet)->first())
            abort(422, "User chưa có địa chỉ ví.");

        $user->update(["pen_id" => $pen_id]);

        return true;
    }
}
