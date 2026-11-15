<?php

namespace Tests\Feature\Admin;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Storage::fake('public');
    }

    public function test_authenticated_user_can_view_article_index(): void
    {
        Article::create([
            'title' => 'Chasing Natural Light',
            'content' => 'Sample article content about natural lighting in Sydney.',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->user)->get(route('admin.articles.index'));

        $response->assertOk()
            ->assertViewIs('admin.articles.index')
            ->assertSee('Chasing Natural Light');
    }

    public function test_article_content_is_sanitized_against_xss(): void
    {
        $cover = UploadedFile::fake()->image('cover.jpg', 1200, 630);

        $xssContent = '<h2>Safe Title</h2><p>Normal text</p><script>alert("xss")</script><p onload="bad()">Tainted</p><a href="javascript:alert(1)">Click</a>';

        $response = $this->actingAs($this->user)->post(route('admin.articles.store'), [
            'title' => 'Security Test Article',
            'content' => $xssContent,
            'cover_image' => $cover,
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.articles.index'));

        $article = Article::where('title', 'Security Test Article')->first();
        $this->assertNotNull($article);

        // Assert script and malicious handlers are stripped
        $this->assertStringNotContainsString('<script>', $article->content);
        $this->assertStringNotContainsString('onload=', $article->content);
        $this->assertStringNotContainsString('javascript:', $article->content);
        $this->assertStringContainsString('<h2>Safe Title</h2>', $article->content);
    }

    public function test_authenticated_user_can_update_article(): void
    {
        $article = Article::create([
            'title' => 'Old Title',
            'content' => 'Old content',
            'is_published' => false,
        ]);

        $response = $this->actingAs($this->user)->put(route('admin.articles.update', $article), [
            'title' => 'Updated Article Title',
            'content' => 'Updated article content.',
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.articles.index'));
        $article->refresh();
        $this->assertEquals('Updated Article Title', $article->title);
        $this->assertTrue($article->is_published);
    }

    public function test_authenticated_user_can_toggle_article_status(): void
    {
        $article = Article::create([
            'title' => 'Toggle Article',
            'content' => 'Content',
            'is_published' => false,
        ]);

        $this->actingAs($this->user)->patch(route('admin.articles.toggle', $article), [
            'field' => 'is_published',
        ]);

        $article->refresh();
        $this->assertTrue($article->is_published);
        $this->assertNotNull($article->published_at);
    }

    public function test_authenticated_user_can_soft_delete_article(): void
    {
        $article = Article::create([
            'title' => 'To Be Trashed',
            'content' => 'Content',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->user)->delete(route('admin.articles.destroy', $article));

        $response->assertRedirect(route('admin.articles.index'));
        $this->assertSoftDeleted('articles', ['id' => $article->id]);
    }
}
