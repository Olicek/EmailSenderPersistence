<?php declare(strict_types = 1);

namespace Oli\EmailSender\Persistence;

use Oli\EmailSender\Persistence\Entities\ISms;

interface IPersistSms
{

	public function send(ISms $sms): self;

}
