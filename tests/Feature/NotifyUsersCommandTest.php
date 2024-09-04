<?php

namespace Tests\Feature;

use App\Jobs\SendUserNotificationEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class NotifyUsersCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_queue_emails_for_users_with_specific_role()
    {
        // Создаем пользователя с ролью "admin"
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        // Используем mock для очереди
        Queue::fake();

        // Запуск команды и проверка, что задача поставлена в очередь
        $this->artisan('users:notify')
            ->assertExitCode(0);

        // Проверяем, что задачи были добавлены в очередь
        Queue::assertPushed(SendUserNotificationEmail::class);

        // Опционально: можно проверить количество задач в очереди
        Queue::assertPushed(SendUserNotificationEmail::class, function ($job) use ($admin) {
            return $job->getUser()->id === $admin->id;
        });
    }
}
