$articleComment = Searchy::search('article_comment')
                    ->fields('content')
                    ->select('article_id')
                    ->query($keyword)
                    ->get();
            
            $commentArticleId = [];
            $articleIdArr = [];
            $articles = [];
            if ($articleComment) {
                foreach ($articleComment as $key => $comment) {
                    $commentArticleId[] = $comment->article_id;
                }
            }
            array_unique($commentArticleId);
            $articles1 = Searchy::search('article')
                    ->fields('title', 'content')
                    ->select('id', 'title', 'description', 'comment', 'created_at')
                    ->query($keyword)
                    ->get();
            if ($commentArticleId) {
                if ($articles1) {
                    foreach ($articles1 as $article) {
                        if (!in_array($article->id, $commentArticleId)) {
                            $articleIdArr[] = $article->id;
                        }
                    }
                } else {
                    $articleIdArr = $commentArticleId;
                }
                if ($articleIdArr) {
                    $articles2 = Article::select('id', 'title', 'description', 'comment', 'created_at')
                            ->whereIn('id', $articleIdArr)
                            ->orderBy('created_at', 'DESC')
                            ->get()->toArray();
                    if($articles2){
                        $articles = array_merge($articles1,$articles2);
                    }
                }
            }else{
                $articles = $articles1;
            }
        } else {
            $articles = Article::select('id', 'title', 'description', 'comment', 'created_at')
                    ->orderBy('created_at', 'DESC')
                    ->get();
        }