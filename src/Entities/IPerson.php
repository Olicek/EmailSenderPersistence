<?php
/**
 * Created by PhpStorm.
 * User: Martina
 * Date: 7.7.2017
 * Time: 10:57
 */

namespace Oli\EmailSender\Persistence\Entities;


interface IPerson
{

    public function getName(): string;

    public function getEmail(): ?string;

    public function getPhone(): ?string;

}