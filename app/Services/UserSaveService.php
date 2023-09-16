<?php
namespace App\Services;

use Exception;
use App\Repositories\UserRepository;
use App\Models\User;

class UserSaveService
{
    const DEFAULT_EMAIL = 'no.mail@mail.com';
    protected UserRepository $userRepository;

    /**
     * Код возникшей ошибки
     * @var string
     */
    private string $errorCode = '';
    /**
     * Описание возникшей ошибки
     * @var string
     */
    private string $errorMessage = '';

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
     * Создание или обновление пользователя на основе предоставленных данных.
     *
     * @param  array  $params
     * @return \App\Models\User|null
     * @throws \Exception
     */
    public function createOrUpdateUser(array $params): ?User
    {
        try {
            $user = null;
            if (isset($params['id'])) {
                $user = $this->userRepository->findOne($params['id']);
            }

            if ($user) {
                // Если пользователь найден, обновляем его данные
                $updateVals = [];
                foreach ([
                    'name',
                    'last_name',
                    'city',
                    'country'
                ] as $key) {
                    if (isset($params[ $key ])) {
                        $updateVals[ $key ] = $params[ $key ];
                    }
                }
                $this->userRepository->update($user, $updateVals);
            } else {
                // Если пользователь не найден, создаем нового
                // Как минимум, у пользователя должно быть имя
                if (!isset($params['name']) || empty($params['name'])) {
                    $this->errorCode = 'req_fields_for_create_empty';
                    $this->errorMessage = 'Пользователь не найден. Для создания нового пользователя не заполнены обязательные поля';
                    return null;
                }
                if (!isset($params['email'])) {
                    $params['email'] = self::DEFAULT_EMAIL;
                }
                $user = $this->userRepository->create(
                    User::factory()->make([
                        'email' => $params['email'],
                        'email_verified_at' => null,
                        'name' => $params['name'] ?? '',
                        'last_name' => $params['last_name'] ?? '',
                        'city' => $params['city'] ?? '',
                        'country' => $params['country'] ?? ''
                    ])
                    ->makeVisible(['password'])
                    ->toArray()
                );
            }

            return $user; // Возвращаем пользователя
        }
        catch (Exception $e) {
            // В случае ошибки, сохраняем код ошибки и описание в приватные параметры объекта
            $this->errorCode = 'not_save';
            $this->errorMessage = 'Произошла ошибка при создании/обновлении пользователя: ' . $e->getMessage();
            return null;
        }
    }

    /**
     * Возврат последней ошибки, если она была
     * @return array|NULL
     */
    public function error(): ?array
    {
        if ($this->errorCode != '') {
            return [
                'code' => $this->errorCode,
                'message' => $this->errorMessage
            ];
        }
    }
}
