<?php declare(strict_types = 1);

namespace Oli\EmailSender\Persistence\Entities;

/**
 * Class Person
 * Copyright (c) 2017 Petr Olišar
 * @package Oli\EmailSender\Cron\Entities
 */
final class Person implements IPerson
{

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var null|string
	 */
	private $email;

	/**
	 * @var null|string
	 */
	private $phone;

	public function __construct(string $name, ?string $email, ?string $phone = null)
	{
		$this->name = $name;
		$this->email = $email;
		$this->phone = $phone;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function getPhone(): ?string
	{
		return $this->phone;
	}

}
