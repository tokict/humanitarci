<?php

namespace App\Observers;



use App\Models\PasswordReset;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class UserObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  User  $user
     * @return void
     */
    public function created(User $user)
    {
        //Send reset link
        error_log('User created!');
        $reset = new PasswordReset(['email' => $user->email, 'token' => Str::random(60)]);
        $reset->save();
        Mail::queue('emails.pay_registration', ['user' => $user, 'reset' => $reset->toArray()], function ($m) use ($user, $reset) {

            $m->to($user->email, $user->first_name)->subject('Postavi svoju Humanitarci.hr lozinku');
        });


    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        //
    }



}