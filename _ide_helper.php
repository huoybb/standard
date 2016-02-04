<?php
namespace {

    use Phalcon\Http\Response\Cookies;

    exit("This file should not be included, only analyzed by your IDE");
    class RedisFacade extends \Facade{
        /**
         * @return bool
         */
        public static function isTagsExist(){}

        /**
         * @param $data
         * @return bool
         */
        public static function setTags($data){}

        /**
         * @return \Tags[]
         */
        public static function getTags(){}

        /**
         * @param $key
         * @return bool
         */
        public static function exist($key){}
        /**
         * @param $key
         * @param $value
         * @return bool
         */
        public static function set($key, $value){}
        /**
         * @param $key
         * @return bool|string
         */
        public static function get($key){}

        /**
         * @param $key
         */
        public static function delete($key){}
        /**
         * @param $key
         * @param int $value
         * @return int
         */
        public static function increment($key, $value = 1){}
        /**
         * @param $key
         * @param int $value
         * @return int
         */
        public static function decrement($key, $value = 1){}
        /**
         * @param $pattern
         * @return array
         */
        public static function keys($pattern){}
    }

    class EventFacade extends \Facade{
        /**
         * Fires an event in the events manager causing the active listeners to be notified about it
         * <code>
         * $eventsManager->fire('db', $connection);
         * </code>
         *
         * @param string $eventType
         * @param object $source
         * @param mixed $data
         * @param boolean $cancelable
         * @return mixed
         */
        public static function fire($eventType, $source, $data = null, $cancelable = true) {}
    }

    class SessionFacade extends \Facade{
        /**
         * Gets a session variable from an application context
         * <code>
         * $session->get('auth', 'yes');
         * </code>
         *
         * @param string $index
         * @param mixed $defaultValue
         * @param bool $remove
         * @return mixed
         */
        public static function get($index, $defaultValue = null, $remove = false) {}

        /**
         * Sets a session variable in an application context
         * <code>
         * $session->set('auth', 'yes');
         * </code>
         *
         * @param string $index
         * @param mixed $value
         */
        public static function set($index, $value) {}

        /**
         * Check whether a session variable is set in an application context
         * <code>
         * var_dump($session->has('auth'));
         * </code>
         *
         * @param string $index
         * @return bool
         */
        public static function has($index) {}

        /**
         * Removes a session variable from an application context
         * <code>
         * $session->remove('auth');
         * </code>
         *
         * @param string $index
         */
        public static function remove($index) {}

        /**
         * Destroys the active session
         * <code>
         * var_dump($session->destroy());
         * var_dump($session->destroy(true));
         * </code>
         *
         * @param bool $removeData
         * @return bool
         */
        public static function destroy($removeData = false) {}
    }

    class CookieFacade extends \Facade{
        /**
         * Sets a cookie to be sent at the end of the request
         * This method overrides any cookie set before with the same name
         *
         * @param string $name
         * @param mixed $value
         * @param int $expire
         * @param string $path
         * @param bool $secure
         * @param string $domain
         * @param bool $httpOnly
         * @return Cookies
         */
        public static function set($name, $value = null, $expire = 0, $path = "/", $secure = null, $domain = null, $httpOnly = null) {}

        /**
         * Gets a cookie from the bag
         *
         * @param string $name
         * @return \Phalcon\Http\CookieInterface
         */
        public static function get($name) {}

        /**
         * Check if a cookie is defined in the bag or exists in the _COOKIE superglobal
         *
         * @param string $name
         * @return bool
         */
        public static function has($name) {}

        /**
         * Deletes a cookie by its name
         * This method does not removes cookies from the _COOKIE superglobal
         *
         * @param string $name
         * @return bool
         */
        public static function delete($name) {}

        /**
         * Sends the cookies to the client
         * Cookies aren't sent if headers are sent in the current request
         *
         * @return bool
         */
        public static function send() {}

        /**
         * Reset set cookies
         *
         * @return Cookies
         */
        public static function reset() {}


    }

