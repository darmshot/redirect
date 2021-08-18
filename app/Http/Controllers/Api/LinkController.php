<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LinkStoreRequest;
use App\Services\Link as LinkService;

class LinkController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param LinkStoreRequest $request
     * @param LinkService $service
     *
     * @return \Illuminate\Http\Response
     */
    public function store(LinkStoreRequest $request, LinkService $service)
    {
        $url = $request->input('url');

        $shortUrl = $service->getShortUrl($url);

        return response([
            'shortUrl' => $shortUrl
        ]);
    }


    public function redirect($key, LinkService $service)
    {
        $fullUrl = $service->getFullUrl($key);

        if(empty($fullUrl)){
               abort(404);
        }

        return redirect($fullUrl, 301);
    }

}
