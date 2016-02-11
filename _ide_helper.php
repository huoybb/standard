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

    class RequestFacade extends \Facade{
        /**
         * Gets a variable from the $_REQUEST superglobal applying filters if needed.
         * If no parameters are given the $_REQUEST superglobal is returned
         * <code>
         * //Returns value from $_REQUEST["user_email"] without sanitizing
         * $userEmail = $request->get("user_email");
         * //Returns value from $_REQUEST["user_email"] with sanitizing
         * $userEmail = $request->get("user_email", "email");
         * </code>
         *
         * @param string $name
         * @param mixed $filters
         * @param mixed $defaultValue
         * @param bool $notAllowEmpty
         * @param bool $noRecursive
         * @return mixed
         */
        public static function get($name = null, $filters = null, $defaultValue = null, $notAllowEmpty = false, $noRecursive = false) {}

        /**
         * Gets a variable from the $_POST superglobal applying filters if needed
         * If no parameters are given the $_POST superglobal is returned
         * <code>
         * //Returns value from $_POST["user_email"] without sanitizing
         * $userEmail = $request->getPost("user_email");
         * //Returns value from $_POST["user_email"] with sanitizing
         * $userEmail = $request->getPost("user_email", "email");
         * </code>
         *
         * @param string $name
         * @param mixed $filters
         * @param mixed $defaultValue
         * @param bool $notAllowEmpty
         * @param bool $noRecursive
         * @return mixed
         */
        public static function getPost($name = null, $filters = null, $defaultValue = null, $notAllowEmpty = false, $noRecursive = false) {}

        /**
         * Gets a variable from put request
         * <code>
         * //Returns value from $_PUT["user_email"] without sanitizing
         * $userEmail = $request->getPut("user_email");
         * //Returns value from $_PUT["user_email"] with sanitizing
         * $userEmail = $request->getPut("user_email", "email");
         * </code>
         *
         * @param string $name
         * @param mixed $filters
         * @param mixed $defaultValue
         * @param bool $notAllowEmpty
         * @param bool $noRecursive
         * @return mixed
         */
        public static function getPut($name = null, $filters = null, $defaultValue = null, $notAllowEmpty = false, $noRecursive = false) {}

        /**
         * Gets variable from $_GET superglobal applying filters if needed
         * If no parameters are given the $_GET superglobal is returned
         * <code>
         * //Returns value from $_GET["id"] without sanitizing
         * $id = $request->getQuery("id");
         * //Returns value from $_GET["id"] with sanitizing
         * $id = $request->getQuery("id", "int");
         * //Returns value from $_GET["id"] with a default value
         * $id = $request->getQuery("id", null, 150);
         * </code>
         *
         * @param string $name
         * @param mixed $filters
         * @param mixed $defaultValue
         * @param bool $notAllowEmpty
         * @param bool $noRecursive
         * @return mixed
         */
        public static function getQuery($name = null, $filters = null, $defaultValue = null, $notAllowEmpty = false, $noRecursive = false) {}

        /**
         * Gets variable from $_SERVER superglobal
         *
         * @param string $name
         * @return string|null
         */
        public static function getServer($name) {}

        /**
         * Checks whether $_REQUEST superglobal has certain index
         *
         * @param string $name
         * @return bool
         */
        public static function has($name) {}

        /**
         * Checks whether $_POST superglobal has certain index
         *
         * @param string $name
         * @return bool
         */
        public static function hasPost($name) {}

        /**
         * Checks whether the PUT data has certain index
         *
         * @param string $name
         * @return bool
         */
        public static function hasPut($name) {}

        /**
         * Checks whether $_GET superglobal has certain index
         *
         * @param string $name
         * @return bool
         */
        public static function hasQuery($name) {}

        /**
         * Checks whether $_SERVER superglobal has certain index
         *
         * @param string $name
         * @return bool
         */
        public static final function hasServer($name) {}

        /**
         * Gets HTTP header from request data
         *
         * @param string $header
         * @return string
         */
        public static final function getHeader($header) {}

        /**
         * Gets HTTP schema (http/https)
         *
         * @return string
         */
        public static function getScheme() {}

        /**
         * Checks whether request has been made using ajax
         *
         * @return bool
         */
        public static function isAjax() {}

        /**
         * Checks whether request has been made using SOAP
         *
         * @return bool
         */
        public static function isSoapRequested() {}

        /**
         * Checks whether request has been made using any secure layer
         *
         * @return bool
         */
        public static function isSecureRequest() {}

        /**
         * Gets HTTP raw request body
         *
         * @return string
         */
        public static function getRawBody() {}

        /**
         * Gets decoded JSON HTTP raw request body
         *
         * @param bool $associative
         * @return array|bool|\stdClass
         */
        public static function getJsonRawBody($associative = false) {}

        /**
         * Gets active server address IP
         *
         * @return string
         */
        public static function getServerAddress() {}

        /**
         * Gets active server name
         *
         * @return string
         */
        public static function getServerName() {}

        /**
         * Gets information about schema, host and port used by the request
         *
         * @return string
         */
        public static function getHttpHost() {}

        /**
         * Gets HTTP URI which request has been made
         *
         * @return string
         */
        public static final function getURI() {}

        /**
         * Gets most possible client IPv4 Address. This method search in _SERVER['REMOTE_ADDR'] and optionally in _SERVER['HTTP_X_FORWARDED_FOR']
         *
         * @param bool $trustForwardedHeader
         * @return string|bool
         */
        public static function getClientAddress($trustForwardedHeader = false) {}

        /**
         * Gets HTTP method which request has been made
         *
         * @return string
         */
        public static final function getMethod() {}

        /**
         * Gets HTTP user agent used to made the request
         *
         * @return string
         */
        public static function getUserAgent() {}

        /**
         * Checks if a method is a valid HTTP method
         *
         * @param string $method
         * @return bool
         */
        public static function isValidHttpMethod($method) {}

        /**
         * Check if HTTP method match any of the passed methods
         * When strict is true it checks if validated methods are real HTTP methods
         *
         * @param mixed $methods
         * @param bool $strict
         * @return bool
         */
        public static function isMethod($methods, $strict = false) {}

        /**
         * Checks whether HTTP method is POST. if _SERVER["REQUEST_METHOD"]==="POST"
         *
         * @return bool
         */
        public static function isPost() {}

        /**
         * Checks whether HTTP method is GET. if _SERVER["REQUEST_METHOD"]==="GET"
         *
         * @return bool
         */
        public static function isGet() {}

        /**
         * Checks whether HTTP method is PUT. if _SERVER["REQUEST_METHOD"]==="PUT"
         *
         * @return bool
         */
        public static function isPut() {}

        /**
         * Checks whether HTTP method is PATCH. if _SERVER["REQUEST_METHOD"]==="PATCH"
         *
         * @return bool
         */
        public static function isPatch() {}

        /**
         * Checks whether HTTP method is HEAD. if _SERVER["REQUEST_METHOD"]==="HEAD"
         *
         * @return bool
         */
        public static function isHead() {}

        /**
         * Checks whether HTTP method is DELETE. if _SERVER["REQUEST_METHOD"]==="DELETE"
         *
         * @return bool
         */
        public static function isDelete() {}

        /**
         * Checks whether HTTP method is OPTIONS. if _SERVER["REQUEST_METHOD"]==="OPTIONS"
         *
         * @return bool
         */
        public static function isOptions() {}

        /**
         * Checks whether request include attached files
         *
         * @param bool $onlySuccessful
         * @return long
         */
        public static function hasFiles($onlySuccessful = false) {}

        /**
         * Recursively counts file in an array of files
         *
         * @param mixed $data
         * @param bool $onlySuccessful
         * @return long
         */
        protected static final function hasFileHelper($data, $onlySuccessful) {}

        /**
         * Gets attached files as Phalcon\Http\Request\File instances
         *
         * @param bool $onlySuccessful
         * @return File[]
         */
        public static function getUploadedFiles($onlySuccessful = false) {}



        /**
         * Returns the available headers in the request
         *
         * @return array
         */
        public static function getHeaders() {}

        /**
         * Gets web page that refers active request. ie: http://www.google.com
         *
         * @return string
         */
        public static function getHTTPReferer() {}

        /**
         * Gets content type which request has been made
         *
         * @return string|null
         */
        public static function getContentType() {}

        /**
         * Gets an array with mime/types and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT"]
         *
         * @return array
         */
        public static function getAcceptableContent() {}

        /**
         * Gets best mime/type accepted by the browser/client from _SERVER["HTTP_ACCEPT"]
         *
         * @return string
         */
        public static function getBestAccept() {}

        /**
         * Gets a charsets array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]
         *
         * @return mixed
         */
        public static function getClientCharsets() {}

        /**
         * Gets best charset accepted by the browser/client from _SERVER["HTTP_ACCEPT_CHARSET"]
         *
         * @return string
         */
        public static function getBestCharset() {}

        /**
         * Gets languages array and their quality accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]
         *
         * @return array
         */
        public static function getLanguages() {}

        /**
         * Gets best language accepted by the browser/client from _SERVER["HTTP_ACCEPT_LANGUAGE"]
         *
         * @return string
         */
        public static function getBestLanguage() {}

        /**
         * Gets auth info accepted by the browser/client from $_SERVER['PHP_AUTH_USER']
         *
         * @return array|null
         */
        public static function getBasicAuth() {}

        /**
         * Gets auth info accepted by the browser/client from $_SERVER['PHP_AUTH_DIGEST']
         *
         * @return array
         */
        public static function getDigestAuth() {}
    }

}