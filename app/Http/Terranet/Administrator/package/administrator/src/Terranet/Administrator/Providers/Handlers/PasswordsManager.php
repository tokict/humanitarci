<?php

namespace Terranet\Administrator\Providers\Handlers;

use Illuminate\Contracts\Config\Repository;
use Terranet\Administrator\Traits\SessionGuardHelper;

class PasswordsManager
{
    use SessionGuardHelper;

    /**
     * @var Repository
     */
    private $config;

    /**
     * PasswordsManager constructor.
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function handle()
    {
        if ($this->config->get('manage_passwords', true)) {
            if ($model = $this->fetchModel($this->config)) {
                $model::saving(function ($user) {
                    if (!empty($user->password) && $user->isDirty('password')) {
                        $user->password = bcrypt($user->password);
                    }
                });
            }
        }
    }
}