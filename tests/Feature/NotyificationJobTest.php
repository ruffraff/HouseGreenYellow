<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\Notification;
use App\Jobs\NotificationJob;
use App\Models\User;
use App\Notifications\BookingNotification;
use App\Mail\NewBookingNotification;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
class NotyificationJobTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $user = User::find(1);
        $user->notify(new BookingNotification());
        Log::error("test notification before". $user->name ."". $user->email ."notification");
//DB::table('contacts')->insert(['name'=>'Stefano','email'=>'stefano.ruffolo@gmail.com','message'=>'test','address'=>'via roma 1']);
$query = DB::table('contacts')->select('name','email','message','address')->where('name','=','Stefano')->get();
Log::error("test notification". $query);
         Mail::to($user->email)->send(new NewBookingNotification());
Cache::put('contact', $query , 10);

$query2 = Cache::get('contact');
Log::error("test notification query2". $query2);
         // Creare un utente di test
         

         // Eseguire il job
        //  $job = new NotificationJob(/* parametri */);
        //  $job->handle();
 
         // Assicurarsi che la notifica sia stata inviata
        //  $this->assertDatabaseHas('notifications', [
        //      'type' => BookingNotification::class,
        //      'notifiable_id' => $user->id,
        //      'notifiable_type' => User::class,
        //      // Altri campi della notifica se necessari
        //  ]);
    }
}
