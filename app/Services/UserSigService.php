<?php
namespace App\Services;

use Exception;
use App\Repositories\UserRepository;
use App\Models\User;

class UserSigService
{
    protected UserRepository $userRepository;

    public function __construct(?UserRepository $userRepository = null)
    {
        if ($userRepository) {
            $this->userRepository = $userRepository;
        }
        else {
            $this->userRepository = new UserRepository;
        }
    }

    /**
     * Получение sig из массива данных
     * @param array $data
     * @return string
     */
    public function createFromArray(array $data): string
    {
        ksort($data);
        $str = [];
        foreach ($data as $key => $value) {
            $str []= $key . '=' . $value;
        }
        $str = implode('', $str);
        $str .= env('USER_SIG_SECRET_KEY');
        return mb_strtolower( md5($str), 'UTF-8');
    }
}
