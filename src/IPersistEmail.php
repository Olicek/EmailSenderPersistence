<?php declare(strict_types = 1);

namespace Oli\EmailSender\Persistence;

use Oli\EmailSender\Persistence\Entities\IEmail;

interface IPersistEmail
{

	/**
	 * @param IEmail $email
	 * @return IPersistEmail
	 */
	public function send(IEmail $email): IPersistEmail;

	/**
	 * @param int|null $number limit of emails
	 * @return array|IEmail
	 */
	public function loadEmails(?int $number = null): array;

}
