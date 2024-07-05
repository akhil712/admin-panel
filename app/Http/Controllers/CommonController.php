<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Helpers\Helper;



class CommonController extends Controller
{
    public function addComponent(Request $request)
    {
        $pid = base64_decode(urldecode($request->get('pid')));
        $page = Helper::getAddPageById($pid);

        /* data MEAN json encoded data,
        pid mean page id 
        len mean page length */
        $len = $request->get('len');
        if ($len >= $page['limit']) {
            $return['status'] = false;
            $return['msg'] = 'You have exceeded the page limit';
            return $return;
        }
        if ($page != "") {
            if ($pid == config('addPages.route.id')) {
                $data = json_decode($request['data'], true);
                $data['id'] = hrtime(true);
                $data['routes'] = Helper::getRouteNames();
            } else {
                $data['id'] = $request->get('len');
            }
            $data['new'] = true;
            $return['view'] = view($page['name'], $data)->render();
            $return['status'] = true;
            return $return;
        }
    }
}
