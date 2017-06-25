<?php declare(strict_types = 1);

namespace Oli\EmailSender\Persistence\Adapters;

interface IDatabaseAdapter
{

	public function install(): void;

}
