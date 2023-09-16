<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Interfaces\Swagger;
/**
 * Модель сессии пользователя.
 *
 * @property int $id
 * @property int $user_id
 * @property string $access_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read \App\Models\User $user
 */
class UserSession extends Model implements Swagger\Models\UserSession
{
    use HasFactory;
    /**
     * Таблица модели
     * @var string
     */
    protected $table = 'user_sessions';

    protected $fillable = [
        'user_id',
        'access_token'
    ];

    /**
     * Получить пользователя, которому принадлежит этот сеанс.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
