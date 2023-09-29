<?php
namespace Classes;

require_once 'classes/Log.php'; // class log
use Classes\Log;

final class UserForm
{
    public function __construct(
        private array $users = [],
    ) {
    }

    public function addUser(array $user): void
    {
        $this->users[] = $user;
    }

    public function getUserList(): array
    {
        return $this->users;
    }

    public function checkUserMail(string $mail): bool
    {
        $users = $this->getUserList();

        foreach($users as $user) {
            $userMail[] = $user['mail'];
        }

        if(in_array($mail, $userMail)) {
            Log::addEntryToLog("Користувач з e-mail: $mail вже існує");

            return true;
        }

        Log::addEntryToLog("Користувач з e-mail: $mail успішно пройшов перевірку!");

        return false;
    }
}
