<?php

namespace Illuminate\Cache;

use Carbon\Carbon;
use Illuminate\Contracts\Cache\Lock as LockContract;

class MemcachedLock extends Lock implements LockContract
{
    /**
     * The Memcached instance.
     *
     * @var \Memcached
     */
    protected $memcached;

    /**
     * The name of the lock.
     *
     * @var string
     */
    protected $name;

    /**
     * The number of seconds the lock should be maintained.
     *
     * @var int
     */
    protected $seconds;

    /**
     * Create a new lock instance.
     *
     * @param  \Memcached  $memcached
     * @param  string  $name
     * @param  int  $seconds
     * @return void
     */
    public function __construct($memcached, $name, $seconds)
    {
        $this->name = $name;
        $this->seconds = $seconds;
        $this->memcached = $memcached;
    }

    /**
     * Attempt to acquire the lock.
     *
     * @return bool
     */
    public function acquire()
    {
        return $this->memcached->add(
            $this->name, 1, $this->seconds
        );
    }

    /**
     * Release the lock.
     *
     * @return void
     */
    public function release()
    {
        $this->memcached->delete($this->name);
    }
}