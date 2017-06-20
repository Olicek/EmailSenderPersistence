<?php declare(strict_types = 1);

namespace Oli\EmailSender\Persistence;

use Oli\EmailSender\Persistence\Entities\IEmail;

interface IPersistEmail
{

	public function send(IEmail $email): IPersistEmail;

}
