<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public $eskalasi;
    public $role;

    public function __construct() {
        $this->eskalasi = [
            'ab8c8598-389a-4917-8cfb-5635b61d7f00' => 'Humas',
            'd1463735-f2fe-433c-96bb-19901e9804a1' => 'Keuangan'
        ];
        
        $this->role = [
            'supervisor' => 'Super Admin',
            'admin' => 'Admin Chanel',
            'agent' => 'Admin Divisi'
        ];

        $this->q_acc = [
            'ab8c8598-389a-4917-8cfb-5635b61d7f00' => [
                'email' => 'humassatu@gmail.com',
                'password' => 'b!05H0Ck'
            ],
            'd1463735-f2fe-433c-96bb-19901e9804a1' => [
                'email' => 'keuangansatu@gmail.com',
                'password' => 'b!05H0Ck'
            ],
            '49ce0993-b2bb-42af-ba20-9325346cccfa' => [
                'email' => 'q@gmail.com',
                'password' => 'b!05H0Ck'
            ],
            'd87add30-95f2-4fdd-b7da-5ffc76c1ae6e' => [
                'email' => 'qq@gmail.com',
                'password' => 'b!05H0Ck'
            ],

            'b1c232e5-0d02-4d76-9c42-846932a0227b' => [
                'email' => 'qqq@gmail.com',
                'password' => 'b!05H0Ck'
            ],
            '1a900c8f-8f4e-409a-af8a-55289ae87e0d' => [
                'email' => 'qqqq@gmail.com',
                'password' => 'b!05H0Ck'
            ],
            '84f62329-f46a-4762-ae95-5ec72a2f9b52' => [
                'email' => 'qqqqq@gmail.com',
                'password' => 'b!05H0Ck'
            ],
            'a489bf50-13c1-4d1c-818f-6169399e62b5' => [
                'email' => 'qqqqqq@gmail.com',
                'password' => 'b!05H0Ck'
            ],
        ];

        $this->app = [
            'fb' => 'Facebook',
            'ig' => 'Instagram',
            'wa' => 'WhatsApp Business',
            'wa_cloud' => 'WhatsApp Business',
            'cc' => 'Call Center',
            'web_chat' => 'Web Chat',
            'email' => 'Email'
        ];
    }
}
