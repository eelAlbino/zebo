<?php
namespace App\Interfaces\Swagger\Controllers;

/**
 * @OA\Get(
 *     path="/user_auth",
 *     summary="Аутентификация/регистрация пользователя",
 *     description="Позволяет аутентифицировать пользователя по sig и обновлять информацию о пользователе.",
 *     tags={"User Auth"},
 *     @OA\Parameter(
 *         name="access_token",
 *         in="query",
 *         description="Access Token пользователя.",
 *         required=true,
 *         @OA\Schema(type="string"),
 *         example="07b38cd0e778340eb40b25e005476ce8"
 *     ),
 *     @OA\Parameter(
 *         name="sig",
 *         in="query",
 *         description="sig для проверки доступности.",
 *         required=true,
 *         @OA\Schema(type="string"),
 *         example="5427b31460cd807aab7e184364960958"
 *     ),
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         description="ID пользователя.",
 *         required=false,
 *         @OA\Schema(type="integer"),
 *         example=1
 *     ),
 *     @OA\Parameter(
 *         name="first_name",
 *         in="query",
 *         description="Имя пользователя.",
 *         required=false,
 *         @OA\Schema(type="string"),
 *         example="Иван"
 *     ),
 *     @OA\Parameter(
 *         name="last_name",
 *         in="query",
 *         description="Фамилия пользователя.",
 *         required=false,
 *         @OA\Schema(type="string"),
 *         example="Иванов"
 *     ),
 *     @OA\Parameter(
 *         name="city",
 *         in="query",
 *         description="Город пользователя.",
 *         required=false,
 *         @OA\Schema(type="string"),
 *         example="Москва"
 *     ),
 *     @OA\Parameter(
 *         name="country",
 *         in="query",
 *         description="Страна пользователя.",
 *         required=false,
 *         @OA\Schema(type="string"),
 *         example="Россия"
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Успешная аутентификация и обновление информации о пользователе.",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                  property="access_token",
 *                  ref="#/components/schemas/AccessToken"
 *             ),
 *             @OA\Property(
 *                  property="user_info",
 *                  ref="#/components/schemas/UserAuthInfo"
 *             ),
 *             @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example=""
 *             ),
 *             @OA\Property(
 *                  property="error_key",
 *                  type="string",
 *                  example=""
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Ошибка входных данных.",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                  property="error",
 *                  type="string",
 *                  example="Ошибка авторизации в приложении"
 *             ),
 *             @OA\Property(
 *                  property="error_key",
 *                  type="string",
 *                  example="signature_error"
 *             )
 *         )
 *     ),
 * )
 */

interface UserAuthController
{
}