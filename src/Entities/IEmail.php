<?php declare(strict_types = 1);

namespace Oli\EmailSender\Persistence\Entities;

interface IEmail extends IMessage
{

	/**
	 * @param int|null $id
	 * @return IEmail
	 * @internal
	 */
	public function setId(?int $id): IEmail;

	/**
	 * @return int|null
	 * @internal
	 */
	public function getId(): ?int;

	public function getSubject(): ?string;

	/**
	 * @return array|string[]
	 */
	public function getAttachments(): array;

	public function addAttachment(string $attachment): IEmail;

	public function getReplyTo(): IPerson;

}
