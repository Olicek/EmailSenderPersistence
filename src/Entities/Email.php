<?php declare(strict_types = 1);

namespace Oli\EmailSender\Persistence\Entities;

/**
 * Class Email
 * Copyright (c) 2017 Petr Olišar
 * @package Oli\EmailSender\Cron\Entities
 */
final class Email implements IEmail
{

	/**
	 * @var string|null
	 */
	private $subject;

	/**
	 * @var IPerson
	 */
	private $from;

	/**
	 * @var array|IPerson[]
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
	 * @var IPerson
	 */
	private $replyTo;

	public function __construct(IPerson $from, IPerson $recipient, string $message, ?string $subject = null)
	{
		$this->from = $from;
		$this->recipients[] = $recipient;
		$this->message = $message;
		$this->subject = $subject;
		$this->replyTo = $from;
	}

	public function getReplyTo(): IPerson
	{
		return $this->replyTo;
	}

	public function addAttachment(string $attachment): IEmail
	{
		$this->attachments[] = $attachment;
		return $this;
	}

	public function changeReplyTo(IPerson $person): IEmail
	{
		$this->replyTo = $person;
		return $this;
	} // changeReplyTo()

	public function addRecipient(IPerson $person): IMessage
	{
		$this->recipients[] = $person;
		return $this;
	}

	public function getFrom(): IPerson
	{
		return $this->from;
	}

	/**
	 * @return array|IPerson[]
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
