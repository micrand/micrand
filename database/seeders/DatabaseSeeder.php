<?php

namespace Database\Seeders;

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $author = User::query()->firstOrCreate(
            ['email' => 'mickael@micrandria.test'],
            [
                'name' => 'Mickael Randriamihaja',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        );

        $categories = collect([
            'Software Engineering',
            'Architecture',
            'DevOps',
            'Digital Products',
        ])->mapWithKeys(function (string $name): array {
            $category = Category::query()->firstOrCreate(
                ['slug' => str()->slug($name)],
                [
                    'name' => $name,
                    'description' => "Articles about {$name}.",
                    'meta_title' => $name . ' — Micrandria',
                    'meta_description' => "Articles and insights about {$name}.",
                ],
            );

            return [$name => $category];
        });

        $tags = collect([
            'Laravel',
            'PHP',
            'PostgreSQL',
            'DevOps',
            'Architecture',
            'Software Engineering',
            'Web Development',
            'Digital Products',
            'Testing',
            'Automation',
        ])->mapWithKeys(function (string $name): array {
            $tag = Tag::query()->firstOrCreate(
                ['slug' => str()->slug($name)],
                ['name' => $name],
            );

            return [$name => $tag];
        });

        $posts = [
            [
                'title' => 'Building Maintainable Laravel Applications',
                'category' => 'Software Engineering',
                'tags' => ['Laravel', 'PHP', 'Software Engineering'],
                'status' => PostStatus::PUBLISHED,
                'published_at' => now()->subDays(30),
            ],
            [
                'title' => 'Designing a Clean Application Architecture',
                'category' => 'Architecture',
                'tags' => ['Architecture', 'Software Engineering'],
                'status' => PostStatus::PUBLISHED,
                'published_at' => now()->subDays(24),
            ],
            [
                'title' => 'PostgreSQL in Modern Web Applications',
                'category' => 'Software Engineering',
                'tags' => ['PostgreSQL', 'PHP', 'Web Development'],
                'status' => PostStatus::PUBLISHED,
                'published_at' => now()->subDays(18),
            ],
            [
                'title' => 'Practical DevOps for Small Development Teams',
                'category' => 'DevOps',
                'tags' => ['DevOps', 'Automation'],
                'status' => PostStatus::PUBLISHED,
                'published_at' => now()->subDays(14),
            ],
            [
                'title' => 'Testing Laravel Applications with Confidence',
                'category' => 'Software Engineering',
                'tags' => ['Laravel', 'Testing', 'PHP'],
                'status' => PostStatus::PUBLISHED,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Building Better Digital Products',
                'category' => 'Digital Products',
                'tags' => ['Digital Products', 'Web Development'],
                'status' => PostStatus::PUBLISHED,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Planning the Next Iteration of the Platform',
                'category' => 'Digital Products',
                'tags' => ['Digital Products', 'Architecture'],
                'status' => PostStatus::DRAFT,
            ],
            [
                'title' => 'Infrastructure Improvements to Explore',
                'category' => 'DevOps',
                'tags' => ['DevOps', 'Automation'],
                'status' => PostStatus::DRAFT,
            ],
            [
                'title' => 'Lessons from a Software Migration',
                'category' => 'Architecture',
                'tags' => ['Architecture', 'PostgreSQL'],
                'status' => PostStatus::DRAFT,
            ],
            [
                'title' => 'An Older Approach to Application Deployment',
                'category' => 'DevOps',
                'tags' => ['DevOps', 'Web Development'],
                'status' => PostStatus::ARCHIVED,
                'published_at' => now()->subYear(),
            ],
        ];

        foreach ($posts as $data) {
            $post = Post::query()->updateOrCreate(
                ['slug' => str()->slug($data['title'])],
                [
                    'user_id' => $author->id,
                    'category_id' => $categories[$data['category']]->id,
                    'title' => $data['title'],
                    'excerpt' => 'A practical article about ' . strtolower($data['title']) . '.',
                    'content' => $this->articleContent($data['title']),
                    'status' => $data['status'],
                    'published_at' => $data['published_at'] ?? null,
                    'meta_title' => $data['title'] . ' — Micrandria',
                    'meta_description' => 'Technical insights about ' . strtolower($data['title']) . '.',
                ],
            );

            $post->tags()->sync(
                collect($data['tags'])
                    ->map(fn (string $tag) => $tags[$tag]->id)
                    ->all(),
            );
        }
    }

    private function articleContent(string $title): string
    {
        return <<<HTML
<h2>{$title}</h2>

<p>
This article explores practical approaches, architectural decisions,
and lessons learned while building reliable digital products.
</p>

<p>
The objective is to keep the implementation understandable, maintainable,
and aligned with real-world engineering constraints.
</p>

<h3>Key principles</h3>

<ul>
    <li>Keep the architecture simple and explicit.</li>
    <li>Favor maintainable solutions over unnecessary complexity.</li>
    <li>Automate repetitive and error-prone operations.</li>
    <li>Use tests to protect important business behavior.</li>
</ul>
HTML;
    }
}