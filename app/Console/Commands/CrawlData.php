<?php

namespace App\Console\Commands;

use App\Models\Post;
use Goutte\Client;
use Illuminate\Console\Command;
use Weidner\Goutte\GoutteFacade;

class CrawlData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawl:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $crawler = GoutteFacade::request('GET', 'https://vnexpress.net/khoa-hoc/phat-minh');
        $links = $crawler->filter('h2.title-news a')->each(function ($node) {
            return $node->attr('href');
        });

        foreach ($links as $link){
//            print_r($link . "\n");
            $this->scrapeData($link);
        }
        $this->line('Ăn cắp dữ liệu thành công! Mời bạn mau chóng chỉnh sửa cho hợp lý!');
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
