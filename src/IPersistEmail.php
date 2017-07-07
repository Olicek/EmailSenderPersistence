<?php declare(strict_types = 1);

namespace Oli\EmailSender\Persistence;

use Oli\EmailSender\Persistence\Entities\IEmail;

interface IPersistEmail
{

	/**
     * Save email to persistent layer.
	 * @param IEmail $email
	 * @return IPersistEmail
	 */
	public function send(IEmail $email): IPersistEmail;

	/**
     * Load emails which should be sended.
	 * @param int|null $number limit of emails
	 * @return array|IEmail
	 */
	public function loadEmails(?int $number = null): array;

}
