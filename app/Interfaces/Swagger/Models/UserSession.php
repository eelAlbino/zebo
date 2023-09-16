<?php
namespace App\Interfaces\Swagger\Models;

/**
 * @OA\Schema(
 * 	   schema="AccessToken",
 * 	   type="string",
 * 	   title="Токен сессии",
 *     description="",
 *     example="07b38cd0e778340eb40b25e005476ce8"
 * ),
 * @OA\Schema(
 *     schema="UserSession",
 *     title="Сессия пользователя",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="ID пользователя",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="access_token",
 *         ref="#/components/schemas/AccessToken"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="datetime",
 *         description="Время создания",
 *         example="2023-09-16 12:00:00"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="datetime",
 *         description="Время последнего обновления",
 *         example="2023-09-16 12:30:00"
 *     )
 * )
 */
interface UserSession
{
}