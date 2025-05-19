<?php

namespace App\Interfaces;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

interface ArticleRepositoryInterface {
  public function getAllArticles(): Collection;
  public function getArticleById(int $id): ?Article;
  public function createArticle(array $data): Article;
  public function updateArticle(int $id, array $data): bool;
  public function deleteArticle(int $id): bool;

  // For API
  // public function getAllArticles(): array
}
