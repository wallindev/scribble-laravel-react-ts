<?php

namespace App\Repositories;

use App\Interfaces\ArticleRepositoryInterface;
use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;

class ArticleRepository implements ArticleRepositoryInterface {
  public function getAllArticles(): Collection {
    return Article::all();

    // For API
    // return Article::all()->toArray();
  }

  public function getArticleById(int $id): ?Article {
    return Article::findOrFail($id);
  }

  public function createArticle(array $data): Article {
    return Article::create($data);
  }

  public function updateArticle(int $id, array $data): bool {
    $article = $this->getArticleById($id);
    return $article ? $article->update($data) : false;
  }

  public function deleteArticle(int $id): bool {
    $article = $this->getArticleById($id);
    return $article ? $article->delete() : false;
  }

  // For API
  // public function getAllArticles(): array
}
