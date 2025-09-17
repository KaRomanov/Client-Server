<?php

class MySQLDbRequests implements DbRequests
{
    public function getAllUsers(): array
    {
        $connection = (new Db())->getConnection();

        $selectStatement = $connection->prepare("SELECT * FROM users");
        $selectStatement->execute([]);

        $userData = $selectStatement->fetchAll();
        $users = [];
        foreach ($userData as $user) {
            $users[] = User::fromArray($user);
        }
        return $users;
    }

    public function getUserById(int $id): ?User
    {
        $connection = (new Db())->getConnection();

        $selectStatement = $connection->prepare("SELECT * FROM users WHERE id = :id");
        $selectStatement->execute(['id' => $id]);

        $userData = $selectStatement->fetch();

        return $userData ? User::fromArray($userData) : null;
    }

    public function getUserByUsername(string $username): ?User
    {
        $connection = (new Db())->getConnection();

        $selectStatement = $connection->prepare("SELECT * FROM users WHERE username = :username");
        $selectStatement->execute(['username' => $username]);

        $userData = $selectStatement->fetch();

        return $userData ? User::fromArray($userData) : null;
    }

    public function insertUser(string $email, string $username, string $password): ?User
    {
        $connection = (new Db())->getConnection();

        $insertStatement = $connection->prepare("INSERT INTO users (`email`, `username`, `password`) VALUES ( :email,:username, :pasword)");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertResult = $insertStatement->execute([
            'email' => $email,
            'username' => $username,
            'pasword' => $hashedPassword
        ]);

        if ($insertResult) {
            $id = $connection->lastInsertId();

            return new User($id, $username);
        }

        $errorCode = $insertStatement->errorCode();

        if ($errorCode === "23000") {
            // Duplicate entry error
            // This means the username already exists

            return null;
        }

        throw new Exception("Грешка при създаване на потребител. Опитайте пак по-късно.");

    }

    public function validateUser(string $email, string $username, string $password): bool
    {

        $connection = (new Db())->getConnection();

        $selectStatement = $connection->prepare("SELECT * FROM users WHERE username = :username and email = :email");

        $result = $selectStatement->execute(["username" => $username, "email" => $email]);
        $user = $selectStatement->fetch(PDO::FETCH_ASSOC);

        if ($result && $selectStatement->rowCount() === 1 && password_verify($password, $user['password'])) {
            return true;
        }

        return false;
    }

    public function updateUserEmail(string $username, string $newEmail): bool{
        $connection = (new Db())->getConnection();

        $selectStatement = $connection->prepare('UPDATE users SET email = :email WHERE username = :username');
        
        $result = $selectStatement->execute(["email" => $newEmail, "username" => $username]);
        if($result){
            return true;
        }
        return false;
    }

    public function updateUserPassword(string $username, string $newPassword): bool{
        $connection = (new Db())->getConnection();

        
        $selectStatement = $connection->prepare("UPDATE users SET password = :password WHERE username = :username");
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $result = $selectStatement->execute(["password" => $hashedPassword,"username"=> $username]);

        if($result){
            return true;
        }
        return false;
    }

}