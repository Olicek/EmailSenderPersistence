<?php declare(strict_types = 1);

namespace Oli\EmailSender\Persistence\Adapters;

use Dibi\Connection;
use Dibi\Exception;
use Oli\EmailSender\Persistence\Entities\IEmail;

/**
 * Class DibiAdapter
 * Copyright (c) 2017 Petr Olišar
 * @package Oli\EmailSender\Persistence\Adapters
 */
class DibiAdapter implements IAdapter
{

	/**
	 * @var Connection
	 */
	private $connection;

	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

	public function insertEmail(IEmail $email): void
	{
		$senderId = $this->senderToDatabase($email);
		$recipients = $this->recipientToDatabase($email);
		$emailId = $this->emailToDatabase($email);
		$this->makeAssociations($emailId, $senderId, $recipients);
	}

	private function senderToDatabase(IEmail $email): int
	{
		$data = [
			'name' => $email->getFrom()->getName(),
			'email' => $email->getFrom()->getEmail(),
			'phone' => $email->getFrom()->getPhone(),
			'role' => 'sender',
		];
		$this->connection->insert('persons', $data)->execute();
		return $this->connection->getInsertId();
	}

	/**
	 * @param IEmail $email
	 * @return array|int[]
	 * @throws Exception
	 * @throws \InvalidArgumentException
	 */
	private function recipientToDatabase(IEmail $email): array
	{
		$ids = [];
		foreach ($email->getRecipients() as $recipient)
		{
			$data = [
				'name' => $recipient->getName(),
				'email' => $recipient->getEmail(),
				'phone' => $recipient->getPhone(),
				'role' => 'recipient',
			];
			$this->connection->insert('persons', $data)->execute();
			$ids[] = $this->connection->getInsertId();
		}
		return $ids;
	}

	/**
	 * @param IEmail $email
	 * @return int
	 * @throws Exception
	 * @throws \InvalidArgumentException
	 */
	private function emailToDatabase(IEmail $email): int
	{
		$data = [
			'message' => $email->getMessage(),
			'subject' => $email->getSubject(),
		];
		$this->connection->insert('emails', $data);
		return $this->connection->getInsertId();
	}

	/**
	 * @param int $emailId
	 * @param int $senderId
	 * @param array|int[] $recipients
	 * @throws \InvalidArgumentException
	 */
	private function makeAssociations(int $emailId, int $senderId, array $recipients): void
	{
		$data = [
			'email_id' => $emailId,
			'sender_id' => $senderId,
		];
		foreach ($recipients as $recipientId)
		{
			$data[] = [
				'email_id' => $emailId,
				'person_id' => $recipientId,
			];
		}

		$this->connection->insert('emails_to_persions', $data);
	}

}
