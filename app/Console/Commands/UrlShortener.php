<?php

namespace App\Console\Commands;

use App\Http\Controllers\UrlShortnerApiController;
use App\UrlShortenerApi;
use Illuminate\Console\Command;

class UrlShortener extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'url:url_short';

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
     * @return mixed
     */
    public function handle()
    {
       /* $url = new UrlShortenerApi();
        $url->getGoogleURLAPI(env("API_KEY"));
        $shortDWName = $url->getShorten("http://localhost/phpmyadmin/#PMAURL-32:sql.php?db=api_system&table=locations&server=1&target=&token=ac6c352603e8b5e241bab7ae76919c09l");
        dd($shortDWName);*/
    }
}
