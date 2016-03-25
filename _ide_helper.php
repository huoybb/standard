<?php
namespace {

    use Phalcon\Http\Request;
    use Phalcon\Http\Response;
    use Phalcon\Http\Response\Cookies;
    use Phalcon\Mvc\Dispatcher;
    use Phalcon\Mvc\Router\RouteInterface;
    use Phalcon\Mvc\RouterInterface;
    use Phalcon\Mvc\Url;

    exit("This file should not be included, only analyzed by your IDE");
    class TagsCacheFacade extends \myFacade{
        /**
         * @return bool
         */
        public static function isTagsExist(Users $user = null){}
        /**
         * @param $data
         * @return bool
         */
        public static function setTags($tags,$user = null){}
        /**
         * @return \Tags[]
         */
        public static function getTags($user = null){}
        /**
         * @return bool
         */
        public static function deleteTags($user = null){}

    }
    class RedisFacade extends \myFacade{
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
    class ConfigFacade extends \myFacade
    {
        /**
         * @return array
         */
        public static function toArray(){}
    }

    class EventFacade extends \myFacade{

        /**
         * @param $event
         */
        public static function trigger($event){}
    }

    class SessionFacade extends \myFacade{
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

    class CookieFacade extends \myFacade{
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

    class FlashFacade extends \myFacade{
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

    class AuthFacade extends \myFacade {

        public static function save(array $params = []){}
        /**
         * @param Files $file
         * @return bool
         */
        public static function wantToRead(Files $file){}
        /**
         * @param Files $file
         * @return bool
         */
        public static function reading(Files $file){}
        /**
         * @param Files $file
         * @return bool
         */
        public static function done(Files $file){}
        /**
         * @param string $status
         * @param string $isActive
         * @return \Phalcon\Mvc\Model\ResultsetInterface
         */
        public static function getReadingList($status,$isActive = true){}

        /**
         *获取当前用户的通知项目
         * @return \Phalcon\Mvc\Model\Resultset\Complex
         */
        public static function getNotifications(){}

        /**获取当前用户的未读通知项目
         * @return Phalcon\Mvc\Model\Resultset\Complex
         */
        public static function getUnreadNotifications(){}

        /**
         * @param Notification $notification
         * @return bool
         */
        public static function readNotification(Notification $notification){}

        /**
         * @param Notification $notification
         * @return string
         */
        public static function getNotificationObjectType(Notification $notification){}

        /**
         * @param \myModel $object
         * @return boolean
         */
        public static function isSubscribedTo(\myModel $object){}

        /**
         * @return Subscriber[]
         */
        public static function getSubscribedObjects(){}

        /**
         * @param \myModel $$object
         * @return Users
         */
        public static function subscribe(\myModel $object){}

        /**
         * @param \myModel $$object
         * @return Users
         */
        public static function unsubscribe(\myModel $object){}
    }

    class SecurityFacade extends \myFacade{
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

    class CryptFacade extends \myFacade{
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

    class myToolsFacade extends \myFacade{
        /**
         * @param $search
         * @return boolean
         */
        public static function isStandardNumber($search){}
    }

    class RouterFacade extends \myFacade{
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

        /**中间件的过滤，针对当前路由，有哪些中间件适用，看看是否能够通过所有中间件
         * 这里还有类似Auth这类中间件也需要一个处理，除了几个路由外都需要进行验证，否则就进行url的redirect
         * @param Request $request
         * @param Response $response
         * @return bool
         */
        public static function executeMiddleWareChecking(Request $request, Response $response,Dispatcher $dispatcher){}

        /**将router中参数，按照controller的中Action的类型参数进行绑定
         * @param Dispatcher $dispatcher
         * @return bool
         */
        public static function executeModelBinding(Dispatcher $dispatcher){}
    }

    class RequestFacade extends \myFacade{
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

    class ResponseFacade extends \myFacade{
        /**
         * Sets the HTTP response code
         * <code>
         * $response->setStatusCode(404, "Not Found");
         * </code>
         *
         * @param int $code
         * @param string $message
         * @return Response
         */
        public static function setStatusCode($code, $message = null) {}

