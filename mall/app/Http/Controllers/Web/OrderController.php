<?php
namespace Bedrock\Http\Controllers\Web;

class OrderController extends BaseController
{
    public function index()
    {
        return view('admin.order.index');
    }

}
