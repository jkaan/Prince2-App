<?php
/**
 * Created by PhpStorm.
 * User: joey
 * Date: 5/9/14
 * Time: 2:21 PM
 */

namespace Security;

use Doctrine\DBAL\Connection;
use Silex\Application;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Entities\User;

class UserProvider implements UserProviderInterface {

    private $conn;
    private $app;

    public function __construct(Connection $conn, Application $app)
    {
        $this->conn = $conn;
        $this->app  = $app;
    }

    public function loadUserByUsername($username)
    {
        $stmt = $this->conn->executeQuery('SELECT * FROM users WHERE username = ?', array(strtolower($username)));

        if (!$user = $stmt->fetch()) {
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        return new User($user['username'], $user['password'], $user['salt']);
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'Entities\User';
    }

} 