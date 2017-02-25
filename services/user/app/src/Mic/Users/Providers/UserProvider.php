<?php

namespace Mic\Users\Providers;

class UserProvider
{
    const PASSWORD_MIN_LEN = 5;

    /** @var array */
    private $data;

    /** @var string */
    private $dbPath;

    public function __construct($dbPath)
    {
        if (!file_exists($dbPath)) {
            throw new \Exception('Invalid path to db (' . $dbPath . ')', 500);
        }

        $this->dbPath = $dbPath;

        $file = file_get_contents($dbPath);
        $data = json_decode($file, true);

        $this->data = $data;
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     * @throws \Exception
     */
    public function validate($username, $password)
    {
        if (!array_key_exists($username, $this->data['users'])) {
            throw new \Exception('Username not found', 400);
        }

        if ($this->data['users'][$username] !== $this->hash($password)) {
            throw new \Exception('Invalid password', 400);
        }

        return true;
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     * @throws \Exception
     */
    public function register($username, $password)
    {
        if (array_key_exists($username, $this->data['users'])) {
            throw new \Exception('Username already in use', 400);
        }

        if (strlen($password) < self::PASSWORD_MIN_LEN) {
            throw new \Exception('Password must be at least ' . self::PASSWORD_MIN_LEN . ' characters long', 400);
        }

        $this->data['users'][$username] = $this->hash($password);

        return $this->save();
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $newPassword
     * @return bool
     * @throws \Exception
     */
    public function changePassword($username, $password, $newPassword)
    {
        if (!array_key_exists($username, $this->data['users'])) {
            throw new \Exception('Username not found', 400);
        }

        if ($this->data['users'][$username] !== $this->hash($password)) {
            throw new \Exception('Invalid current password', 400);
        }

        if (strlen($newPassword) < self::PASSWORD_MIN_LEN) {
            throw new \Exception('Password must be at least ' . self::PASSWORD_MIN_LEN . ' characters long', 400);
        }

        $this->data['users'][$username] = $this->hash($newPassword);

        return $this->save();
    }

    private function save()
    {
        $res = file_put_contents($this->dbPath, json_encode($this->data, JSON_PRETTY_PRINT));

        if ($res === false) {
            throw new \Exception('Could not save to database', 400);
        }

        return true;
    }

    private function hash($string)
    {
        return md5($string);
    }
}
