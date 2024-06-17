<?php

namespace App\Enum;

class RepetentsStatus
{
  const WITH = 'With';
  const WITHOUT = 'Without';
  const ONLY = 'Only';

  /**
   * @return array<string>
   */
  public static function getValues(): array
  {
    return [self::WITH, self::WITHOUT, self::ONLY];
  }
}
