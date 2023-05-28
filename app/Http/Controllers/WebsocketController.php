<?php

namespace App\Http\Controllers;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Models\Chat;

class WebsocketController extends Controller
{
    public function index()
    {
        require base_path() . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
        $server = IoServer::factory(new HttpServer(new WsServer(new Chat())),8080);
    }
}