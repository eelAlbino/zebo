<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\UserSaveService;
use App\Services\UserSigService;
use App\Interfaces\Swagger;
use App\Repositories\UserRepository;

class UserAuthController extends Controller implements Swagger\Controllers\UserAuthController
{

    /**
     * Обработка запроса GET /user_auth.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userAuth(Request $request)
    {
        $response = [];
        $resCode = 400;

        $validator = Validator::make($request->all(), [
            'sig' => 'required|string',
            'access_token' => 'required|string',
            'id' => 'integer',
            'first_name' => 'string',
            'last_name' => 'string',
            'city' => 'string',
            'country' => 'string'
        ]);
        do {
            if ($validator->fails()) {
                $errors = [];
                foreach ($validator->messages()->toArray() as $errKey => $messGroup) {
                    $errors[]= $errKey .': '. implode(';', $messGroup);
                }
                $response = [
                    'error' => 'Не пройдена валидация: '.implode(';', $errors),
                    'error_key' => 'not_valid'
                    // $validator->errors()
                ];
                break;
            }

            $validatedData = $validator->validated();
            $sig = $validatedData['sig'];
            unset($validatedData['sig']);
            
            if (!$this->checkSigEqual($sig, $validatedData)) {
                $response = [
                    'error' => 'Не пройдеа проверка соответствия "sig"',
                    'error_key' => 'sig_not_valid'
                ];
                break;
            }

            $accessToken = $validatedData['access_token'];
            unset($validatedData['access_token']);

            if (isset($validatedData['first_name'])) {
                $validatedData['name'] = $validatedData['first_name'];
                unset($validatedData['first_name']);
            }
            $service = (new UserSaveService);
            $user = $service->createOrUpdateUser($validatedData);

            if (!$user) {
                $error = $service->error();
                return response()->json([
                    'error' => $error ? $error['message'] : 'Ошибка при сохранении пользователя',
                    'error_key' => $error ? $error['code'] : 'not_saved'
                ], 400);
            }
            (new UserRepository)->setAccessToken($user, $accessToken);
            // Формирование успешного ответа
            $response = [
                'access_token' => $accessToken,
                'user_info' => [
                    'id' => $user->id,
                    'first_name' => $user->name,
                    'last_name' => $user->last_name,
                    'city' => $user->city,
                    'country' => $user->country
                ],
                'error' => '',
                'error_key' => ''
            ];
            $resCode = 200;
        } while (false);

        return response()->json($response, $resCode);
    }

    /**
     * Производится проверка соответствия sig из $data
     * @param string $sig
     * @param array $data
     * @return bool
     */
    private function checkSigEqual(string $sig, array $data): bool
    {
        return (new UserSigService)->createFromArray($data) === $sig;
    }
}
