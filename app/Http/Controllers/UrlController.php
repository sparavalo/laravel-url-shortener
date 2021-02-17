<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use App\Models\UrlShort;

class UrlController extends Controller
{
    public function shortUrl(UrlRequest $request): Object
    {
        $short = UrlShort::where('redirect_url', $request->redirect_url)->first();

        if ($short == null) {
            $short = new UrlShort;
            $short->redirect_url = $request->redirect_url;
            $short->slug = $this->slugGenerator();
            $short->save();
        }

        $shortUrl = request()->getSchemeAndHttpHost() . '/' . $short->slug;

        return response()->json(['shortUrl' => $shortUrl], 200);
    }

    public function handleRedirect($slug)
    {
        $url = UrlShort::where('slug', $slug)->first();
        if ($url == null) {
            abort(404);
        }
        return redirect()->to($url->redirect_url);
    }

    private function slugGenerator(int $length = 7): string
    {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }

}