        /**
         * Returns the status code
         * <code>
         * print_r($response->getStatusCode());
         * </code>
         *
         * @return array
         */
        public static function getStatusCode() {}

        /**
         * Sets a headers bag for the response externally
         *
         * @param mixed $headers
         * @return Response
         */
        public static function setHeaders(\Phalcon\Http\Response\HeadersInterface $headers) {}

        /**
         * Returns headers set by the user
         *
         * @return \Phalcon\Http\Response\HeadersInterface
         */
        public static function getHeaders() {}

        /**
         * Sets a cookies bag for the response externally
         *
         * @param mixed $cookies
         * @return Response
         */
        public static function setCookies(\Phalcon\Http\Response\CookiesInterface $cookies) {}

        /**
         * Returns coookies set by the user
         *
         * @return \Phalcon\Http\Response\CookiesInterface
         */
        public static function getCookies() {}

        /**
         * Overwrites a header in the response
         * <code>
         * $response->setHeader("Content-Type", "text/plain");
         * </code>
         *
         * @param string $name
         * @param string $value
         * @return \Phalcon\Http\Response
         */
        public static function setHeader($name, $value) {}

        /**
         * Send a raw header to the response
         * <code>
         * $response->setRawHeader("HTTP/1.1 404 Not Found");
         * </code>
         *
         * @param string $header
         * @return Response
         */
        public static function setRawHeader($header) {}

        /**
         * Resets all the stablished headers
         *
         * @return Response
         */
        public static function resetHeaders() {}

        /**
         * Sets a Expires header to use HTTP cache
         * <code>
         * $this->response->setExpires(new DateTime());
         * </code>
         *
         * @param mixed $datetime
         * @return Response
         */
        public static function setExpires(\DateTime $datetime) {}

        /**
         * Sets Cache headers to use HTTP cache
         * <code>
         * $this->response->setCache(60);
         * </code>
         *
         * @param int $minutes
         * @return Response
         */
        public static function setCache($minutes) {}

        /**
         * Sends a Not-Modified response
         *
         * @return Response
         */
        public static function setNotModified() {}

        /**
         * Sets the response content-type mime, optionally the charset
         * <code>
         * $response->setContentType('application/pdf');
         * $response->setContentType('text/plain', 'UTF-8');
         * </code>
         *
         * @param string $contentType
         * @param string $charset
         * @return \Phalcon\Http\Response
         */
        public static function setContentType($contentType, $charset = null) {}

        /**
         * Set a custom ETag
         * <code>
         * $response->setEtag(md5(time()));
         * </code>
         *
         * @param string $etag
         * @return Response
         */
        public static function setEtag($etag) {}

        /**
         * Redirect by HTTP to another action or URL
         * <code>
         * //Using a string redirect (internal/external)
         * $response->redirect("posts/index");
         * $response->redirect("http://en.wikipedia.org", true);
         * $response->redirect("http://www.example.com/new-location", true, 301);
         * //Making a redirection based on a named route
         * $response->redirect(array(
         * "for" => "index-lang",
         * "lang" => "jp",
         * "controller" => "index"
         * ));
         * </code>
         *
         * @param string|array $location
         * @param boolean $externalRedirect
         * @param int $statusCode
         * @return \Phalcon\Http\Response
         */
        public static function redirect($location = null, $externalRedirect = false, $statusCode = 302) {}

        /**
         * Sets HTTP response body
         * <code>
         * response->setContent("<h1>Hello!</h1>");
         * </code>
         *
         * @param string $content
         * @return Response
         */
        public static function setContent($content) {}

        /**
         * Sets HTTP response body. The parameter is automatically converted to JSON
         * <code>
         * $response->setJsonContent(array("status" => "OK"));
         * </code>
         *
         * @param mixed $content
         * @param int $jsonOptions
         * @param mixed $depth
         * @return \Phalcon\Http\Response
         */
        public static function setJsonContent($content, $jsonOptions = 0, $depth = 512) {}

