<?php

namespace App\Policies;

use App\{Comment, User};
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function accept(User $user, Comment $comment) {
        //Pregunta si un usuario es propietario de un post
        return $user->owns($comment->post);
    }
}
