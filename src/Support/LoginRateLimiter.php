<?php

namespace Csgt\Login\Support;

class LoginRateLimiter
{
  protected $cache;

  public function __construct($cache)
  {
    $this->cache = $cache;
  }

  public function tooManyAttempts($key, $maxAttempts)
  {
    if ((int) $this->cache->get($key, 0) < $maxAttempts) {
      return false;
    }
    if ((int) $this->cache->get($key.':timer', 0) > time()) {
      return true;
    }
    $this->clear($key);
    return false;
  }

  public function hit($key, $decaySeconds)
  {
    $ttl = version_compare(app()->version(), '5.8.0', '<')
      ? max(1, (int) ceil($decaySeconds / 60))
      : $decaySeconds;
    $this->cache->add($key.':timer', time() + $decaySeconds, $ttl);
    $this->cache->add($key, 0, $ttl);
    return (int) $this->cache->increment($key);
  }

  public function availableIn($key)
  {
    return max(0, (int) $this->cache->get($key.':timer', 0) - time());
  }

  public function clear($key)
  {
    $this->cache->forget($key);
    $this->cache->forget($key.':timer');
  }
}
