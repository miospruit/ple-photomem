<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Tests\TestCase;

class MemoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_memory_with_image()
    {

        Storage::fake('images');
        $file = UploadedFile::fake()->image('testimage.jpg');

        $response = $this->followingRedirects()->post('/memory', [
            'title' => Str::random(40),
            'description' => Str::random(40),
            'image' => $file,
            ]);

        $response->assertStatus(200);
    }
}
