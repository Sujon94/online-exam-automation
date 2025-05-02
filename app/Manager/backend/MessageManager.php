<?php


namespace App\Manager\backend;


use App\Contract\backend\MessageContract;
use App\Entities\backend\Contact;
use Illuminate\Support\Facades\Request;

class MessageManager implements MessageContract
{
    public $contact;
    public function __construct()
    {
        $this->contact = new Contact();
    }

    public function delete($messageId): array
    {
        try {
            $this->contact->where('contact_id',$messageId)->delete();
        }catch (\Exception $e){
            return ["status" => '99', "message" => $e->getMessage()];
        }
        return ["status" => '1', "message" => 'Message Removed'];
    }
}