    class FlashFacade extends \Facade{
        /**
         * Shows a HTML error message
         * <code>
         * $flash->error('This is an error');
         * </code>
         *
         * @param mixed $message
         * @return string
         */
        public static function error($message) {}

        /**
         * Shows a HTML notice/information message
         * <code>
         * $flash->notice('This is an information');
         * </code>
         *
         * @param mixed $message
         * @return string
         */
        public static function notice($message) {}

        /**
         * Shows a HTML success message
         * <code>
         * $flash->success('The process was finished successfully');
         * </code>
         *
         * @param string $message
         * @return string
         */
        public static function success($message) {}

        /**
         * Shows a HTML warning message
         * <code>
         * $flash->warning('Hey, this is important');
         * </code>
         *
         * @param mixed $message
         * @return string
         */
        public static function warning($message) {}

    }

    class AuthFacade extends \Facade {

        public static function save(array $params = []){}
    }

    class SecurityFacade extends \Facade{
        /**
         * Creates a password hash using bcrypt with a pseudo random salt
         *
         * @param string $password
         * @param int $workFactor
         * @return string
         */
        public static function hash($password, $workFactor = 0) {}

        /**
         * Checks a plain text password and its hash version to check if the password matches
         *
         * @param string $password
         * @param string $passwordHash
         * @param int $maxPassLength
         * @return bool
         */
        public static function checkHash($password, $passwordHash, $maxPassLength = 0) {}
        /**
         * Checks if a password hash is a valid bcrypt's hash
         *
         * @param string $passwordHash
         * @return bool
         */
        public static function isLegacyHash($passwordHash) {}

        /**
         * Generates a pseudo random token key to be used as input's name in a CSRF check
         *
         * @param int $numberBytes
         * @return string
         */
        public static function getTokenKey($numberBytes = null) {}

        /**
         * Generates a pseudo random token value to be used as input's value in a CSRF check
         *
         * @param int $numberBytes
         * @return string
         */
        public static function getToken($numberBytes = null) {}

        /**
         * Check if the CSRF token sent in the request is the same that the current in session
         *
         * @param mixed $tokenKey
         * @param mixed $tokenValue
         * @param bool $destroyIfValid
         * @return bool
         */
        public static function checkToken($tokenKey = null, $tokenValue = null, $destroyIfValid = true) {}

        /**
         * Returns the value of the CSRF token in session
         *
         * @return string
         */
        public static function getSessionToken() {}

        /**
         * Removes the value of the CSRF token and key from session
         */
        public static function destroyToken() {}
    }

    class CryptFacade extends \Facade{
        /**
         * Encrypts a text
         * <code>
         * $encrypted = $crypt->encrypt("Ultra-secret text", "encrypt password");
         * </code>
         *
         * @param string $text
         * @param string $key
         * @return string
         */
        public static function encrypt($text, $key = null) {}

        /**
         * Decrypts an encrypted text
         * <code>
         * echo $crypt->decrypt($encrypted, "decrypt password");
         * </code>
         *
         * @param string $text
         * @param mixed $key
         * @return string
         */
        public static function decrypt($text, $key = null) {}

        /**
         * Encrypts a text returning the result as a base64 string
         *
         * @param string $text
         * @param mixed $key
         * @param bool $safe
         * @return string
         */
        public static function encryptBase64($text, $key = null, $safe = false) {}

        /**
         * Decrypt a text that is coded as a base64 string
         *
         * @param string $text
         * @param mixed $key
         * @param bool $safe
         * @return string
         */
        public static function decryptBase64($text, $key = null, $safe = false) {}

        /**
         * Returns a list of available cyphers
         *
         * @return array
         */
        public static function getAvailableCiphers() {}

        /**
         * Returns a list of available modes
         *
         * @return array
         */
        public static function getAvailableModes() {}
    }

    class myToolsFacade extends \Facade{
        /**
         * @param $search
         * @return boolean
         */
        public static function isStandardNumber($search){}
    }

}