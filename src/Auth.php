<?php

namespace App;

use App\Helpers\Companies;
use App\Security\ForbiddenExecption;
use PDO;
use App\Helpers\User;

class Auth {

    private $pdo;

    private $loginPath;

    public function __construct(PDO $pdo, string $loginPath)
    {
        $this->pdo = $pdo;
        $this->loginPath = $loginPath;
    }

    public static function check()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['auth'])) {
            throw new ForbiddenExecption();
        }
    }

    public function user(): ?User
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id = $_SESSION['auth'] ?? null;
        if ($id === null){
            return null;
        }
        $query = $this->pdo->prepare('SELECT * FROM people WHERE id = ?');
        $query->execute([$id]);
        $user = $query->fetchObject(User::class);
        return $user ?: null;
    }

    public function companie(): ?Companies
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id = $_SESSION['auth'] ?? null;
        if ($id === null){
            return null;
        }
        $query = $this->pdo->prepare('SELECT * FROM companies WHERE id = ?');
        $query->execute([$id]);
        $user = $query->fetchObject(Companies::class);
        return $user ?: null;
    }

    public function requireRole(string ...$roles): void
    {
        $user = $this->user();
        if ($user === null || !in_array($user->role, $roles)) 
        {
            header("Location: login.php?forbid=1");
            exit();
        }
    }

    public function loginUser(string $email, string $password): ?User
    {
        $query = $this->pdo->prepare('SELECT * FROM people WHERE email = :email');
        $query->execute(['email' => $email]);
        $user = $query->fetchObject(User::class);
        if ($user === false) {
            return null;
        }
        if (password_verify($password, $user->password)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['auth'] = $user->id;
            return $user;
        } 
        return null;
    }

    public function loginCompanie(string $email, string $password): ?User
    {
        $query = $this->pdo->prepare('SELECT * FROM companies WHERE email = :email');
        $query->execute(['email' => $email]);
        $companie = $query->fetchObject(User::class);
        if ($companie === false) {
            return null;
        }
        if (password_verify($password, $companie->password)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['auth'] = $companie->id;
            return $companie;
        } 
        return null;
    }
}
?> 