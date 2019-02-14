<?php

namespace App\Service;

use App\Entity\User;

class UserAdminService
{
    public function makeUserAdmin(User $user)
    {
        $user->setRoles('ROLE_ADMIN');

        //This is bad ! Must be changed
        $user->setPlainPassword(' ');
        return;
    }
}
