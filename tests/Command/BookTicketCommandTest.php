<?php

namespace App\Tests\Command;

use App\Domain\Booking\Command\BookTicketCommand;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BookTicketCommandTest extends \Monolog\Test\TestCase
{
    protected BookTicketCommand $command;
    protected ValidatorInterface $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->command = new BookTicketCommand();
        $this->command->phone = '+79021869474';
        $this->command->name = 'Alex';
        $this->command->movieShowId = 'a46eb3ca-d913-426c-8af9-6340dfe49f14';

        $this->validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
    }

    public function testValidateProperty(): void
    {
        $errors = $this->validator->validate($this->command);

        $this->assertCount(0, $errors);
    }

    public function testValidatePropertyPhone(): void
    {
        $this->command->phone = '';
        $errors = $this->validator->validate($this->command);
        $this->assertCount(1, $errors);

        $this->command->phone = '+7 902 186 94 74';
        $errors = $this->validator->validate($this->command);
        $this->assertCount(1, $errors);

        $this->command->phone = '+79021869474';
        $errors = $this->validator->validate($this->command);
        $this->assertCount(0, $errors);
    }

    public function testValidatePropertyName(): void
    {
        $this->command->name = '';
        $errors = $this->validator->validate($this->command);
        $this->assertCount(1, $errors);

        $this->command->name = 'Alex';
        $errors = $this->validator->validate($this->command);
        $this->assertCount(0, $errors);
    }

    public function testValidatePropertyMovieShowId(): void
    {
        $this->command->movieShowId = '';
        $errors = $this->validator->validate($this->command);
        $this->assertCount(1, $errors);

        $this->command->movieShowId = 'a46eb3ca-d913-426c-8af9-6340d';
        $errors = $this->validator->validate($this->command);
        $this->assertCount(1, $errors);

        $this->command->movieShowId = 'a46eb3ca-d913-426c-8af9-6340dfe49f14';
        $errors = $this->validator->validate($this->command);
        $this->assertCount(0, $errors);
    }
}