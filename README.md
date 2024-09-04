# Проект Laravel

## Описание проекта

Этот проект демонстрирует использование принципов SOLID, работу с консольными командами, асинхронные процессы и события в Laravel. В проекте реализованы следующие функции:

- Импорт пользователей из CSV файла.
- Отправка email уведомлений пользователям с определенной ролью.
- Обработка загрузки и хранения изображений.
- Обработка платежей через различные платежные системы.
- Система событий для уведомления пользователей после регистрации.
- Написанно тесты для проверки корректности работы команд и платёжной системы.

## Установка

1. Клонируйте репозиторий:

    ```bash
    git clone https://github.com/your-repository.git
    ```

2. Перейдите в директорию проекта:

    ```bash
    cd your-project-directory
    ```

3. Установите зависимости:

    ```bash
    composer install
    ```

4. Скопируйте файл `.env.example` в `.env`:

    ```bash
    cp .env.example .env
    ```

5. Настройте ваше окружение в `.env`, добавив параметры для базы данных и почты:

## Используемые технологии

### Очереди

В проекте используется система очередей Laravel для асинхронной обработки задач, таких как отправка email уведомлений.

**Конфигурация очередей:**

Для локальной разработки и тестирования используется `database` драйвер очередей вместо `redis`. Это позволяет хранить задачи в таблице `jobs` в базе данных, что упрощает настройку и не требует дополнительного сервера Redis.

**Настройки:**

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password

    MAIL_MAILER=smtp
    MAIL_HOST=sandbox.smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=46a697787b1cfa
    MAIL_PASSWORD=dd58f59dbe8ed2


    QUEUE_CONNECTION=database

    ```

6. Выполните миграции:

    ```bash
    php artisan migrate
    ```

7. Сиды данные (если необходимо):

    ```bash
    php artisan db:seed
    ```

## Запуск сервера и обработки очередей

- Для запуска локального сервера используйте:

    ```bash
    php artisan serve
    ```

- Для обработки очередей используйте:

    ```bash
    php artisan queue:work
    ```

## Роуты API

## Экспортированные запросы Postman

Вы можете загрузить коллекцию запросов Postman из [postman_collection.json](app/postman_collection.json).

### Обработка платежей

- **URL:** `/v1/process/payment`
- **Метод:** POST
- **Контроллер:** `PaymentController@processPayment`

### Загрузка изображений

- **URL:** `/v1/user/upload`
- **Метод:** POST
- **Контроллер:** `UserController`

### Регистрация пользователя

- **URL:** `/v1/register`
- **Метод:** POST
- **Контроллер:** `AuthController`

## Консольные команды

### Импорт пользователей из CSV

**Команда:** `php artisan users:import`

Эта команда импортирует пользователей из CSV файла. Файл должен содержать следующие колонки: `name`, `email`, `password`.

### Отправка email пользователям с определенной ролью

**Команда:** `php artisan users:notify`

Эта команда отправляет email всем пользователям с указанной ролью (по умолчанию "admin").

## Асинхронные процессы

Проект реализует систему обработки загрузки и хранения изображений. При загрузке изображения оно обрабатывается (например, изменяется размер) и сохраняется в облаке.

## События и слушатели

Проект включает систему событий, которая отправляет уведомление пользователю по электронной почте после регистрации.

## Принципы SOLID

Проект демонстрирует применение принципов SOLID на примере класса для обработки платежей. Система поддерживает различные платежные провайдеры (например, PayPal и Stripe) и позволяет легко менять логику обработки платежей без изменения основного кода.

## Тестирование

### Тестирование консольной команды `users:notify`

**Команда:** `php artisan test`

```php
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use App\Models\User;
use App\Jobs\SendUserNotificationEmail;

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
Тестирование сервиса обработки платежей
php

Копировать код
use Tests\TestCase;
use App\Services\PaymentService;
use App\PaymentProcessors\PayPalProcessor;

class PaymentServiceTest extends TestCase
{
    /** @test */
    public function testPaymentProcessingWithPayPal()
    {
        $paymentService = new PaymentService(new PayPalProcessor());
        $this->assertTrue($paymentService->process(100.00));
    }
}
Лицензия
Этот проект лицензирован под MIT License.
