<?php

namespace App\Helper;
use App\Events\ReadyEvent;
use App\Events\MessageEvent;
use App\Events\QrEvent;
use Illuminate\Http\Request;

class Sockets {

	public function ready (Request $request) {
		
		$event = new ReadyEvent($request->post());
		broadcast($event);
	}

	public function qr (Request $request) {

		$event = new QrEvent($request->token);
		broadcast($event);
	}

	public function message (Request $request) {

		$content = (object) [
			'message' => $request->message,
			'admin' => $request->admin
		];

		$event = new MessageEvent($content);
		broadcast($event);
	}
}

?>