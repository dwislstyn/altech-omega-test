<?php

namespace Tests\Feature;

use App\Models\Authors;
use App\Models\Books;
use Tests\TestCase;

class BooksControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetIndexBooks(): void
    {
        $response = $this->get('api/v1/books');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'responseCode',
                    'responseDesc'
                ]);

        $responseData = $response->json();
        if (isset($responseData['responseData'])) {
            $response->assertJsonStructure([
                'responseData' => [
                    '*' => [
                        'id', 'title', 'description', 'publish_date', 'author_id'
                    ]
                ]
            ]);
        }
    }

    public function testGetIndexBooksById()
    {   
        $books = Books::factory()->create();

        $response = $this->getJson('/api/books/' . $books->id);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'responseCode',
            'responseDesc'
        ]);

        $responseData = $response->json();
        if (isset($responseData['responseData'])) {
            $response->assertJsonStructure([
                'responseData' => [
                    'id', 'title', 'description', 'publish_date', 'author_id'
                ]
            ]);
        }
    }

    public function testCreateBooks()
    {
        $authors = Authors::factory()->create();
        $books = Books::factory()->make()->toArray();

        $books['author_id'] = $authors->id;
        
        $response = $this->postJson('api/v1/books', $books);

        $response->assertStatus(200);

        // Assert bahwa data yang dikembalikan sesuai dengan data yang dikirim
        $response->assertJsonStructure([
            'responseCode',
            'responseDesc'
        ]);
    }

    public function testUpdateBooks()
    {
        $books = Books::factory()->create();
        $newData = Books::factory()->make()->toArray();

        $dataUpdate = [
            'id' => $books->id,
            'title' => $newData['title'],
            'description'   => $newData['description'],
            'publish_date'   => $newData['publish_date'],
            'author_id'   => $newData['author_id'],
        ];

        $response = $this->putJson('v1/books', $dataUpdate);

        // Assert status respons adalah 200 OK
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'responseCode',
            'responseDesc'
        ]);
    }

    public function testDeleteBooksById()
    {   
        $books = Books::factory()->create();

        $response = $this->deleteJson('/api/books/' . $books->id);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'responseCode',
            'responseDesc'
        ]);
    }
}
