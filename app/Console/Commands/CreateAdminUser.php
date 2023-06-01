<?php

namespace App\Console\Commands;

use App\Models\Admin\User;
use App\Models\Admin\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создание Администратора';
    private \Illuminate\Support\MessageBag $errors;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->validateConsole(
            function () {
                return $this->ask('Введите E-mail');
            },
            ['email' => 'email|min:4|required|unique:admin__users']
        );
        $name = $this->validateConsole(
            function () {
                return $this->ask('Введите Имя');
            },
            ['name' => 'min:4|required']
        );
        $password = $this->validateConsole(
            function () {
                return $this->ask('Введите Пароль. Минимальная длина - 8 символов');
            },
            ['password' => 'required|min:8']
        );

        $roles = Role::select('id', 'name')->get();
        $role = $this->choice(
            'Выберите роль',
            $roles->pluck('name')->toArray(),
        );
        $role_id = $roles->where('name', $role)->first()->id;

        User::insert([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'admin__role_id' => $role_id,
        ]);

        return 0;
    }

    public function validateConsole($method, $rules)
    {
        $value = $method();
        $validate = $this->validateInput($rules, $value);

        if ($validate !== true) {
            $messages = collect($this->errors)->flatten()->all();
            foreach ($messages as $failure) {
                $this->warn($failure);
            }
            $value = $this->validateConsole($method, $rules);
        }

        return $value;
    }

    public function validateInput($rules, $value): bool
    {
        $validator = Validator::make([key($rules) => $value], $rules);
        if ($validator->fails()) {
            $this->errors = $validator->errors();
            return false;
        } else {
            return true;
        }
    }
}
