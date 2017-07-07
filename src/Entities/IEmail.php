<?php declare(strict_types = 1);

namespace Oli\EmailSender\Persistence\Entities;

interface IEmail extends IMessage
{

	public function getSubject(): ?string;

	/**
	 * @return array|string[]
	 */
	public function getAttachments(): array;

	public function addAttachment(string $attachment): IEmail;

	public function getReplyTo(): IPerson;

}
