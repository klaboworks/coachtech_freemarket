<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Category;
use App\Models\CategoryItem;
use App\Models\Condition;
use App\Models\Comment;
use App\Models\Item;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function createUser()
    {
        return User::factory()->create();
    }

    protected function seedItems()
    {
        Item::factory()->create();
    }
}
