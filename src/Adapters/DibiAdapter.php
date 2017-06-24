<?php declare(strict_types = 1);

namespace Oli\EmailSender\Persistence\Adapters;

use Dibi\Connection;
use Dibi\Exception;
use Oli\EmailSender\Persistence\Entities\Email;
use Oli\EmailSender\Persistence\Entities\IEmail;
use Oli\EmailSender\Persistence\Entities\Person;

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
		$this->connection->insert('emails', $data)->execute();
		$emailId = $this->connection->getInsertId();

		$this->connection->insert('unsent_emails', ['email_id' => $emailId,])->execute();
		return $emailId;
	}

  /**
   * @param int $emailId
   * @param int $senderId
   * @param array|int[] $recipients
   * @throws Exception
   * @throws \InvalidArgumentException
   */
	private function makeAssociations(int $emailId, int $senderId, array $recipients): void
	{
		$data = [
			'email_id' => [$emailId],
			'person_id' => [$senderId],
		];
		foreach ($recipients as $recipientId)
		{
			$data['email_id'][] = $emailId;
			$data['person_id'][] = $recipientId;
		}

		$this->connection->query('INSERT INTO [emails_to_persons] %m', $data);
	}

	/**
	 * @param int|null $number limit of emails
	 * @return array|IEmail[]
	 * @throws Exception
	 * @throws \InvalidArgumentException
	 */
	public function loadEmails(?int $number = null): array
	{
		$rawEmails = $this->connection->select('emails.*')
			->from('unsent_emails')
			->join('emails')->on('unsent_emails.email_id = emails.id')
			->where('cron_id IS NULL');

		if (!is_null($number))
		{
			$rawEmails = $rawEmails->limit($number);
		}

		$emails = [];
		foreach ($rawEmails->execute()->fetchAssoc('id') as $rawEmail)
		{
			$rawSender = $this->connection->select('persons.*')
				->from('persons')
				->join('emails_to_persons')->on('persons.id = emails_to_persons.person_id')
				->where('emails_to_persons.email_id = %i', $rawEmail['id'])->where('persons.role = %s', 'sender')->execute()->fetch();
			$sender = new Person($rawSender['name'], $rawSender['email'], $rawSender['phone']);

			$rawRecipients = $this->connection->select('persons.*')
				->from('persons')
				->join('emails_to_persons')->on('persons.id = emails_to_persons.person_id')
				->where('emails_to_persons.email_id = %i', $rawEmail['id'])->where('persons.role = %s', 'recipient')->execute()->fetchAssoc('id');
			$recipients = [];
			foreach ($rawRecipients as $rawRecipient)
			{
				$recipients[] = new Person($rawRecipient['name'], $rawRecipient['email'], $rawRecipient['phone']);
			}

			$email = new Email($sender, $recipients[0], $rawEmail['message'], $rawEmail['subject']);
			unset($recipients[0]);
			if (count($recipients >= 1))
			{
				foreach ($recipients as $key => $recipient)
				{
					$email->addRecipient($recipient);
				}
			}
			$emails[] = $email;
		}


		return $emails;
	}

}
