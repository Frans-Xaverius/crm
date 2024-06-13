<?php

namespace App\Helper;
use App\Events\ReadyEvent;
use Illuminate\Http\Request;

class Sockets {

	public function ready (Request $request) {
		
		$event = new ReadyEvent($request->post());
		broadcast($event);
	}
}

?>