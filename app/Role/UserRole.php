<?php

namespace App\Role;

/***
 * Class UserRole
 * @package App\Role
 */
class UserRole {

    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_MANAGEMENT = 'ROLE_MANAGEMENT';
    const ROLE_FINANCE = 'ROLE_FINANCE';
    const ROLE_ACCOUNT_MANAGER = 'ROLE_ACCOUNT_MANAGER';
    const ROLE_SUPPORT = 'ROLE_SUPPORT';
    const ROLE_USER = 'ROLE_USER';

    /**
     * @var array
     */
    protected static $roleHierarchy = [
        self::ROLE_ADMIN => ['*'],
        self::ROLE_MANAGEMENT => [
            self::ROLE_ACCOUNT_MANAGER,
            self::ROLE_FINANCE,
            self::ROLE_SUPPORT,
        ],
        self::ROLE_ACCOUNT_MANAGER => [
            self::ROLE_SUPPORT
        ],
        self::ROLE_FINANCE => [
            self::ROLE_SUPPORT
        ],
        self::ROLE_SUPPORT => [],
        self::ROLE_USER => [],
    ];

    /**
     * @param string $role
     * @return array
     */
    public static function getAllowedRoles(string $role)
    {
        if (isset(self::$roleHierarchy[$role])) {
            return self::$roleHierarchy[$role];
        }

        return [];
    }

    /***
     * @return array
     */
    public static function getRoleList()
    {
        return [
            static::ROLE_ADMIN =>'Administradores',
            static::ROLE_MANAGEMENT => 'Gerentes',
            static::ROLE_ACCOUNT_MANAGER => 'Gerestes de Contas',
            static::ROLE_FINANCE => 'Financeiro',
            static::ROLE_SUPPORT => 'Supporte',
            static::ROLE_USER => 'Usuários'
        ];
    }

}
