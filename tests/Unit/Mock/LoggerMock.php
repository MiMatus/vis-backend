<?php declare(strict_types=1);


namespace SkillShare\Test\Unit\Mock;

use Tracy\ILogger;

final class LoggerMock implements ILogger
{

	public function log($value, $level = self::INFO){}

}

