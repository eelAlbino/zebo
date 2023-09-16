<?php
namespace App\Interfaces\Swagger\Models;

/**
 * @OA\Schema(
 *     schema="UserAuthInfo",
 *     title="Данные пользователя",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="first_name",
 *         type="string",
 *         description="Имя",
 *         example="Иван"
 *     ),
 *     @OA\Property(
 *         property="last_name",
 *         type="string",
 *         description="Фамилия",
 *         example="Иванов"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         description="Город",
 *         example="Москва"
 *     ),
 *     @OA\Property(
 *         property="country",
 *         type="string",
 *         description="Страна",
 *         example="Россия"
 *     )
 * )
 */
interface User
{
}