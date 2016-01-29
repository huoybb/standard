<?php
namespace {
    exit("This file should not be included, only analyzed by your IDE");
    class redisFacade extends \Facade
    {
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

    class eventFacade extends \Facade
    {
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