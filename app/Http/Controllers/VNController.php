<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Weidner\Goutte\GoutteFacade;

class VNController extends Controller
{
    public function index()
    {
        $crawler = GoutteFacade::request('GET', 'https://vnexpress.net/khoa-hoc/phat-minh');
        $links = $crawler->filter('h2.title-news a')->each(function ($node) {
            return $node->attr('href');
        });

        foreach ($links as $link){
            $this->scrapeData($link);
        }
        return back()->with('message','Lấy dữ liệu thành công!');
    }

    protected function crawlData(string $type, $crawler){
        $result = $crawler->filter($type)->each(function ($node){
            return $node->text();
        });

        if (!empty($result)){
            return $result[0];
        }
        return '';
    }

    public function crawlImage(string $type, $crawler){
        $result = $crawler->filter($type)->each(function ($node){
            return $node->attr('data-src');
        });

        if (!empty($result)){
            return $result[0];
        }
        return '';
    }

    public function scrapeData($url){
        $crawler = GoutteFacade::request('GET', $url);

        $title = $this->crawlData('h1.title-detail', $crawler);

        $content = $this->crawlData('p.description', $crawler);

        $description = $this->crawlData('article.fck_detail', $crawler);

        $thumbnail = $this->crawlImage('div.fig-picture img', $crawler);

        $dataPost = [
            'title' => $title,
            'content' => $content,
            'description' => $description,
            'thumbnail' => $thumbnail
        ];

        Post::create($dataPost);
    }
}
