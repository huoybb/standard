<?php

use Phalcon\Forms\Form;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

/**
 * @property Users auth
 * @property Redis redis
 * @property myRouter router
 * @property \Carbon\Carbon carbon
 */
abstract class myController extends Controller
{

    /**中间件的处理
     * @param Dispatcher $dispatcher
     * @return mixed
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher) {

        //验证类的通过，通过所有中间件的验证，否则转到中间件指定的页面，默认页面为上一个页面
        return $this->router->passThrouthMiddleWares($this->request,$this->response,$dispatcher);
    }


    /**根据路由数组来转到相应的地址
     * @param $array
     * @return mixed
     */
    protected  function redirectByRoute($array)
    {
        $url = $this->url->get($array);
        return $this->response->redirect($url);
    }

    protected function redirectBack(){
        return $this->response->redirect($_SERVER['HTTP_REFERER']);
    }



    protected function getPaginator($rowSets, $limit, $page)
    {
        $paginator = new Phalcon\Paginator\Adapter\Model([
            'data'=>$rowSets,
            'limit'=>$limit,
            'page'=>$page
        ]);
        return $this->cyclingPage($paginator->getPaginate());
    }

    protected function getPaginatorByQueryBuilder($builder, $limit, $page)
    {
        $paginator = new Phalcon\Paginator\Adapter\QueryBuilder([
            'builder'=>$builder,
            'limit'=>$limit,
            'page'=>$page
        ]);
        return $this->cyclingPage($paginator->getPaginate());
    }
    private function cyclingPage($page)
    {
        if($page->next == $page->current) $page->next = 1;
        if($page->before == $page->current) $page->before = $page->last;
        return $page;
    }

    protected function success()
    {
        echo 'success';
        return $this->view->disable();
    }

    protected function failed()
    {
        echo 'failed';
        return $this->view->disable();
    }




}
