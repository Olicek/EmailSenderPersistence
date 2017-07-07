<?php declare(strict_types = 1);

namespace Oli\EmailSender\Persistence\Entities;

/**
 * Class IMessage
 * Copyright (c) 2017 Petr Olišar
 * @package Oli\EmailSender\Cron\Entities
 */
interface IMessage
{

	public function addRecipient(IPerson $person): IMessage;

	public function getFrom(): IPerson;

	/**
	 * @return array|Person[]
	 */
	public function getRecipients(): array;

	public function getMessage(): string;

}
