<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;


class CommentPolicy
    {
        use HandlesAuthorization;

        /**
         * Tentukan apakah pengguna dapat memperbarui (update) model.
         *
         * @param  \App\Models\User  $user
         * @param  \App\Models\Comment  $comment
         * @return \Illuminate\Auth\Access\Response|bool
         */
        public function update(User $user, Comment $comment)
        {
            // Izinkan update HANYA jika id pengguna sama dengan user_id di komentar.
            return $user->id === $comment->user_id;
        }

        /**
         * Tentukan apakah pengguna dapat menghapus (delete) model.
         *
         * @param  \App\Models\User  $user
         * @param  \App\Models\Comment  $comment
         * @return \Illuminate\Auth\Access\Response|bool
         */
        public function delete(User $user, Comment $comment)
        {
            // Izinkan delete HANYA jika id pengguna sama dengan user_id di komentar.
            return $user->id === $comment->user_id;
        }
    }

