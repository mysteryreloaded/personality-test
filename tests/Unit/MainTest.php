<?php

namespace Tests\Unit;

use Tests\TestCase;

class MainTest extends TestCase
{
    public function test_index()
    {
        $response = $this->get(route('index'));
        $response->assertStatus(200)
                 ->assertViewIs('main');
    }

    public function test_create()
    {
        $response = $this->get(route('create'));
        $response->assertStatus(200)
                 ->assertViewIs('main');

    }

    public function test_destroy()
    {
        $response = $this->post(route('destroy'));
        $response->assertStatus(200)
            ->assertExactJson(['success' => true]);
    }

    public function test_question_store()
    {
        $response = $this->post(route('question.store'));
        $response->assertStatus(200)
            ->assertExactJson(['success' => true]);

    }

    public function test_answer_store()
    {
        $response = $this->post(route('answer.store', ['id' => 1]));
        $response->assertStatus(200)
            ->assertExactJson(['success' => true]);

    }

    public function test_finish()
    {
        $response = $this->post(route('finish'));
        $response->assertStatus(200)
            ->assertJson(['success' => true]);

    }
}
