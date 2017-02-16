<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use App\Article;
use Illuminate\Http\Request;
use App\ArticleComment;

class ArticleController extends BaseController {

    use AuthorizesRequests,
        AuthorizesResources,
        DispatchesJobs,
        ValidatesRequests;

    public function index(Request $request) {
        $keyword = $request->input('keyword');
        if ($keyword) {
            $rules = [
                'keyword' => 'max:255',
            ];
            $messages = [
                'keyword.max' => '关键字长度错误',
            ];
            $this->validate($request, $rules, $messages);
            $keyword = trim($keyword);
            $keyword = htmlspecialchars(addslashes($keyword));
            $articleIdArr = [];
            $articleComments = ArticleComment::select('article_id')
                    ->where('content', 'like', "%{$keyword}%")
                    ->where('status', 1)
                    ->get();
            foreach ($articleComments as $key => $comment) {
                $articleIdArr[] = $comment->article_id;
            }
            array_unique($articleIdArr);
            if ($articleIdArr) {
                $articles = Article::select('id', 'title', 'description', 'comment', 'created_at')
                        ->whereIn('id', $articleIdArr)
                        ->orWhere('title', 'like', "%{$keyword}%")
                        ->orWhere('content', 'like', "%{$keyword}%")
                        ->where('status', 1)
                        ->orderBy('created_at', 'DESC')
                        ->get();
            }else{
                $articles = Article::select('id', 'title', 'description', 'comment', 'created_at')
                        ->where('title', 'like', "%{$keyword}%")
                        ->orWhere('content', 'like', "%{$keyword}%")
                        ->where('status', 1)
                        ->orderBy('created_at', 'DESC')
                        ->get();
            }
        } else {
            $articles = Article::select('id', 'title', 'description', 'comment', 'created_at')
                    ->where('status', 1)
                    ->orderBy('created_at', 'DESC')
                    ->get();
        }
        return response()->json($articles);
    }

    public function show($id) {
        $article = Article::select('id', 'title', 'content', 'author', 'comment', 'created_at')->where('id', $id)->where('status', 1)->first();
        $article->content = nl2br($article->content);
        return response()->json($article);
    }

    public function create() {
        $csrf_field = csrf_field();
        $html = <<<GET
        <form method="post" class="form-horizontal">
                    {$csrf_field}
                    <div class="control-group article-title-section">
                        <label class="control-label">文章标题</label>
                        <div class="controls">
                            <input type="text" class="article-title" placeholder="文章标题">
                            <span class="help-inline article-title-error"></span>
                        </div>
                    </div>
                    <div class="control-group article-author-section">
                        <label class="control-label">作者</label>
                        <div class="controls">
                            <input type="text" class="article-author" placeholder="作者">
                            <span class="help-inline article-author-error"></span>
                        </div>
                    </div>
                    <div class="control-group article-description-section">
                        <label class="control-label">简述</label>
                        <div class="controls">
                            <textarea class="article-description" rows="5"></textarea>
                            <span class="help-inline article-description-error"></span>
                        </div>
                    </div>
                    <div class="control-group article-content-section">
                        <label class="control-label">内容</label>
                        <div class="controls">
                            <textarea class="article-content" style="width:500px;" rows="10"></textarea>
                            <span class="help-inline article-content-error"></span>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls">
                            <button type="button" class="btn btn-success article-create-btn">创建文章</button>
                        </div>
                    </div>
                    
                </form>
GET;
        return $html;
    }

    public function store(Request $request) {

        $title = $request->input('title');
        $author = $request->input('author');
        $description = $request->input('description');
        $content = $request->input('content');
        $rules = [
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'description' => 'required|max:255',
            'content' => 'required',
        ];
        $messages = [
            'title.required' => '必须填写文章标题',
            'title.max' => '文章标题太长',
            'author.required' => '必须填写文章作者',
            'author.max' => '文章作者太长',
            'description.required' => '必须填写文章简述',
            'description.max' => '文章简述太长',
            'content.required' => '内容不能为空',
        ];
        $this->validate($request, $rules, $messages);
        $article = new Article();
        $article->title = htmlspecialchars(addslashes($title));
        $article->author = htmlspecialchars(addslashes($author));
        $article->description = htmlspecialchars(addslashes($description));
        $article->content = htmlspecialchars(addslashes($content));
        $article->status = 1;

        if ($article->save()) {
            return response()->json(['status' => true, 'code' => 0, 'error' => '']);
        }
    }

    public function missingMethod($parameters = array()) {
        return "This is a missing method";
    }

}
