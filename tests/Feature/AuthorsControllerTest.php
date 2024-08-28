<?php

namespace Tests\Feature;

use App\Models\Authors;
use Tests\TestCase;

class AuthorsControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetIndexAuthors(): void
    {
        $response = $this->get('api/v1/authors');

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
                        'id', 'name', 'bio', 'birth_date'
                    ]
                ]
            ]);
        }
    }

    public function testGetIndexAuthorsById()
    {   
        $authors = Authors::factory()->create();

        $response = $this->getJson('/api/authors/' . $authors->id);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'responseCode',
            'responseDesc'
        ]);

        $responseData = $response->json();
        if (isset($responseData['responseData'])) {
            $response->assertJsonStructure([
                'responseData' => [
                    'id', 'name', 'bio', 'birth_date'
                ]
            ]);
        }
    }

    public function testCreateAuthors()
    {
        $authors = Authors::factory()->make()->toArray();
        
        $authors['tgl_lahir'] = $authors['birth_date'];
        
        $response = $this->postJson('api/v1/authors', $authors);

        $response->assertStatus(200);

        // Assert bahwa data yang dikembalikan sesuai dengan data yang dikirim
        $response->assertJsonStructure([
            'responseCode',
            'responseDesc'
        ]);
    }

    public function testUpdateAuthors()
    {
        $authors = Authors::factory()->create();
        $newData = Authors::factory()->make()->toArray();

        $dataUpdate = [
            'id' => $authors->id,
            'nama' => $newData['name'],
            'bio'   => $newData['bio'],
            'tgl_lahir'   => $newData['birth_date'],
        ];

        $response = $this->putJson('v1/authors', $dataUpdate);

        // Assert status respons adalah 200 OK
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'responseCode',
            'responseDesc'
        ]);
    }

    public function testDeleteAuthorsById()
    {   
        $authors = Authors::factory()->create();

        $response = $this->deleteJson('/api/authors/' . $authors->id);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'responseCode',
            'responseDesc'
        ]);
    }
}
