<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\UserSigService;
use App\Models\User;
use App\Models\UserSession;

class UserAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Тест API метода /user_auth для авторизации/регистрации пользователя.
     * Создание нового пользователя
     *
     * @return void
     */
    public function testUserAuthCreate()
    {
        $queryData = $this->userFactoryParams();
        $queryData['sig'] = (new UserSigService)->createFromArray($queryData);

        $response = $this->get('/user_auth?' . http_build_query($queryData));

        $response->assertStatus(200);

        $response->assertJson([
            'access_token' => $queryData['access_token'],
            'user_info' => [
                'id' => 1,
                'first_name' => $queryData['first_name'],
                'last_name' => $queryData['last_name'],
                'city' => $queryData['city'],
                'country' => $queryData['country']
            ],
            'error' => '',
            'error_key' => ''
        ]);

        // Проверка создания пользователя в базе данных
        $this->assertDatabaseHas('users', [
            'id' => 1,
            'name' => $queryData['first_name'],
            'last_name' => $queryData['last_name'],
            'city' => $queryData['city'],
            'country' => $queryData['country']
        ]);
        // Проверка создания сессии в базе данных
        $this->assertDatabaseHas('user_sessions', [
            'user_id' => 1,
            'access_token' => $queryData['access_token']
        ]);
    }

    /**
     * Тест API метода /user_auth для изменения данных по пользователю.
     *
     * @return void
     */
    public function testUserAuthUpdate()
    {
        $user = User::factory()->create();
        $queryData = $this->userFactoryParams();
        $queryData['id'] = $user->id;
        $queryData['sig'] = (new UserSigService)->createFromArray($queryData);
        $this->withoutMiddleware(\App\Http\Middleware\RefreshDatabase::class);
        $response = $this->get('/user_auth?' . http_build_query($queryData));

        //$response->assertStatus(200);
        $response->assertJson([
            'access_token' => $queryData['access_token'],
            'user_info' => [
                'id' => $user->id,
                'first_name' => $queryData['first_name'],
                'last_name' => $queryData['last_name'],
                'city' => $queryData['city'],
                'country' => $queryData['country']
            ],
            'error' => '',
            'error_key' => ''
        ]);

        // Проверка изменения данных пользователя в базе данных
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $queryData['first_name'],
            'last_name' => $queryData['last_name'],
            'city' => $queryData['city'],
            'country' => $queryData['country']
        ]);
        // Проверка сессии в базе данных
        $this->assertDatabaseHas('user_sessions', [
            'user_id' => $user->id,
            'access_token' => $queryData['access_token']
        ]);
    }

    private function userFactoryParams(): array
    {
        $userFactory = User::factory()->make();
        $userSessionFactory = UserSession::factory()->make([
            'user_id' => $userFactory->id
        ]);
        return [
            'access_token' => $userSessionFactory->access_token,
            'first_name' => $userFactory->name,
            'last_name' => $userFactory->last_name,
            'city' => $userFactory->city,
            'country' => $userFactory->country
        ];
    }
}
