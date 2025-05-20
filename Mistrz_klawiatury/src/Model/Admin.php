<?php

namespace App\Model;

use App\Service\Config;

class Admin
{

    private ?int $adminId = null;

    private ?string $adminName = null;



    private ?string $adminPassword = null;

    public function getAdminId(): ?int
    {
        return $this->adminId;
    }

    public function setAdminId(?int $adminId): void
    {
        $this->adminId = $adminId;
    }

    public function getAdminName(): ?string
    {
        return $this->adminName;
    }

    public function setAdminName(?string $adminName): void
    {
        $this->adminName = $adminName;
    }
    public function getAdminPassword(): ?string
    {
        return $this->adminPassword;
    }

    public function setAdminPassword(?string $adminPassword): void
    {
        $this->adminPassword = $adminPassword;
    }

    public function fill($array): Admin
    {
        if (isset($array['admin_id'])) {
            $this->setAdminId($array['admin_id']);
        }
        if (isset($array['admin_password'])) {
            $this->setAdminPassword($array['admin_password']);
        }
        if (isset($array['admin_name']))
        {
            $this->setAdminName($array['admin_name']);
        }
        return $this;
    }

    public static function fromArray($array): Admin
    {
        $admin = new Admin();
        $admin->fill($array);
        return $admin;
    }


    public static function findById(int $id): ?Admin
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM admin WHERE admin_id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $adminArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (!$adminArray) {
            return null;
        }
        return Admin::fromArray($adminArray);
    }


    public static function find($name,$password): ?Admin
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM admin WHERE admin_password = :password and admin_name = :name';
        $statement = $pdo->prepare($sql);
        $statement->execute(['name' => $name,'password' => $password]);

        $adminArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (!$adminArray) {
            return null;
        }
        return Admin::fromArray($adminArray);
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if ($this->getAdminId()) {
            $sql = "UPDATE admin SET admin_password = :admin_password WHERE admin_id = :admin_id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':admin_id' => $this->getAdminId(),
                ':admin_password' => $this->getAdminPassword(),
            ]);
        } else {
            $sql = "INSERT INTO admin (admin_name,admin_password) VALUES (:admin_name,:admin_password)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':admin_password' => $this->getAdminPassword(),
                ':admin_name' => $this->getAdminName(),
            ]);
            $this->setAdminId((int)$pdo->lastInsertId());
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM admin WHERE admin_id = :admin_id";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':admin_id' => $this->getAdminId(),
        ]);

        $this->setAdminId(null);
        $this->setAdminPassword(null);
    }

}