<?php

namespace Csgt\Login\Support;

class DatabaseCompatibility
{
  public static function value($query, $column)
  {
    if (method_exists($query, 'value')) {
      return $query->value($column);
    }
    return $query->pluck($column);
  }

  public static function column($query, $column)
  {
    $values = method_exists($query, 'lists') ? $query->lists($column) : $query->pluck($column);
    return is_object($values) && method_exists($values, 'all') ? $values->all() : (array) $values;
  }
}
