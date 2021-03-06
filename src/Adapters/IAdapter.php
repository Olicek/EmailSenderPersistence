<?php declare(strict_types = 1);

namespace Oli\EmailSender\Persistence\Adapters;

use Oli\EmailSender\Persistence\Entities\IEmail;

/**
 * Class IAdapter
 * Copyright (c) 2017 Petr Olišar
 * @package Oli\EmailSender\Persistence\Adapters
 */
interface IAdapter
{

	public function insertEmail(IEmail $email): void;

	/**
	 * @param int|null $number limit of emails
	 * @return array|IEmail[]
	 */
	public function loadEmails(?int $number = null): array;

}
