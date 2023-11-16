<?php

declare(strict_types=1);

namespace App\Models;

class current_ranking extends ActiveRecord
{
    public int $category;
    public string $data;
    public string $time;
}