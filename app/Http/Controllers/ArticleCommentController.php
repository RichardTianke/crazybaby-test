<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use App\ArticleComment;
use Illuminate\Http\Request;
use App\Article;

class ArticleCommentController extends BaseController {

    use AuthorizesRequests,
        AuthorizesResources,
        DispatchesJobs,
        ValidatesRequests;
    
    public function index(Request $request) {
        $article_id = $request->input('article_id');
        $rules = [
            'article_id' => 'required|numeric',
        ];
        $messages = [
            'article_id.required' => '文章ID错误',
            'article_id.numeric' => '文章ID必须为数值',
        ];
        $this->validate($request, $rules, $messages);
        $comments = ArticleComment::select('id', 'author', 'content', 'created_at')->where('article_id', $article_id)->where('status', 1)->orderBy('created_at', 'DESC')->get();
        return response()->json($comments);
    }

    

    public function create() {
        $csrf_field = csrf_field();
        $html = <<<GET
        <form class="form-horizontal">
                    {$csrf_field}
                    <div class="control-group comment-author-section">
                        <label class="control-label">昵称</label>
                        <div class="controls">
                            <input type="text" class="comment-author" placeholder="昵称">
                            <span class="help-inline comment-author-error"></span>
                        </div>
                    </div>
                    <div class="control-group comment-content-section">
                        <label class="control-label">内容</label>
                        <div class="controls">
                            <textarea class="comment-content"></textarea>
                            <span class="help-inline comment-content-error"></span>
                        </div>
                    </div>
                </form>
GET;
        return $html;
    }

    public function store(Request $request) {
        $article_id = $request->input('article_id');
        $author = $request->input('author');
        $content = $request->input('content');
        $rules = [
            'article_id' => 'required|numeric',
            'author' => 'required|max:255',
            'content' => 'required',
        ];
        $messages = [
            'article_id.required' => '文章ID错误',
            'article_id.numeric' => '文章ID必须为数值',
            'author.required' => '必须填写昵称',
            'author.max' => '昵称太长。',
            'content.required' => '内容不能为空',
        ];
        $this->validate($request, $rules, $messages);
        $articleComment = new ArticleComment();
        $articleComment->article_id = $article_id;
        $articleComment->author = htmlspecialchars(addslashes($author));
        $articleComment->content = htmlspecialchars(addslashes($content));
        $articleComment->status = 1;
        if($articleComment->save()){
            $article = Article::find($article_id);
            $article->comment ++;
            $article->save();
            return response()->json(['status' => true, 'code' => 0, 'error' => '']);
        }
    }

    public function missingMethod($parameters = array()) {
        return "This is a missing method";
    }

}
