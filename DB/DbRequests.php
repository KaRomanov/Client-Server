<?php

interface DbRequests
{
    public function getAllUsers(): array;

    public function getUserById(int $id): ?User;

    public function getUserByUsername(string $username): ?User;

    public function insertUser(string $email, string $username, string $password): ?User;

    public function validateUser(string $email, string $username, string $password): bool;

    public function updateUserPassword(string $username, string $newPassword) : bool;

    public function updateUserEmail(string $username, string $newEmail) : bool;
}