<?php
namespace {

    use Phalcon\Http\Response\Cookies;
    use Phalcon\Mvc\Router\RouteInterface;
    use Phalcon\Mvc\RouterInterface;

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

    class RouterFacade extends \Facade{
        /**
         * Handles routing information received from the rewrite engine
         * <code>
         * //Read the info from the rewrite engine
         * $router->handle();
         * //Manually passing an URL
         * $router->handle('/posts/edit/1');
         * </code>
         *
         * @param string $uri
         */
        public static function handle($uri = null) {}

        /**
         * Adds a route to the router without any HTTP constraint
         * <code>
         * use Phalcon\Mvc\Router;
         * $router->add('/about', 'About::index');
         * $router->add('/about', 'About::index', ['GET', 'POST']);
         * $router->add('/about', 'About::index', ['GET', 'POST'], Router::POSITION_FIRST);
         * </code>
         *
         * @param string $pattern
         * @param mixed $paths
         * @param mixed $httpMethods
         * @param mixed $position
         * @return \Phalcon\Mvc\Router\RouteInterface
         */
        public static function add($pattern, $paths = null, $httpMethods = null, $position = Router::POSITION_LAST) {}

        /**
         * 主要是增加了一个中间件的功能，利用short syntax来增加中间件，这样的好处是路由、中间件在一起，便于管理
         * @param $pattern
         * @param null $path
         * @param array $middleware
         * @return \Phalcon\Mvc\Router\Route
         */
        public static function addx($pattern,$path=null,array $middleware=[]) {}

        /**
         * Adds a route to the router that only match if the HTTP method is GET
         *
         * @param string $pattern
         * @param mixed $paths
         * @param mixed $position
         * @return \Phalcon\Mvc\Router\RouteInterface
         */
        public static function addGet($pattern, $paths = null, $position = Router::POSITION_LAST) {}
        /**
         * Adds a route to the router that only match if the HTTP method is POST
         *
         * @param string $pattern
         * @param mixed $paths
         * @param mixed $position
         * @return \Phalcon\Mvc\Router\RouteInterface
         */
        public static function addPost($pattern, $paths = null, $position = Router::POSITION_LAST) {}

        /**
         * Adds a route to the router that only match if the HTTP method is PUT
         *
         * @param string $pattern
         * @param mixed $paths
         * @param mixed $position
         * @return \Phalcon\Mvc\Router\RouteInterface
         */
        public static function addPut($pattern, $paths = null, $position = Router::POSITION_LAST) {}

        /**
         * Adds a route to the router that only match if the HTTP method is PATCH
         *
         * @param string $pattern
         * @param mixed $paths
         * @param mixed $position
         * @return \Phalcon\Mvc\Router\RouteInterface
         */
        public static function addPatch($pattern, $paths = null, $position = Router::POSITION_LAST) {}

        /**
         * Adds a route to the router that only match if the HTTP method is DELETE
         *
         * @param string $pattern
         * @param mixed $paths
         * @param mixed $position
         * @return \Phalcon\Mvc\Router\RouteInterface
         */
        public static function addDelete($pattern, $paths = null, $position = Router::POSITION_LAST) {}

        /**
         * Add a route to the router that only match if the HTTP method is OPTIONS
         *
         * @param string $pattern
         * @param mixed $paths
         * @param mixed $position
         * @return \Phalcon\Mvc\Router\RouteInterface
         */
        public static function addOptions($pattern, $paths = null, $position = Router::POSITION_LAST) {}

        /**
         * Adds a route to the router that only match if the HTTP method is HEAD
         *
         * @param string $pattern
         * @param mixed $paths
         * @param mixed $position
         * @return \Phalcon\Mvc\Router\RouteInterface
         */
        public static function addHead($pattern, $paths = null, $position = Router::POSITION_LAST) {}
        /**
         * Set a group of paths to be returned when none of the defined routes are matched
         *
         * @param mixed $paths
         * @return RouterInterface
         */
        public static function notFound($paths) {}

        /**
         * Removes all the pre-defined routes
         */
        public static function clear() {}

        /**
         * Returns the processed namespace name
         *
         * @return string
         */
        public static function getNamespaceName() {}

        /**
         * Returns the processed module name
         *
         * @return string
         */
        public static function getModuleName() {}

        /**
         * Returns the processed controller name
         *
         * @return string
         */
        public static function getControllerName() {}

        /**
         * Returns the processed action name
         *
         * @return string
         */
        public static function getActionName() {}

        /**
         * Returns the processed parameters
         *
         * @return array
         */
        public static function getParams() {}

        /**
         * Returns the route that matchs the handled URI
         *
         * @return \Phalcon\Mvc\Router\RouteInterface
         */
        public static function getMatchedRoute() {}

        /**
         * Returns the sub expressions in the regular expression matched
         *
         * @return array
         */
        public static function getMatches() {}

        /**
         * Checks if the router macthes any of the defined routes
         *
         * @return bool
         */
        public static function wasMatched() {}

        /**
         * Returns all the routes defined in the router
         *
         * @return RouteInterface[]
         */
        public static function getRoutes() {}

        /**
         * Returns a route object by its id
         *
         * @param mixed $id
         * @return bool|\Phalcon\Mvc\Router\RouteInterface
         */
        public static function getRouteById($id) {}

        /**
         * Returns a route object by its name
         *
         * @param string $name
         * @return bool|\Phalcon\Mvc\Router\RouteInterface
         */
        public static function getRouteByName($name) {}

        /**
         * Returns whether controller name should not be mangled
         *
         * @return bool
         */
        public static function isExactControllerName() {}

        /**
         * @param $key
         * @param $provider
         *
         * @return null
         */
        public static function bindProvider($key, $provider){}

        /**
         * @param $key
         *
         * @return string
         */
        public static function getProvider($key){}
    }

}