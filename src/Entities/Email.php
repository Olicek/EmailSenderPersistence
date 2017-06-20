<?php declare(strict_types = 1);

namespace Oli\EmailSender\Persistence\Entities;

/**
 * Class Email
 * Copyright (c) 2017 Petr Olišar
 * @package Oli\EmailSender\Cron\Entities
 */
class Email implements IEmail
{

	/**
	 * @var string|null
	 */
	private $subject;

	/**
	 * @var Person
	 */
	private $from;

	/**
	 * @var array|Person[]
	 */
	private $recipients = [];

	/**
	 * @var array|string[]
	 */
	private $attachments = [];

	/**
	 * @var string
	 */
	private $message;

	/**
	 * @var Person
	 */
	private $replyTo;

	public function __construct(Person $from, Person $recipient, string $message, ?string $subject = null)
	{
		$this->from = $from;
		$this->recipients[] = $recipient;
		$this->message = $message;
		$this->subject = $subject;
		$this->replyTo = $from;
	}

	public function getReplyTo(): Person
	{
		return $this->replyTo;
	}

	public function addAttachment(string $attachment): IEmail
	{
		$this->attachments[] = $attachment;
		return $this;
	}

	public function changeReplyTo(Person $person): IEmail
	{
		$this->replyTo = $person;
		return $this;
	} // changeReplyTo()

	public function addRecipient(Person $person): IMessage
	{
		$this->recipients[] = $person;
		return $this;
	}

	public function getFrom(): Person
	{
		return $this->from;
	}

	/**
	 * @return array|Person[]
	 */
	public function getRecipients(): array
	{
		return $this->recipients;
	}

	public function getMessage(): string
	{
		return $this->message;
	}

	public function getSubject(): ?string
	{
		return $this->subject;
	}

	/**
	 * @return array|string[]
	 */
	public function getAttachments(): array
	{
		return $this->attachments;
	}

}
