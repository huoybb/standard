<?php
use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Router;

/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2015/7/19
 * Time: 9:30
 */

class myRouter extends Router{
    /**
     * @var array
     */
    public $middlewares = [];

    public $middlewaresForEveryRoute = [];

    /**
     * myRouter constructor.
     */
    public function __construct($defaultRoutes = true)
    {
        parent::__construct($defaultRoutes);
    }

    public function addMiddlewaresForEveryRoute(array $middleware=[])
    {
        $this->middlewaresForEveryRoute = $middleware;
    }

    /**
     * 主要是增加了一个中间件的功能，利用short syntax来增加中间件，这样的好处是路由、中间件在一起，便于管理
     * @param $pattern
     * @param null $path
     * @param array $middleware
     * @return \Phalcon\Mvc\Router\Route
     */
    public function addx($pattern,$path=null,array $middleware=[])//给路由添加中间件
    {
        $this->middlewares[$pattern]=$middleware;
        return $this->add($pattern,$path);
    }

    /**判断是否存在对应的中间件
     * @param $pattern
     * @return bool
     */
    public function hasMatchedMiddleWares($pattern)
    {
        return isset($this->middlewares[$pattern]);
    }

    /**获得指定的中间件字符串
     * @param $pattern
     * @return array
     *
     * 未来可以设想将中间件参数的问题在这类利用正则的方式来匹配出来，
     * 以便更多的表达用一个中间件来表示，但可以进行切换，以便提高中间件的重用性！
     *
     */
    public function getMiddleWares($pattern)
    {
        return $this->middlewares[$pattern];
    }

    /**中间件的过滤，针对当前路由，有哪些中间件适用，看看是否能够通过所有中间件
     * 这里还有类似Auth这类中间件也需要一个处理，除了几个路由外都需要进行验证，否则就进行url的redirect
     * @param Request $request
     * @param Response $response
     * @return bool
     */
    public function passThrouthMiddleWares(Request $request, Response $response,Dispatcher $dispatcher)
    {
        $route = $this->getMatchedRoute();
        if(null == $route) {
            $r = $this->getDI()->get('router');
            $r->handle($request->getURI());
            $route = $r->getMatchedRoute();
            //为什么搜索“装备”会出现找不到路由的问题？估计与字符处理有关系
            if(null == $route) die('url地址无效，找不到对应的路由设置！');
        }

        $pattern = $route->getPattern();

        //对每个路由都进行验证的中间件！ @todo 如果是get方式的话，目标对象如何获取呢？当前用户是否拥有该资源？
        foreach($this->middlewaresForEveryRoute as $validator){
            $data = null;
            if(preg_match('|.*:.*|',$validator)) {//此处设置了可以带中间件参数
                list($validator,$data) = explode(':',$validator);
                $data = $dispatcher->getParam($data);
            }

            /** @var myValidation $validator */
            $validator = new $validator;

            if(!in_array($route->getName(),$validator->excludedRoutes) and !$validator->isValid($data)){
                $url = $validator->getRedirectedUrl();
//                    dd($url);
                $response->redirect($url,true);
                return false;
            }
        }

        //@todo 如果是get方式的如何过滤呢？应该如何设置才是正常的呢？例如get方式的search的过滤，单独处理？也许吧？
        if($this->hasMatchedMiddleWares($pattern) and $request->isPost()){
            $middleWares = $this->getMiddleWares($pattern);
            foreach($middleWares as $validator){
                $data = $request->getPost();
//                dd($validator);
                if(preg_match('|[^:]+:[^:]+|',$validator)){
                    list($validator,$data) = explode(':',$validator);
                    $data = $dispatcher->getParam($data);
                }

                if(preg_match('|.*Rules$|',$validator)){
                    $rules = new $validator();
                    $validator = (new myValidation())->take($rules);
                }else{
                    $validator = new $validator();
                }

                if(!$validator->isValid($data)){
                    $url = $validator->getRedirectedUrl();
//                    dd($url);
                    $response->redirect($url,true);
                    return false;
                }
            }
        }
        return true;
    }

//    protected $validatorMap = [
//        'Email'=>'Phalcon\Validation\Validator\Email',
//        'Exclusionin'=>'Phalcon\Validation\Validator\Exclusionin',
//        'Inclusionin'=>'Phalcon\Validation\Validator\Inclusionin',
//        'Numericality'=>'Phalcon\Validation\Validator\Numericality',
//        'PresenceOf'=>'Phalcon\Validation\Validator\PresenceOf',
//        'Regex'=>'Phalcon\Validation\Validator\Regex',
//        'StringLength'=>'Phalcon\Validation\Validator\StringLength',
//        'Uniqueness'=>'Phalcon\Validation\Validator\Uniqueness',
//        'Url'=>'Phalcon\Validation\Validator\Url',
//        'compare'=>'compare',
//        'default'=>'defaultValue'
//    ];
//
//    private function getValidatorFromRules($rules)
//    {
//        $Validation = new myValidation();
//        foreach($rules->rules as $field => $rule ){
//            $className = $this->validatorMap[$rule['validator']];
//            $message = $rule['message'];
//            $Validation->add($field,new $className(['message'=>$message]));
//        }
//        return $Validation;
//    }
} 