        /**
         * Appends a string to the HTTP response body
         *
         * @param string $content
         * @return \Phalcon\Http\Response
         */
        public static function appendContent($content) {}

        /**
         * Gets the HTTP response body
         *
         * @return string
         */
        public static function getContent() {}

        /**
         * Check if the response is already sent
         *
         * @return bool
         */
        public static function isSent() {}

        /**
         * Sends headers to the client
         *
         * @return Response
         */
        public static function sendHeaders() {}

        /**
         * Sends cookies to the client
         *
         * @return Response
         */
        public static function sendCookies() {}

        /**
         * Prints out HTTP response to the client
         *
         * @return Response
         */
        public static function send() {}

        /**
         * Sets an attached file to be sent at the end of the request
         *
         * @param string $filePath
         * @param string $attachmentName
         * @param mixed $attachment
         * @return \Phalcon\Http\Response
         */
        public static function setFileToSend($filePath, $attachmentName = null, $attachment = true) {}
    }

    class UrlFacade extends \myFacade{
        /**
         * Sets a prefix for all the URIs to be generated
         * <code>
         * $url->setBaseUri('/invo/');
         * $url->setBaseUri('/invo/index.php/');
         * </code>
         *
         * @param string $baseUri
         * @return Url
         */
        public static function setBaseUri($baseUri) {}

        /**
         * Sets a prefix for all static URLs generated
         * <code>
         * $url->setStaticBaseUri('/invo/');
         * </code>
         *
         * @param string $staticBaseUri
         * @return Url
         */
        public static function setStaticBaseUri($staticBaseUri) {}

        /**
         * Returns the prefix for all the generated urls. By default /
         *
         * @return string
         */
        public static function getBaseUri() {}

        /**
         * Returns the prefix for all the generated static urls. By default /
         *
         * @return string
         */
        public static function getStaticBaseUri() {}

        /**
         * Sets a base path for all the generated paths
         * <code>
         * $url->setBasePath('/var/www/htdocs/');
         * </code>
         *
         * @param string $basePath
         * @return Url
         */
        public static function setBasePath($basePath) {}

        /**
         * Returns the base path
         *
         * @return string
         */
        public static function getBasePath() {}

        /**
         * Generates a URL
         * <code>
         * //Generate a URL appending the URI to the base URI
         * echo $url->get('products/edit/1');
         * //Generate a URL for a predefined route
         * echo $url->get(array('for' => 'blog-post', 'title' => 'some-cool-stuff', 'year' => '2015'));
         * // Generate a URL with GET arguments (/show/products?id=1&name=Carrots)
         * echo $url->get('show/products', array('id' => 1, 'name' => 'Carrots'));
         * // Generate an absolute URL by setting the third parameter as false.
         * echo $url->get('https://phalconphp.com/', null, false);
         * </code>
         *
         * @param mixed $uri
         * @param mixed $args
         * @param mixed $local
         * @param mixed $baseUri
         * @return string
         */
        public static function get($uri = null, $args = null, $local = null, $baseUri = null) {}

        /**
         * Generates a URL for a static resource
         * <code>
         * // Generate a URL for a static resource
         * echo $url->getStatic("img/logo.png");
         * // Generate a URL for a static predefined route
         * echo $url->getStatic(array('for' => 'logo-cdn'));
         * </code>
         *
         * @param mixed $uri
         * @return string
         */
        public static function getStatic($uri = null) {}

        /**
         * Generates a local path
         *
         * @param string $path
         * @return string
         */
        public static function path($path = null) {}
    }

    class ModelsManager extends \myFacade{
        /**
         * Creates a Phalcon\Mvc\Model\Query\Builder
         *
         * @param mixed $params
         * @return \Phalcon\Mvc\Model\Query\BuilderInterface
         */
        public static function createBuilder($params = null) {}
    }


// ---------针对Igbinary模块函数的stub提示--------
    /**
     * @param mixed $object
     * @return string
     */
    function igbinary_serialize($object){}

    /**
     * @param string $encodedObject
     * @return mixed
     */
    function igbinary_unserialize($encodedObject){}



}