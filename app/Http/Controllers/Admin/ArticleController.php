<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Interfaces\ArticleRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticleController extends AdminController {
  protected $articleRepository;
  protected $userRepository;

  public function __construct(ArticleRepositoryInterface $articleRepository, UserRepositoryInterface $userRepository) {
    // To call the parent class constructor (AdminController)
    // parent::__construct();
    $this->articleRepository = $articleRepository;
    $this->userRepository = $userRepository;
  }

  public function index(Request $request) {
    $articles = $this->articleRepository->getAllArticles();

    $title = 'Articles';
    $breadcrumbs = [
      ...$this->breadcrumbs,
      '/admin' => 'Admin',
      '/admin/articles' => 'Articles'
    ];
    return view('admin.articles.index', compact('articles', 'title', 'breadcrumbs'));

    // For API
    // return response()->json($users);
    // if ($request->wantsJson()) {
    //   return ArticleResource::collection($articles);
    // }
  }

  public function show($id) {
    $article = $this->articleRepository->getArticleById($id);

    $title = 'Show Article';
    $breadcrumbs = [
      ...$this->breadcrumbs,
      '/admin' => 'Admin',
      '/admin/articles' => 'Articles',
      "/admin/articles/$id" => "Article $id"
    ];
    return view('admin.articles.show', compact('article', 'title', 'breadcrumbs'));

    // For API
    // return $article ? response()->json($article) : response()->json(['message' => 'Article not found'], 404);
  }

  public function edit($id) {
    $article = $this->articleRepository->getArticleById($id);

    $title = 'Edit Article';
    $breadcrumbs = [
      ...$this->breadcrumbs,
      '/admin' => 'Admin',
      '/admin/articles' => 'Articles',
      "/admin/articles/$id" => "Article $id",
      "/admin/articles/$id/edit" => "Edit Article $id"
    ];
    $users = $this->userRepository->getAllUsers();
    return view('admin.articles.edit', compact('article', 'title', 'breadcrumbs', 'users'));
  }

  public function update(ArticleRequest $request, $id) {
    $data = $request->validated();

    try {
      $this->articleRepository->updateArticle($id, $data);
      return redirect()->route('articles.show', $id)->with('success', 'Article updated successfully!');
    } catch (Exception $e) {
      Log::error('Error updating article: ' . $e->getMessage());
      return back()->withErrors(['update' => 'Failed to update the article. Please try again.']);
    }

    // For API
    // return $updated ?
    // response()->json(['message' => 'Article updated successfully']) :
    // response()->json(['message' => 'Article not found'], 404);
  }

  public function create() {
    $title = 'Create Article';
    $breadcrumbs = [
      ...$this->breadcrumbs,
      '/admin' => 'Admin',
      '/admin/articles' => 'Articles',
      "/admin/articles/new" => 'Create Article'
    ];
    $users = $this->userRepository->getAllUsers();
    return view('admin.articles.create', compact('title', 'breadcrumbs', 'users'));
  }

  public function store(ArticleRequest $request) {
    $data = $request->validated();

    try {
      $this->articleRepository->createArticle($data);
      return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    } catch (Exception $e) {
      Log::error('Error creating article: ' . $e->getMessage());
      return back()->withErrors(['create' => 'Failed to create the article. Please try again.']);
    }

    // For API
    // return response()->json($article, 201);
  }

  public function destroy($id) {
    try {
      $this->articleRepository->deleteArticle($id);
      return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    } catch (Exception $e) {
      Log::error('Error deleting article: ' . $e->getMessage());
      return back()->withErrors(['delete' => 'Failed to delete the article. Please try again.']);
    }

    // For API
    // return $deleted ?
    // response()->json(['message' => 'Article deleted successfully']) :
    // response()->json(['message' => 'Article not found'], 404);
  }
}
