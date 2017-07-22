<?php declare(strict_types = 1);

namespace Oli\EmailSender\Persistence\Adapters;

use Oli\EmailSender\Cron\Events\EmailEvent;

interface IDatabaseAdapter
{

	public function install(): void;

	public function onSuccessfulEmailSend(EmailEvent $emailEvent): void;

	public function onUnsuccessfulEmailSend(EmailEvent $emailEvent): void;

}
