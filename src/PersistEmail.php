<?php declare(strict_types = 1);

namespace Oli\EmailSender\Persistence;

use Oli\EmailSender\Cron\Adapters\IAdapter;
use Oli\EmailSender\Persistence\Entities\IEmail;

/**
 * Class PersistEmail
 * Copyright (c) 2017 Petr Olišar
 * @package Oli\EmailSender\Cron\Persistence
 */
class PersistEmail implements IPersistEmail
{

	/**
	 * @var IAdapter
	 */
	private $adapter;

	public function __construct(IAdapter $adapter)
	{
		$this->adapter = $adapter;
	}

	public function send(IEmail $email): IPersistEmail
	{
		$this->adapter->send($email);
		return $this;
	}

}

