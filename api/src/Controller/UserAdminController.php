<?php

namespace App\Controller;


use App\Entity\User;
use App\Service\UserAdminService;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method json(array $array)
 */
class UserAdminController
{
    /**
     * @Route(
     *     name="make_user_admin",
     *     path="/user/{id}/admin",
     *     methods={"PUT"},
     *     defaults={
     *       "_controller"="\App\Controller\UserAdminController",
     *       "_api_resource_class"="App\Entity\User",
     *       "_api_item_operation_name"="makeUserAdmin"
     *     }
     *   )
     * @param User $data
     * @param UserAdminService $userAdminService
     * @return User
     */
    public function __invoke(User $data, UserAdminService $userAdminService)
    {
        $userAdminService->makeUserAdmin($data);
        return $data;
    }
}
