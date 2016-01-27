<?php
namespace {
    exit("This file should not be included, only analyzed by your IDE");
    class redisFacade extends \facade
    {
        /**
         * @return bool
         */
        public static function isTagsExist()
        {
        }

        /**
         * @param $data
         * @return bool
         */
        public static function setTags($data)
        {
        }

        /**
         * @return \Tags[]
         */
        public static function getTags()
        {
        }
    }

    class eventFacade extends \facade
    {
        /**
         * @param $eventName
         * @param $handlerAction
         * @return void
         */
        public static function listen($eventName, $handlerAction){ }

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
}