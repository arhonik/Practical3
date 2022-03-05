<?php

namespace App\Tests\Unit\Command;

use App\Domain\Booking\Command\BookTicketCommand;
use Monolog\Test\TestCase;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationBookTicketCommandTest extends TestCase
{
    private BookTicketCommand $command;
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->command = new BookTicketCommand();
        $this->command->phone = '+79021869474';
        $this->command->name = 'Alex';
        $this->command->movieShowId = 'a46eb3ca-d913-426c-8af9-6340dfe49f14';

        $this->validator = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
    }

    public function testPropertyValueValidationShouldSucceed(): void
    {
        $errors = $this->validator->validate($this->command);

        $this->assertCount(0, $errors);
    }

    public function testValidationEmptyValuePhonePropertyShouldNotSucceed(): void
    {
        $this->command->phone = '';

        $errors = $this->validator->validate($this->command);

        $this->assertCount(1, $errors);
    }

    public function testValidationPhonePropertyWithInvalidValueShouldNotSucceed(): void
    {
        $this->command->phone = '+7 902 186 94 74';

        $errors = $this->validator->validate($this->command);

        $this->assertCount(1, $errors);

    }

    public function testValidationEmptyValueNamePropertyShouldNotSucceed(): void
    {
        $this->command->name = '';

        $errors = $this->validator->validate($this->command);

        $this->assertCount(1, $errors);
    }

    public function testValidationEmptyValueMovieShowIdPropertyShouldNotSucceed(): void
    {
        $this->command->movieShowId = '';

        $errors = $this->validator->validate($this->command);

        $this->assertCount(1, $errors);
    }

    public function testValidationMovieShowIdPropertyWithInvalidValueShouldNotSucceed(): void
    {
        $this->command->movieShowId = 'a46eb3ca-d913-426c-8af9-6340d';

        $errors = $this->validator->validate($this->command);

        $this->assertCount(1, $errors);
    }
}