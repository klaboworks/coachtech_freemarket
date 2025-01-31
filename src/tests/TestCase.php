<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\Category;
use App\Models\CategoryItem;
use App\Models\Condition;
use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function createUser()
    {
        return User::factory()->create();
    }

    protected function login()
    {
        /** @var \App\Models\User $user */
        $user = $this->createUser();
        $this->actingAs($user);

        return $user;
    }

    protected function seedItems()
    {
        Category::factory()->create();
        Condition::factory()->create();
        Item::factory(10)->create();
        CategoryItem::factory()->create();
        Comment::factory()->create();
    }
}
