<?php

namespace App\Policies\Admins;

use App\Models\Slider;
use App\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminReviewPolicy
{
    use HandlesAuthorization;


    public function list(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.review-list'));
    }
    public function duyet(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.review-duyet'));
    }
    public function status(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.review-status'));
    }

    public function delete(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.review-delete'));
    }

    public function listComment(Admin $user)
    {
       // dd($user->CheckPermissionAccess(config('permissions.access.comment-post-list')));
        return $user->CheckPermissionAccess(config('permissions.access.comment-review-list'));
    }
    public function deleteComment(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.comment-review-delete'));
    }
    public function activeComment(Admin $user)
    {
        return $user->CheckPermissionAccess(config('permissions.access.comment-review-active'));
    }



    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function viewAny(Admin $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Slider  $slider
     * @return mixed
     */
    public function view(Admin $user, Slider $slider)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function create(Admin $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Slider  $slider
     * @return mixed
     */
    public function update(Admin $user, Slider $slider)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Slider  $slider
     * @return mixed
     */
    // public function delete(Admin $user, Slider $slider)
    // {

    // }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Slider  $slider
     * @return mixed
     */
    public function restore(Admin $user, Slider $slider)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Models\Slider  $slider
     * @return mixed
     */
    public function forceDelete(Admin $user, Slider $slider)
    {
        //
    }
}
