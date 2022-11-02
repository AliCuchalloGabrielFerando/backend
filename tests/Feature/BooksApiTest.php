<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BooksApiTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function can_get_all_books(){
        $books = Book::factory(4)->create();

        $this->get(route('books.index'))->dump();
        //dd($books);
    }
    /** @test */
    public function can_get_one_book(){
        $book = Book::factory()->create();
        dd(route('books.show',$book));
    }
    /** @test */
    public function can_create_books(){

        $this->postJson(route('books.store'),[])
            ->assertJsonValidationErrorFor('title');

        $this->postJson(route('books.store'),[
            'title'=>'My new Book'
        ])->assertJsonFragment([
            'title'=>'My new Book'
        ]);
        $this->assertDatabaseHas('books',[
            'title'=> 'My new Book'
        ]);
    }
    /** @test */
    public function can_update_books(){
        $book = Book::factory()->create();

        $this->patchJson(route('books.update',$book),[])
            ->assertJsonValidationErrorFor('title');

        $this->patchJson(route('books.update',$book),[
            'title'=>'book edite'
        ])->assertJsonFragment([
            'title'=>'book edite'
        ]);
        $this->assertDatabaseHas('books',[
            'title'=>'book edite'
        ]);
    }
    /** @test */
    public function can_delete_books(){
        $book = Book::factory()->create();

        $this->deleteJson(route('books.destroy',$book))->assertNoContent();

        $this->assertDatabaseCount('books',0);
    }
}
