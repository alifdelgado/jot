<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Contact;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_contact_can_be_added()
    {
        $this->withoutExceptionHandling();
        $this->post('/api/contacts', $this->userValidData());
        $contact = Contact::first();
        $this->assertEquals('Test name', $contact->name);
        $this->assertEquals('test@email.com', $contact->email);
        $this->assertEquals('05/14/1988', $contact->birthday);
        $this->assertEquals('ABC Development', $contact->company);
    }

    /**
     * @test
     */
    public function a_name_is_required()
    {
        $this->post('/api/contacts',
                $this->userValidData(['name' => null]))
            ->assertSessionHasErrors('name')
            ->assertCount(0, Contact::all());
    }

    /**
     * @test
     */
    public function an_email_is_required()
    {
        $this->post('/api/contacts',
                $this->userValidData(['email' => null]))
            ->assertSessionHasErrors('email')
            ->assertCount(0, Contact::all());
    }

     /**
     * @return array
     */
    protected function userValidData($overrides = []): array
    {
        return array_merge([
            'name'      => 'Test name',
            'email'     => 'test@email.com',
            'birthday'  => '05/14/1988',
            'company'   => 'ABC Development'
        ], $overrides);
    }
}
