<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if($user->hasRole('Admin'))
        {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        //
    }


    public function view(User $user, Category $category)
    {
        return $user->hasPermissionTo('view Category');
    }


    public function create(User $user)
    {
        return $user->hasPermissionTo('create Category');
    }


    public function update(User $user, Category $category)
    {
        return $user->hasPermissionTo('update Category');
    }


    public function delete(User $user, Category $category)
    {
        return $user->hasPermissionTo('delete Category');
    }


    public function restore(User $user, Category $category)
    {
        //
    }


    public function forceDelete(User $user, Category $category)
    {
        //
    }
}
