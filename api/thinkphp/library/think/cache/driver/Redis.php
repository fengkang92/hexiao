<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2017 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
namespace think\cache\driver;
use think\cache\Driver;
/**
 * Redis缓存驱动，适合单机部署、有前端代理实现高可用的场景，性能最好
 * 有需要在业务层实现读写分离、或者使用RedisCluster的需求，请使用Redisd驱动
 *
 * 要求安装phpredis扩展：https://github.com/nicolasff/phpredis
 * @author    尘缘 <130775@qq.com>
 */
class Redis extends Driver
{
    protected $options = [
        'host'       => '10.189.1.155',
        'port'       => 6379,
        'password'   => '',
        'select'     => 0,
        'timeout'    => 0,
        'expire'     => 0,
        'persistent' => false,
        'prefix'     => '',
    ];
    /**
     * 构造函数
     * @param array $options 缓存参数
     * @access public
     */
    public function __construct($options = [])
    {
        if (!extension_loaded('redis')) {
            throw new \BadFunctionCallException('not support: redis');
        }
        if (!empty($options)) {
            $this->options = array_merge($this->options, $options);
        }
        $func          = $this->options['persistent'] ? 'pconnect' : 'connect';
        $this->handler = new \Redis;
        $this->handler->$func($this->options['host'], $this->options['port'], $this->options['timeout']);
        if ('' != $this->options['password']) {
            $this->handler->auth($this->options['password']);
        }
        if (0 != $this->options['select']) {
            $this->handler->select($this->options['select']);
        }
    }
    /**
     * 判断缓存
     * @access public
     * @param string $name 缓存变量名
     * @return bool
     */
    public function has($name)
    {
        return $this->handler->get($this->getCacheKey($name)) ? true : false;
    }
    /**
     * 读取缓存
     * @access public
     * @param string $name 缓存变量名
     * @param mixed  $default 默认值
     * @return mixed
     */
    public function get($name, $default = false)
    {
        $value = $this->handler->get($this->getCacheKey($name));
        if (is_null($value)) {
            return $default;
        }
        $jsonData = json_decode($value, true);
        // 检测是否为JSON数据 true 返回JSON解析数组, false返回源数据 byron sampson
        return (null === $jsonData) ? $value : $jsonData;
    }
    /**
     * 写入缓存
     * @access public
     * @param string    $name 缓存变量名
     * @param mixed     $value  存储数据
     * @param integer   $expire  有效时间（秒）
     * @return boolean
     */
    public function set($name, $value, $expire = null)
    {
        if (is_null($expire)) {
            $expire = $this->options['expire'];
        }
        if ($this->tag && !$this->has($name)) {
            $first = true;
        }
        $key = $this->getCacheKey($name);
        //对数组/对象数据进行缓存处理，保证数据完整性  byron sampson
        $value = (is_object($value) || is_array($value)) ? json_encode($value) : $value;
        if (is_int($expire) && $expire) {
            $result = $this->handler->setex($key, $expire, $value);
        } else {
            $result = $this->handler->set($key, $value);
        }
        isset($first) && $this->setTagItem($key);
        return $result;
    }
    /**
     * 自增缓存（针对数值缓存）
     * @access public
     * @param string    $name 缓存变量名
     * @param int       $step 步长
     * @return false|int
     */
    public function inc($name, $step = 1)
    {
        $key = $this->getCacheKey($name);
        return $this->handler->incrby($key, $step);
    }
    /**
     * 自减缓存（针对数值缓存）
     * @access public
     * @param string    $name 缓存变量名
     * @param int       $step 步长
     * @return false|int
     */
    public function dec($name, $step = 1)
    {
        $key = $this->getCacheKey($name);
        return $this->handler->decrby($key, $step);
    }
    /**
     * 删除缓存
     * @access public
     * @param string $name 缓存变量名
     * @return boolean
     */
    public function rm($name)
    {
        return $this->handler->delete($this->getCacheKey($name));
    }
    /**
     * 清除缓存
     * @access public
     * @param string $tag 标签名
     * @return boolean
     */
    public function clear($tag = null)
    {
        if ($tag) {
            // 指定标签清除
            $keys = $this->getTagItem($tag);
            foreach ($keys as $key) {
                $this->handler->delete($key);
            }
            $this->rm('tag_' . md5($tag));
            return true;
        }
        return $this->handler->flushDB();
    }
    /**
     * 写入有序列表
     * @access public
     * @param string $key 列表名
     * @param double $score  成员分数
     * @param string $member  成员名
     * @return boolean
     */
    public function Zadd($key, $score, $member){
        if(is_double($score)){
            $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
            $member  =  (is_object($member) || is_array($member)) ? json_encode($member) : $member;
            $result=$this->handler->zAdd($key, $score, $member);
            return $result;
        }else{
            return false;
        }
    }
    /**
     * 统计有序列表成员数
     * @access public
     * @param string $key 列表名
     * @return  int or boolean
     */
    public function Zcard($key){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $result=$this->handler->zCard($key);
        return $result;
    }
    /**
     * 获得有序列表成员排名
     * @access public
     * @param string  $key 列表名
     * @param string $member  成员名
     * @return boolean
     */
    public function Zrevrank($key,$member){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $member  =  (is_object($member) || is_array($member)) ? json_encode($member) : $member;
        $result=$this->handler->zRevRank($key,$member);
        return $result;
    }
    /**
     * 给有序列表制定成员分数增量
     * @access public
     * @param string  $key 列表名
     * @param float or int $value 增量分数
     * @param string $member  成员名
     * @return boolean
     */
    public function Zincrby($key,$value,$member){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $value = is_numeric($value)? $value:doubleval($value);
        $member  =  (is_object($member) || is_array($member)) ? json_encode($member) : $member;
        $result=$this->handler->zIncrBy($key,$value,$member);
        return $result;
    }
    /**
     * 获得有序列表成员分数
     * @access public
     * @param string  $key 列表名
     * @param string $member  成员名
     * @return boolean
     */
    public function Zscore($key,$member){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $member  =  (is_object($member) || is_array($member)) ? json_encode($member) : $member;
        $result=$this->handler->zScore($key,$member);
        return $result;
    }
    /**
     * 返回有序集中指定区间内的成员，通过索引，分数从高到底
     * @access public
     * @param string  $key 列表名
     * @param int $start
     * @param int $end
     *@param string $withscore
     * @return boolean
     */
    public function Zrevrange($key, $start, $end, $withscore = null){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $start  =  is_int($start)?$start:intval($start);
        $end  =  is_int($end)?$end:intval($end);
        $result=$this->handler->zRevRange($key,$start,$end,$withscore);
        return $result;
    }
    /**
     * 移除
     */
    public function Zremrangebyrank($key, $start, $end){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $start  =  is_int($start)?$start:intval($start);
        $end  =  is_int($end)?$end:intval($end);
        $result=$this->handler->zRemRangeByRank($key,$start,$end);
        return $result;
    }
    /*
     *以下都是hash方法
     *
     * 删除一个或者多个哈希表字段
     * @param   string  $key
     * @param   string  $hashKey1
     * @param   string  $hashKey2
     * @param   string  $hashKeyN
     *  @return  int     Number of deleted fields
     * */
    public function Hdel($key,$hashKey1){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $hashKey1  =  (is_object($hashKey1) || is_array($hashKey1)) ? json_encode($hashKey1) : $hashKey1;
        $result=$this->handler->hDel($key,$hashKey1);
        return $result;
    }
    /* +@return  bool:   If the member exists in the hash table, return TRUE, otherwise return FALSE.
    查看哈希表 key 中，指定的字段是否存在。
     * @param   string  $key
     * @param   string  $hashKey
     * */
    public function Hexists($key,$hashKey){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $hashKey  =  (is_object($hashKey) || is_array($hashKey)) ? json_encode($hashKey) : $hashKey;
        $result=$this->handler->hExists($key,$hashKey);
        return $result;
    }
    /*获取存储在哈希表中指定字段的值
     * * @param   string  $key
     *  @param   string  $hashKey
        @return  string  The value, if the command executed successfully BOOL FALSE in case of failure
     * */
    public function Hget($key,$hashKey){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $hashKey  =  (is_object($hashKey) || is_array($hashKey)) ? json_encode($hashKey) : $hashKey;
        $result=$this->handler->hGet($key,$hashKey);
        return $result;
    }
    /*获取存储在哈希表中所有字段的值
     * * @param   string  $key
        @return  string  The value, if the command executed successfully BOOL FALSE in case of failure
    @Returns the whole hash, as an array of strings indexed by strings.
     * */
    public function Hgetall($key){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $result=$this->handler->hGetAll($key);
        return $result;
    }
    /*为哈希表 key 中的指定字段的整数值加上增量 increment 。
     * * @param   string  $key
     * @param   string  $hashKey
     * @param   int     $value (integer) value that will be added to the member's value
     * @return  int     the new value
     * */
    public function Hincrby($key, $hashKey, $value ){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $hashKey  =  (is_object($hashKey) || is_array($hashKey)) ? json_encode($hashKey) : $hashKey;
        $value = intval($value);
        $result=$this->handler->hIncrBy($key, $hashKey, $value );
        return $result;
    }
    /*为哈希表 key 中的指定字段的浮点值加上增量 increment 。
     * * @param   string  $key
     * @param   string  $hashKey
     * @param   float   $increment
     * @return  float    the new value
     * */
    public function Hincrbyfloat($key, $hashKey, $value ){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $hashKey  =  (is_object($hashKey) || is_array($hashKey)) ? json_encode($hashKey) : $hashKey;
        $value = floatval($value);
        $result=$this->handler->hIncrByFloat($key, $hashKey, $value );
        return $result;
    }
    /*获取存储在哈希表中所有字段
    * @param   string  $key
     * @return  array   An array of elements, the keys of the hash. This works like PHP's array_keys().
   @Returns the whole hash, as an array of strings indexed by strings.
    * */
    public function Hkeys($key){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $result=$this->handler->hKeys($key);
        return $result;
    }
    /*获取存储在哈希表中字段的数量
   * @param   string  $key
     * @return  int     the number of items in a hash, FALSE if the key doesn't exist or isn't a hash.
   * */
    public function Hlen($key){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $result=$this->handler->hLen($key);
        return $result;
    }
    /*获取存储在哈希表中所有指定字段的值
     * * @param   string  $key
     * @param   array   $hashKeys
     * @return  array   Array An array of elements, the values of the specified fields in the hash,
     * */
    public function Hmget($key,$hashKeys){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $result=$this->handler->hMGet($key,$hashKeys);
        return $result;
    }
    /*同时将多个 field-value (域-值)对设置到哈希表 key 中。
     * ** @param   string  $key
     * @param   array   $hashKeys key → value array
     * @return  bool
     * */
    public function Hmset($key, $hashKeys ){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $result=$this->handler->hMset($key, $hashKeys );
        return $result;
    }
    /*将哈希表 key 中的字段 field 的值设为 value 。
         *@param   string  $key
         * @param   string  $hashKey
         * @param   string  $value
     *  * @return  bool    TRUE if the field was set, FALSE if it was already present.
         * */
    public function Hset($key, $hashKey, $value ){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $hashKey  =  (is_object($hashKey) || is_array($hashKey)) ? json_encode($hashKey) : $hashKey;
        $value  =  (is_object($value) || is_array($value)) ? json_encode($value) : $value;
        $result=$this->handler->hSet($key, $hashKey, $value );
        return $result;
    }
    /*将哈希表 key 中的字段 field 的值设为 value 。
        *@param   string  $key
        * @param   string  $hashKey
        * @param   string  $value
    *  * @return  bool    TRUE if the field was set, FALSE if it was already present.
        * */
    public function Hsetnx($key, $hashKey, $value ){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $hashKey  =  (is_object($hashKey) || is_array($hashKey)) ? json_encode($hashKey) : $hashKey;
        $value  =  (is_object($value) || is_array($value)) ? json_encode($value) : $value;
        $result=$this->handler->hSetNx($key, $hashKey, $value );
        return $result;
    }
    /*获取哈希表中所有值
   * @param   string  $key
     * @return  array   An array of elements, the values of the hash. This works like PHP's array_values().
   * */
    public function Hvals($key){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $result=$this->handler->hVals($key);
        return $result;
    }
    /*迭代哈希表中的键值对。
       *@param   string  $key
       * @param   string  $pattern
       * @param   string  $value
   *  * @return  bool    TRUE if the field was set, FALSE if it was already present.
       * */
    public function Hscan($key, $iterator, $pattern = '', $count = 0){
        $key  =  (is_object($key) || is_array($key)) ? json_encode($key) : $key;
        $pattern  =  (is_object($pattern) || is_array($pattern)) ? json_encode($pattern) : $pattern;
        $iterator  =  intval($iterator);
        $count  =  intval($count);
        $result=$this->handler->hScan($key, $iterator, $pattern, $count);
        return $result;
    }
}